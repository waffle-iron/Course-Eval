<?php
/**
* Project: IT Instructor Evaluations
* File: EvaluationController.php
* Authors: James Staab and Craig Koch 
* Date: 04/20/2016
* 
* This is the controller for create evaluation page
*/

class MakeTestController
{

	private $router;

	public $className;
	public $quarter;
	public $year;
	public $section;
	public $notes;
	public $expireDate;
	public $numberOfTests;

	function __construct($router)
	{
		$this->router = $router;
	}

	function renderView()
	{
		$this->router->set('formId', 'makeEvaluation');
		$this->router->set('formAction', '');
		$this->router->set('formMethod', 'POST');
		$this->router->set('formContent', 'views/makeTest.php');
		$this->router->set('bodyContent', 'views/form.htm');
		
		echo \Template::instance()->render('views/layout.php');
	}

	function enterTestIntoDatabase()
	{
		$createTestModel = new CreateEvaluationModel($this->router);

		$evalID = $createTestModel->writeToEvaluationInfo($this->className, $this->quarter, $this->year, $this->section, $this->notes);

		$createTestModel->setDefaultQuestionForEvaluation($evalID);

		$code = uniqid();

		$createTestModel->setUpEvaluationCodes($evalID, $code, $this->expireDate, $this->numberOfTests);

		$confirmationArray = array($evalID, $code, $this->className, $this->quarter, $this->year, $this->section, $this->notes, $this->expireDate, $this->numberOfTests);

		return $confirmationArray;
	}

	function validateCreateEvaluationForm()
	{
		$this->receivePost();

		$validate = new CreateEvalValidateTools($this->className, $this->year, $this->quarter, $this->section, $this->expireDate, $this->notes);
		
		$validatedInfo = $validate->validateCreateEvaluation();

		if($validatedInfo["className"]["valid"] &&
		   $validatedInfo["year"]["valid"] &&
		   $validatedInfo["quarter"]["valid"] &&
		   $validatedInfo["section"]["valid"] &&
		   $validatedInfo["expirationDate"]["valid"])
		{
			$previousEntry = $this->enterTestIntoDatabase();

			$this->router->set('previousEntry', $previousEntry);
			$this->renderView();
		}
		else
		{
			$message['alert'] = array_filter(
				array_map(
					function($item)
					{
						return $item['message'];
					},$validatedInfo), 
				function($item)
				{
					return !empty($item);
				});
			$message['alertType'] = "danger";
			
			$this->prefillForm();
			
			$this->router->set('message', $message);
			$this->renderView();
		}
	}

	function receivePost(){

		$this->className = $this->router->get('POST.className');;
		$this->year = $this->router->get('POST.year');
		$this->quarter = $this->router->get('POST.quarter');;
		$this->section = $this->router->get('POST.section');;
		$this->notes = $this->router->get('POST.notes');
		$this->expireDate = $this->router->get('POST.endDate');
		$this->numberOfTests = $this->router->get('POST.numTest');
	}

	function prefillForm()
	{
		$info = [];

		$info['className'] = $this->className;
		$info['year'] = $this->year;
		$info['quarter'] = $this->quarter;
		$info['section'] = $this->section;
		$info['expirationDate'] = $this->expireDate;
		$info['notes'] = $this->notes;
		$this->router->set('info', $info);
	}
	
}