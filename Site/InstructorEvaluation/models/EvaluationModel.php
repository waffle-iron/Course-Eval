<?php  
class EvaluationModel
{
	private $router;
	private $evaluationCode;

	public function __construct($router)
	{
		$this->router = $router;
	}

	public function checkEvaluationCode($evaluationCode)
	{
		return $this->isEvaluationCodeValidOrExpired($evaluationCode);
	}


	public function getQuestionsForEvaluation($evaluationCode) : array
	{
		$questions;
		$sql = 
			'SELECT q.questionID, q.questionText, q.isFillIn '.
			'FROM questions q '.
			'JOIN evaluationQuestions e '.
			'on e.questionID = q.questionID '.
			'JOIN evaluationCodes eval '.
			'on eval.evaluationID = e.evaluationID '.
			'WHERE eval.code = :evaluationCode';
		$params = array('evaluationCode' => $evaluationCode);
		$questions = $this->router->get('DB')->exec($sql, $params);
		

		return $questions;
	}

	public function submitEvaluation($evaluationSheet)
	{
		$db = $this->router->get('DB');
		$sql = 
			'INSERT INTO evaluationAnswers'.
			'(instanceID, evaluationID, questionID, multipleChoiceOption, textAnswer)'.
			'VALUES'.
			'(:instanceID, :evaluationID, :questionID, :multipleChoiceOption, :textAnswer)';
		$evaluationID = $evaluationSheet->getEvaluationID();
		$instanceID = $evaluationSheet->getInstanceID();
		foreach($evaluationSheet->getQuestions() as $question)
		{
			if(!empty($question->inputAnswer))
			{
				$params = array(
					'instanceID' => $instanceID,
					'evaluationID' => $evaluationID,
					'questionID' => $question->questionID);
				if($question->isFillIn)
				{
					$params['multipleChoiceOption'] = 0;
					$params['textAnswer'] = $question->inputAnswer;
				}
				else
				{
					$params['multipleChoiceOption'] = $question->inputAnswer;
					$params['textAnswer'] = '';
				}

				$db->exec($sql, $params);
			}
		}
	}
	public function getEvaluationHeader($evaluationID)
	{
		$sql = "SELECT user.firstName, user.lastName, eval.name, eval.quarter, eval.year, eval.section ".
			"from evaluationInfo eval ".
			"JOIN users user on eval.userID = user.userID ".
			"WHERE eval.evaluationID = :evaluationID ".
			"LIMIT 1";

		$params = array("evaluationID" => $evaluationID);

		$values = $this->router->get("DB")->exec($sql, $params);
		return $this->formatHeder($values[0]);
	}

	public function formatHeder($header)
	{
		switch($header['quarter'])
		{
			case "1":
				$header['quarter'] = "Fall";
				break;
			case "2":
				$header['quarter'] = "Winter";
				break;
			case "3":
				$header['quarter'] = "Spring";
				break;	
			case "4":
				$header['quarter'] = "Summer";
				break;
		}

		$header['year'] = substr($header['year'], 0, 4)."-".substr($header['year'], 4);
		return $header;
	}


	public function isEvaluationCodeValidOrExpired($evaluationCode)
	{
		$sql = 
			"SELECT codeID, evaluationID, expirationDate 
			FROM evaluationCodes
			WHERE expirationDate > NOW()
			AND code = :code";
		$params = array('code' => $evaluationCode);
		$evaluationCodeCheck = $this->router->get('DB')->exec($sql, $params);
		if(isset($evaluationCodeCheck) && count($evaluationCodeCheck[0]) > 0)
		{
			return $evaluationCodeCheck[0];
		}
		return false;
	}


	private function setEvaluationCodeUsed($evaluationCode) : int
	{
		$sql = 
			"INSERT INTO usedEvaluationCodes 
			(codeID, evaluationID) 
			VALUES
			({$this->evaluationCodeCheckResults['codeID']}, {$this->evaluationCodeCheckResults['evaluationID']});";

		$db = $this->router->get('DB')->exec($sql);
		return $db->lastInsertId();

	}

}
?>