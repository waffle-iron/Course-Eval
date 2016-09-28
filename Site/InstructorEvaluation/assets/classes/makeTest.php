<?php 
/**
* Project: IT Instructor Evaluations
* File: Question.php
* Authors: James Staab and Craig Koch 
* Date: 03/31/2016
* 
* This class prints the make test form and holds a validation function for the form
*/

require_once 'dbts.php';
$dbh = new PDO("mysql:host=$hostname; dbname=craigk_instructorReview", $username, $password);
try {
    $dbh = new PDO("mysql:host=$hostname; dbname=craigk_instructorReview", $username, $password);
            //echo "Connected to database.";
    } catch (PDOException $e) {
            echo $e->getMessage();
    }

if(!empty($_POST)){

	//pulls the newest eval ID from the database 
	$sql = "SELECT evaluationID FROM evaluationInfo ORDER BY creationDate DESC LIMIT 1";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
    $evalID = $stmt->fetchColumn();

    //increments the eval ID for new entrys
    $evalID = $evalID + 1;

    //Saves values from post array to variables for later use
    $className = $_POST['className'];
    $quarter = $_POST['quarter'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $notes = $_POST['notes'];
    $expireDate = $_POST['endDate'];
    $time = date("Y-m-d H:i:s");
    $numberOfTests = $_POST['numTest'];

    //SQL statements, PDO's, and run for EVALUATION INFO table insert
    //inserts data for each individual test 

		    $sqlEvalInfoStatment = "INSERT INTO evaluationInfo (evaluationID,name,quarter,year,section,notes,creationDate) VALUES (:evaluationID, :className, :quarter, :year, :section, :notes, :creationDate)";

		    $stmtInsertForEvaluationInfo = $dbh->prepare($sqlEvalInfoStatment);

		    $stmtInsertForEvaluationInfo->bindParam(':evaluationID', $evalID, PDO::PARAM_INT);
		    $stmtInsertForEvaluationInfo->bindParam(':className', $className, PDO::PARAM_STR);
		    $stmtInsertForEvaluationInfo->bindParam(':quarter', $quarter, PDO::PARAM_INT);
		    $stmtInsertForEvaluationInfo->bindParam(':year', $year, PDO::PARAM_INT);
		    $stmtInsertForEvaluationInfo->bindParam(':section', $section, PDO::PARAM_STR);
		    $stmtInsertForEvaluationInfo->bindParam(':notes', $notes, PDO::PARAM_INT);
		    $stmtInsertForEvaluationInfo->bindParam(':creationDate', $time, PDO::PARAM_STR);

		    $stmtInsertForEvaluationInfo->execute();

		    $test1 = $stmtInsertForEvaluationInfo->errorCode();

	//End of EVALUATION INFO


    //SQL statements, PDO's, And run for EVALUATION QUESTIONS table insert
    //inserts default questions when creating a test. 

		    $sqlEvalQuestions = "INSERT INTO evaluationQuestions (evaluationID, questionID) VALUES (:evalID, 1),(:evalID, 2),(:evalID, 3),(:evalID, 4),(:evalID, 5),(:evalID, 6),(:evalID, 7),(:evalID, 8),(:evalID, 9),(:evalID, 10),(:evalID, 11),(:evalID, 12),(:evalID, 13),(:evalID, 14),(:evalID, 15)";

		    $stmtInsertForEvaluationQuestions = $dbh->prepare($sqlEvalQuestions);

		    $stmtInsertForEvaluationQuestions->bindParam(':evalID', $evalID, PDO::PARAM_INT);

		    $stmtInsertForEvaluationQuestions->execute();

		    $test2 = $stmtInsertForEvaluationQuestions->errorCode();

	//End of EVALUATION QUESTIONS

	//generate a unique id number based on time.
	$guid = uniqid();

	$sqlForEvalCodes = "INSERT INTO evaluationCodes (codeID, evaluationID, code, creationDate, expirationDate, numberAvailable) VALUES (:codeID, :evaluationID, :code, :creationDate, :expirationDate, :numberAvailable)";

	$stmtForEvaluationCodes = $dbh->prepare($sqlForEvalCodes);

	$stmtForEvaluationCodes->bindParam('codeID',$evalID, PDO::PARAM_INT);
	$stmtForEvaluationCodes->bindParam('evaluationID',$evalID, PDO::PARAM_INT);
	$stmtForEvaluationCodes->bindParam('code',$guid, PDO::PARAM_STR);
	$stmtForEvaluationCodes->bindParam('creationDate',$time, PDO::PARAM_STR);
	$stmtForEvaluationCodes->bindParam('expirationDate',$expireDate, PDO::PARAM_STR);
	$stmtForEvaluationCodes->bindParam('numberAvailable',$numberOfTests, PDO::PARAM_INT);

	$stmtForEvaluationCodes->execute();
	$test3 = $stmtForEvaluationCodes->errorCode();

	if($test1 == '00000' && $test2 == '00000' && $test3 == '00000'){
		echo "Give to your students this code: " . $guid;
	}
}

?>



<form action="#" method="POST">
	<div class='col-md-2'>
		<select class='form-control' name="year">
			<option value="">Year</option>
			<option value="20152016">2015-2016</option>
			<option value="20162017">2016-2017</option>
			<option value="20172018">2017-2018</option>
			<option value="20182019">2018-2019</option>
			<option value="20192020">2018-2019</option>
		</select>		
	</div>
	<div class='col-md-2'>
		<select class='form-control' name="quarter">
			<option value="">Quarter</option>
			<option value="1">Fall</option>
			<option value="2">Winter</option>
			<option value="3">Spring</option>
			<option value="4">Summer</option>
		</select>
	</div>				
	<div class='col-md-2'>
		<input type="text" name="className" placeholder="Class Name" class="form-control">
	</div>
	<div class='col-md-2'>
		<input type="text" name="section" placeholder="Section Number" class="form-control">
	</div>
	<div class="col-md-6">
		<textarea rows="4" cols="50" class="form-control" placeholder="Notes about this test" name="notes"></textarea>
	</div>
	<div class="col-md-2">
		End Date:<input type="date" name="endDate" class="form-control">
	</div>
	<div class="col-md-2">
		Number of Tests:<input type="text" name="numTest" class="form-control" placeholder="Number of Tests Available">
	</div>
	<div class='col-md-2'>
		<input type="submit" value="Generate ID" class="form-control">
	</div>			
</form>