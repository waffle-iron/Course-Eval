<?php 

class ReportModel
{
	private $router;
	function __construct($router)
	{
		$this->router = $router;
	}

	function getAllEvaluations($userID)
	{
		$db = $this->router->get('DB');
		$sql = 
			"SELECT a.evaluationID, name, quarter, year, section, count(c.evaluationID) as taken, b.expirationDate ".
			" FROM evaluationInfo a".
			" LEFT JOIN evaluationCodes b on a.evaluationID = b.evaluationID".
			" LEFT JOIN usedEvaluationCodes c on a.evaluationID = c.evaluationID".
			" WHERE userID = :userID".
			" group by a.evaluationID".
			" order by b.expirationDate DESC";
		$params = array("userID" => $userID);

		$values = $db->exec($sql, $params);
		return $this->formatEvaluationList($values);

	}

	public function getEvaluationDetails($evaluationID)
	{

		$header = $this->getEvaluationInfoHeader($evaluationID);
		$questions = $this->getQuestionsForEvaluation($evaluationID);
		$answers = $this->getAnswersForEvaluation($evaluationID);
		$combined = $this->combineQuestionsAndAnswers($questions, $this->coorelateAnswers($answers));
		
		//$value = array('header' => $header,
		//	'combined'=> $combined);
		return $combined;
	}

	public function verifyOwner($evaluationID, $userID): bool
	{
		$db = $this->router->get('DB');
		$sql = "select userID ".
			"FROM evaluationInfo ".
			"WHERE evaluationID = :evaluationID";
		$params = array('evaluationID' => $evaluationID);

		$owner = $db->exec($sql, $params);
		$valid = $owner[0]['userID'] == $userID;

		return $valid;
	}

	private function formatEvaluationList($list)
	{
		foreach ($list as &$item) {
			switch($item['quarter'])
			{
				case "1":
					$item['quarter'] = "Fall";
					break;
				case "2":
					$item['quarter'] = "Winter";
					break;
				case "3":
					$item['quarter'] = "Spring";
					break;	
				case "4":
					$item['quarter'] = "Summer";
					break;
			}

			$item['year'] = substr($item['year'], 0, 4)."-".substr($item['year'], 4);

			if(!empty($item['expirationDate']))
			{
				$temp = new DateTime($item['expirationDate']);
				$item['expirationDate'] = $temp->format('Y-m-d H:i:s');
			}
		}
		return $list;
	}

	private function getEvaluationInfoHeader($evaluationID)
	{
		$db = $this->router->get('DB');
		$sql = 
			"SELECT name, quarter, year, section".
			" FROM evaluationInfo".
			" WHERE evaluationID = :evaluationID";
		$params = array("evaluationID" => $evaluationID);
		$values = $db->exec($sql, $params);
		return $values;
	}

	private function getQuestionsForEvaluation($evaluationID)
	{
		$db = $this->router->get('DB');
		$sql = 
			"SELECT a.questionID, a.questionText, a.isFillIn".
			" FROM questions a".
			" join evaluationQuestions b on a.questionID = b.questionID".
			" WHERE b.evaluationID = :evaluationID";
		$params = array("evaluationID" => $evaluationID);
		$values = $db->exec($sql, $params);
		return $values;
	}

	private function getAnswersForEvaluation($evaluationID)
	{
		$db = $this->router->get('DB');
		$sql = 
			"SELECT a.instanceID, a.questionID, a.multipleChoiceOption, COUNT(*) as count, a.textAnswer".
			" FROM evaluationAnswers a".
			" WHERE a.evaluationID = :evaluationID".
			" GROUP BY a.questionID, a.multipleChoiceOption, a.textAnswer".
			" ORDER BY a.questionID";
		$params = array("evaluationID" => $evaluationID);
		$values = $db->exec($sql, $params);
		return $values;
	}

	private function combineQuestionsAndAnswers($questions, $answers)
	{
		foreach ($questions as &$question) 
		{
			$questionAnswers = [];
			if(!$question['isFillIn'])
			{
				$question['1'] = '0';
				$question['2'] = '0';
				$question['3'] = '0';
				$question['4'] = '0';
				$question['5'] = '0';
				$question['6'] = '0';
  			}
			foreach ($answers as $answer) 
			{
				if($answer['questionID'] == $question['questionID'])
				{
					if($question['isFillIn'] == '1')
					{
						$temp = array(
							'coorelationID' => $answer['coorelationID'],
							'instanceID' => $answer['instanceID'],
							'textAnswer' => $answer['textAnswer']);
						array_push($questionAnswers, $temp);
					}
					else
					{
						$option = $answer['multipleChoiceOption'];
						$question[$option] = $answer['count'];
					}
				}
			}
			
			$question['answers'] = $questionAnswers;

		}
		return $questions;
	}

	private function coorelateAnswers($answers)
	{
		$original = $answers;

		$temp = [];
		$answers = array_filter( $answers,
			function($item){
				return $item['multipleChoiceOption'] == 0;
			});

		foreach ($answers as $answer) {
			$temp[$answer['instanceID']][$answer['questionID']] = array(
				'coorelationID' => '',
				'questionID' => $answer['questionID'],
				'textAnswer' => $answer['textAnswer'],
				'multipleChoiceOption' => $answer['multipleChoiceOption']
			);
		}

		$temp2 = [];
		foreach($temp as $x)
		{
			$temp2[] = $x;
		}

		unset($temp);
		$temp = [];

		foreach ($temp2 as $key => $value) {
			foreach($temp2[$key] as $inside)
			{
				$inside['coorelationID'] = $key + 1;
				array_push($temp,$inside);
			}
		}
		$multipleChoice =  array_filter($original, function($item){
				return $item['multipleChoiceOption'] != 0;
		});

		return array_merge($temp , $multipleChoice);

	}
}

 ?>