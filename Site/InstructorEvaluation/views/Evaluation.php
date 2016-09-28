<?php  
/**
* Project: IT Instructor Evaluations
* File: Evaluation.php
* Authors: James Staab and Craig Koch 
* Date: 03/31/2016
* 
* This page is meant for taking the evaluations, if there is not one in progress it will prompt for a code
*/
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/site.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.css">
</head>
<body id="evaluation">
	<div class="container">
		<form class="form-horizontal" method="post">
			<include href="{{@content}}" />
		</form>
	</div>
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>
</html>