<?php  
/**
* Project: IT Instructor Evaluations
* File: enterEvaluationCode.php
* Authors: James Staab and Craig Koch 
* Date: 05/01/2016
* 
* This page is meant for taking in the evaluation code and submitting it to the router for verification
*/
?>
<div class="col-md-12">
	<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">
		<div class="form-group">
			<h1>Instructor Evaluation Form</h1>
			{~ if(@alert): ~} 
			<div class="alert alert-{{@alertType}}" role="alert">
				{{@alert}}
			</div>
			{~ endif ~}
			<h3 ><label for="evaluationCodeEntry">Please enter the code provided by your Instructor</label></h3>
			<input class="form-control" type="text" name="evaluationCode" id="evaluationCodeEntry" />
			<br/>		
			<input class="btn btn-primary btn-lg pull-right" type="submit" value="Start Evaluation!" />
		</div>
	</div>
</div>