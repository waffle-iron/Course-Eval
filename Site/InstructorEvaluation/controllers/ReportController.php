<?php  

class ReportController
{
	private $router;
	
	function __construct($router)
	{
		$this->router = $router;
	}

	function getAllEvaluations()
	{
		$model = new ReportModel($this->router);
		$this->router->set('evaluation', $model->getAllEvaluations($this->router->get('SESSION.userID')));
		$this->router->set('bodyContent', 'views/evaluationList.htm');
		echo \Template::instance()->render('views/layout.php');

	}

	function getEvaluationDetails($evaluationID)
	{
		$model = new ReportModel($this->router);
		$userID = $this->router->get('SESSION.userID');

		$ownerCorrect = $model->verifyOwner($evaluationID, $userID);

		if(!$ownerCorrect)
		{
			$this->router->reroute('/NotAuthorized');
		}

		$info = $model->getEvaluationDetails($evaluationID);
		$this->router->set('evaluationQuestions', $info);
		//$this->router->set('header', $info['header']);
		$this->router->set('bodyContent', 'views/report.htm');
		echo \Template::instance()->render('views/layout.php');

	}
}

?>