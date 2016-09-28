<?php
/**
* Project: IT Instructor Evaluations
* File: EvaluationController.php
* Authors: James Staab, Craig Koch, Brandon Degarimore
* Date: 04/20/2016
* 
* This provieds a validation tool for the create evaluation content
*/

class CreateEvalValidateTools 
{
	private $isValid = false;

	private $className;
	private $year;
	private $quarter;
	private $section;
	private $expireDate;
	private $notes;

	function __construct($className, $year, $quarter, $section, $expireDate, $notes)
	{
		$this->className = $className;
		$this->year = $year;
		$this->quarter = $quarter;
		$this->section = $section;
		$this->expireDate = $expireDate;
		$this->notes = $notes;
	}

	function validateCreateEvaluation()
	{
		//call the validate for each value
		$validated = array();

		$validated["className"] = $this->validateClassName($this->className);
		$validated["year"] = $this->validateYear($this->year);
		$validated["quarter"] = $this->validateQuarter($this->quarter);
		$validated["section"] = $this->validateSection($this->section);
		$validated["expirationDate"] = $this->validateExpireDate($this->expireDate);

		return $validated;
	}

	function validateClassName($cName)
	{
		if(preg_match("/^[\w\s\&\-]+$/", $cName))
		{
			return array("valid" => true);
		}
		return array("valid" => false,
					 "message" => "A class name can only contain letters, numbers, &, -, and spaces");
	}

	function validateYear($year)
	{
		if(preg_match("/^\d{8}+$/", $year))
		{
			return array("valid" => true);
		}
		return array("valid" => false,
					 "message" => "Invalid Entry for year");
	}

	function validateQuarter($quarter)
	{
		if(preg_match("/[1-4]{1}/", $quarter))
		{
			return array("valid" => true);
		}
		return array("valid" => false,
					 "message" => "Invalid Entry for quarter");
	}

	function validateSection($section)
	{
		if(ctype_alnum($section))
		{
			return array("valid" => true);
		}
		return array("valid" => false,
					 "message" => "Section can only be letters and numbers");
	}

	function validateExpireDate($expireDate)
	{
		return array('valid' => true);
	}

}