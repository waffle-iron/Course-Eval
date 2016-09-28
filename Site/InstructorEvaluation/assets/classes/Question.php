<?php 
/**
* Project: IT Instructor Evaluations
* File: Question.php
* Authors: James Staab and Craig Koch 
* Date: 03/31/2016
* 
* This is meant to hold each question, and their attributes.
*/
class Question
{
	public $questionID;
	public $questionText;
	public $isFillIn;
	public $inputAnswer = "";
	public $error = "";

	function __construct($questionID, $questionText, $isFillIn)
	{
		$this->questionID = $questionID;
		$this->questionText = $questionText;
		$this->isFillIn = $isFillIn;
	}
	//Validate question input if there are incorrect values an error message will be generated
	function validate() : bool
	{
		if($this->isFillIn)
		{
			if($_SERVER['REQUEST_METHOD'] === "POST")
			{
				$this->inputAnswer = $_POST[$this->questionID.'_textarea'];
			}
			if($this->inputAnswer || $this->inputAnswer == "")
			{
				$this->error = "";
				return true;
			}
			else
			{
				$this->error = "";
				return false;
			}
		}
		else
		{
			if($_SERVER['REQUEST_METHOD'] === "POST")
			{
				$this->inputAnswer = $_POST[$this->questionID.'_option'];
			}
			$dropdownValues = array(1, 2, 3, 4, 5, 6, "");
			if(in_array($this->inputAnswer, $dropdownValues))
			{
				$this->error = "";
				return true;
			}
			else
			{
				$this->error = "Invalid selection";
				return false;
			}
		}

	}

}
?>