<?php  
/**
* Project: IT Instructor Evaluations
* File: layout.php
* Authors: James Staab and Craig Koch 
* Date: 05/1/2016
* 
* Base Layout file
*/

?>

<!DOCTYPE html>
<html>
<head>
	<title>{{@title}}</title>
	<meta name="description" content="{{@description}}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="https://itlamp.greenriver.edu/grtech/assets/img/grtech.jpg">
	<link rel="stylesheet" type="text/css" href="{{@assets.'/css/bootstrap.css'}}">
	<link rel="stylesheet" type="text/css" href="{{@assets.'/css/bootstrap-theme.css'}}">
	<link rel="stylesheet" type="text/css" href="{{@assets.'/css/font-awesome.min.css'}}">
	<link rel="stylesheet" type="text/css" href="{{@assets.'/css/site.css'}}">
</head>
<body id="bodySelector">
	<include href="{{@header}}">
	<div class="container">
		<include href="{{@bodyContent}}" >
	</div>

	<include href="{{@footer}}">

	<script type="text/javascript" src="{{@assets.'/js/jquery.min.js'}}"></script>
	<script type="text/javascript" src="{{@assets.'/js/bootstrap.js'}}"></script>
</body>
</html>