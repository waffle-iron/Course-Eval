<?php

require_once('assets/classes/DBResponse.php');

class CreateEvaluationModel
{
	
	private $router;

	public function __construct($router)
	{
		$this->router = $router;
	}

	public function getLastInsertedID()
	{
		return $this->router->get('DB')->lastInsertId();
	}

	public function writeToEvaluationInfo($className, $quarter, $year, $section, $notes)
	{
		//$response = new DBResponse;

		$sqlEvalInfoStatment = "INSERT INTO evaluationInfo (name,quarter,year,section,notes,userID)VALUES(:className,:quarter,:year,:section,:notes,:userID)";

		$params = array('className'=>$className,'quarter'=>$quarter,'year'=>$year,'section'=>$section,'notes'=>$notes, 'userID'=> $this->router->get('SESSION.userID'));

		$db = $this->router->get('DB');
		$db->exec($sqlEvalInfoStatment, $params);
		
		//echo $className.$quarter.$year.$section.$notes;
		
		//$response->setErr = $db->errorCode();

		return $db->lastInsertId();
	}

	public function setDefaultQuestionForEvaluation($evalID)
	{
		$sqlEvalQuestions = "INSERT INTO evaluationQuestions (evaluationID, questionID)
							 SELECT '{$evalID}', q.questionID from questions q";

		$db = $this->router->get('DB')->exec($sqlEvalQuestions);

		//return $db->errorCode();
	}

	public function setUpEvaluationCodes($evalID, $code, $expirationDate, $numberAvailable)
	{
		$sqlForEvalCodes = "INSERT INTO evaluationCodes (evaluationID, code, expirationDate, numberAvailable)VALUES (:evalID,:code,:expirationDate,:numberAvailable)";

		$params = array(':evalID' => $evalID, ':code' => $code, 'expirationDate' => $expirationDate, ':numberAvailable' => 100);

		$db = $this->router->get('DB')->exec($sqlForEvalCodes, $params);

		//return $db->errorCode();
	}

}