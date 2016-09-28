<?php  
/**
* Project: IT Instructor Evaluations
* File: EvaluationSheetManager.php
* Authors: James Staab and Craig Koch 
* Date: 03/31/2016
* 
* This manages Evaluation Sheets
*/
require_once('EvaluationSheet.php');
class EvaluationSheetManager
{
	private $evaluationSheet;
	
	function isEvaluationInProgress()
	{
		return isset($_SESSION['evalSheet']);
	}

	function loadEvaluation()
	{
		if(isset($_SESSION['evalSheet']))
		{
			$this->evaluationSheet = unserialize($_SESSION['evalSheet']);
		}

		if(!isset($this->evaluationSheet))
		{
			$this->startEvaluation('damnit');
		}
	}
	//This is used to take test from a supplied guid
	function startEvaluation($guid)
	{
		$this->evaluationSheet = new EvaluationSheet();
		$this->evaluationSheet->getQuestions($guid);
		$_SESSION['evalSheet'] = serialize($evaluationSheet);
	}

	function vardump()
	{
		echo "<pre>";
		var_dump($this->evaluationSheet);
		echo "</pre>";
	}

	//This function is meant to validate Evaluation, if it is finished it will be submitted, otherwise they will
	//be returned to the form with the errors present
	function validateEvaluation() : bool
	{
		if(isset($_POST['submitEval']))
		{
			$isValid = $this->evaluationSheet->validateQuestions();
		}
		else
		{
			$isValid = false;
		}
		return $isValid;
	}

	function displayEvaluation()
	{
		$this->evaluationSheet->printQuestions();	
	}

	//Used by instructors to create a new test
	function createNewEvaluation()
	{

	}

	//Generate an amount of tests for a test
	function generateTestCodes($testID, $numberOfTests)
	{

	}

	//get a list of all of the tests
	function getTestList()
	{

	}

	//Used to get Results for a specific test
	function getResults($testID)
	{

	}
}

?>