<?php  
/**
* Project: IT Instructor Evaluations
* File: EvaluationSheet.php
* Authors: James Staab and Craig Koch 
* Date: 03/31/2016
* 
* This Holds all of the questions for the evaluation and is responsible for calling validation and submitting them.
*/
require_once('Question.php');
class EvaluationSheet
{
	private $questions;
	private $evaluationCode;
	private $instanceID;
	private $isValid = false;
	private $evaluationID;
	private $hasErrors = false;
	private $headerInfo;

	function __construct($evaluationCode)
	{
		$this->evaluationCode = $evaluationCode;
		$this->questions = array();
	}

	function getQuestions()
	{
		return $this->questions;
	}

	function setQuestions($questions)
	{
		foreach((array)$questions as $question)
		{
			$newQuestion = new Question($question['questionID'], $question['questionText'], $question['isFillIn']);
			array_push($this->questions, $newQuestion);
		}
	}

	function getEvaluationCode()
	{
		return $this->evaluationCode;
	}

	function getEvaluationID()
	{
		return $this->evaluationID;
	}

	function setEvaluationID($evaluationID)
	{
		$this->evaluationID = $evaluationID;
	}

	function getInstanceID()
	{
		return $this->instanceID;
	}

	function setInstanceID($instanceID)
	{
		$this->instanceID = $instanceID;
	}

	function getHeaderInfo()
	{
		return $this->headerInfo;
	}

	function setHeaderInfo($newHeader)
	{
		$this->headerInfo = $newHeader;
	}

	//This is used to call validate on all of the questions
	function validateQuestions() : bool
	{
		if(isset($this->questions))
		{
			$isValid = true;
			foreach($this->questions as $question)
			{
				$response = $question->validate();
				if(!$response)
				{
					$isValid = false;
				}
			}
			$this->hasErrors = $isValid;
		}
		else
		{
			$this->hasErrors = false;
		}


		return $this->hasErrors;
	}

	public function hasMinimumQuestionsFilledOut() : bool
	{
		$isValid = false;
		foreach($this->questions as $question)
		{

			if(!empty($question->inputAnswer))
			{
				$isValid = true;
			}

		}	

		$this->isValid = $isValid;
		return $this->isValid;
	}

	function getIsValid() : bool
	{
		return $this->isValid;
	}
}

?>