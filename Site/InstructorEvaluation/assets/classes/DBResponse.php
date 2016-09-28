<?php

class DBResponse
{
	
	private $errorCode;
	private $errorMessage;
	private $evaluationID;

	public function getErrorCode()
	{
		return $errorCode;
	}

	public function getErrorMessage()
	{
		return $errorMessage;
	}

	public function getEvaluationID()
	{
		return $evaluationID;
	}

	public function setErrorCode($errorCode)
	{
		$this->$errorCode = $errorCode;
	}

	public function setErrorMessage($errorMessage)
	{
		$this->$errorMessage = $errorMessage;
	}

	public function setEvaluationID($evaluationID)
	{
		$this->$evaluationID = $evaluationID;
	}

}