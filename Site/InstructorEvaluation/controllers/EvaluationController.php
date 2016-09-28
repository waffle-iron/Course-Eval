<?php
/**
* Project: IT Instructor Evaluations
* File: EvaluationController.php
* Authors: James Staab and Craig Koch 
* Date: 04/20/2016
* 
* This is the controller for Evaluation Sheets
*/

class EvaluationController
{
	private $evaluationSheet;
	private $router;
	private $evaluationCodeCheckResults;
	private $headerInfo;

	function __construct($router)
	{
		$this->router = $router;
	}

	function isEvaluationInProgress() : bool
	{
		return $this->router->get('SESSION.evalSheet') != NULL && $this->router->get('SESSION.evalSheet') != "N;";
	}

	function startEvaluation($evaluationCode)
	{
		if(isset($evaluationCode))
		{

			$model = new EvaluationModel($this->router);
			$evaluationCodeCheck = $model->isEvaluationCodeValidOrExpired($evaluationCode);

			if($evaluationCodeCheck)
			{

				$this->evaluationCodeCheckResults = $evaluationCodeCheck;
				$evaluationID = $this->evaluationCodeCheckResults['evaluationID'];
				
				//set session variable for this evaluation
				if($this->checkCookie($evaluationID))
				{

					
					$this->router->reroute("/?errorCode=EV1003");
					$this->renderEvaluationCodeEntryView();
					return;
				}
				//set cookie otherwise
				$this->setCookie($evaluationID, false);
				$headerInfo = $model->getEvaluationHeader($evaluationID);

				$instanceID = $this->setEvaluationCodeUsed($evaluationCode);
				
				//set evaluation sheet variables
				$this->evaluationSheet = new EvaluationSheet($evaluationCode);
				$this->evaluationSheet->setHeaderInfo($headerInfo);
				$this->evaluationSheet->setQuestions($this->getQuestionsForEvaluation($evaluationCode));
				$this->evaluationSheet->setInstanceID($instanceID);
				$this->evaluationSheet->setEvaluationID($evaluationID);
				$this->setViewParameters();
				$this->renderEvaluationView();
				return;
			}
		}

		$this->router->reroute("/?errorCode=EV1002");
	}

	function isEvaluationCodeValidOrExpired($evaluationCode) : bool
	{
		$sql = 
			"SELECT codeID, evaluationID, expirationDate, numberAvailable 
			FROM evaluationCodes
			WHERE expirationDate > NOW()
			AND code = :code";
		$params = array('code' => $evaluationCode);
		$evaluationCodeCheck = $this->router->get('DB')->exec($sql, $params);
		if(isset($evaluationCodeCheck) && count($evaluationCodeCheck[0]) > 0)
		{
			$sql = "SELECT COUNT(*) as used from usedEvaluationCodes WHERE codeID = :codeID";
			$params = array('codeID' => $evaluationCodeCheck[0]['codeID']);
			$numberUsed = $this->router->get('DB')->exec($sql, $params);
			if($numberUsed[0]['used'] < $evaluationCodeCheck[0]['numberAvailable'])
			{
				//saving to variable so to lessen sql load
				$this->evaluationCodeCheckResults = $evaluationCodeCheck[0];
				return true;
			}
		}
		return false;
	}

	function setEvaluationCodeUsed($evaluationCode) : int
	{
		$sql = 
			"INSERT INTO usedEvaluationCodes 
			(codeID, evaluationID) 
			VALUES
			(:codeID, :evaluationID);";
		$params = array('codeID' => $this->evaluationCodeCheckResults['codeID'], 
			'evaluationID' =>$this->evaluationCodeCheckResults['evaluationID']);

		$db = $this->router->get('DB');
		$value = $db->exec($sql, $params);
		return $db->lastInsertId();

	}

	public function getErrorCode($code)
	{
		switch ($code) {
			case "EV1000":
				$this->router->set('alert', "You must enter a code");
				$this->router->set('alertType', "danger");
				break;
			case "EV1001":
				$this->router->set('alert', 'Invalid or Expired code entered.');
				$this->router->set('alertType', 'danger');
				break;
			case "EV1002":
				$this->router->set('alert', "An error has occured, please contact your Instructor to let them know.");
				$this->router->set('alertType', "danger");
				break;
			case "EV1003":
				$this->router->set('alert', "You may only submit one evaluation per code.");
				$this->router->set('alertType', "danger");
				break;
		}
	}

	function validateEvaluation()
	{
		if($this->isEvaluationInProgress())
		{
			$loaded = $this->loadEvaluationFromSession();
			if(isset($loaded))
			{
				$isValid = $this->evaluationSheet->validateQuestions();
				$minAnswered = $this->evaluationSheet->hasMinimumQuestionsFilledOut();
				if($isValid && $minAnswered)
				{
					$this->setCookie($this->evaluationSheet->getEvaluationID(), true);
					$this->submitValidatedEvaluation();
				}
				else
				{
					if(!$minAnswered)
					{
						$this->router->set('alert', 'You must at least answer one question.');
						$this->router->set('alertType', 'danger');
					}

					$this->resumeEvaluation();
				}
			}
		}
	}

	function loadEvaluationFromSession() : bool
	{
		if($this->isEvaluationInProgress())
		{
			$this->evaluationSheet =  unserialize($this->router->get('SESSION.evalSheet'));
			return true;
		}
		return false;
	}

	function saveEvaluationToSession($evaluationSheet)
	{
		$this->router->set('SESSION.evalSheet', serialize($evaluationSheet));
	}

	function getEvaluationCode()
	{
		$error = $this->router->get('PARAMS');

		if(!empty($error))
		{
			$error = substr($error[0], strpos($error[0], "=")+ 1);
			$this->getErrorCode($error);
		}
		$this->renderEvaluationCodeEntryView();
	}

	function checkEvaluationCode($evaluationCode)
	{
		if(!isset($evaluationCode))
		{
			$this->router->reroute("/?errorCode=EV1000");
		}

		$evaluationModel = new EvaluationModel($this->router);
		$isValid = $evaluationModel->checkEvaluationCode($evaluationCode);
		if($isValid)
		{
			$this->router->reroute('/Evaluation/'.$evaluationCode);
		}
		else
		{
			$this->router->reroute("/?errorCode=EV1001");
		}
	}

	function resumeEvaluation()
	{
		$this->setViewParameters();
		$this->renderEvaluationView();
	}

	function getQuestionsForEvaluation($evaluationCode) : array
	{
		$questions;
		$model = new EvaluationModel($this->router);
		$questions = $model->getQuestionsForEvaluation($evaluationCode);

		return $questions;
	}

	function setViewParameters()
	{
		if(isset($this->evaluationSheet))
		{
			$questions = $this->evaluationSheet->getQuestions();
			$temp = array();
			foreach($questions as $question)
			{
				array_push($temp, get_object_vars($question));
			}
			if(isset($temp))
			{
				$this->router->set('evaluation' , $temp);
			}
		}
	}

	private function renderEvaluationCodeEntryView()
	{
		$this->router->set('formContent', 'views/enterEvaluationCode.php');
		$this->router->set('formID', 'evaluation');
		$this->router->set('formAction', '');
		$this->renderView();
	}

	private function renderEvaluationView()
	{
		$this->router->set('formContent', 'views/test.php');
		$this->router->set('formID', 'evaluation');
		$this->router->set('formAction', 'evaluation');
		$this->router->set('headerInfo', $this->evaluationSheet->getHeaderInfo());
		$this->renderView();
	}

	private function renderView()
	{
		$this->saveEvaluationToSession($this->evaluationSheet);
		$this->router->set('bodyContent', 'views/form.htm');
		$this->router->set('formMethod', 'POST');
		echo \Template::instance()->render('views/layout.php');
	}

	function submitValidatedEvaluation()
	{
		$model = new EvaluationModel($this->router);
		$submitted = $model->submitEvaluation($this->evaluationSheet);

		$this->router->reroute('@thanks');	
	}

	private function setCookie($evaluationID, $complete) : bool
	{
		if($this->checkCookie($evaluationID))
		{
			return false;
		}

		$this->router->set("SESSION.evaluations.".$evaluationID, $complete);
		return true;
	}

	private function checkCookie($evaluationID): bool
	{
		$value = $this->router->get("SESSION.evaluations.".$evaluationID);

		return ($value != null && $value == true);
	}

}

?>