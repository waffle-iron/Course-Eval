<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Instructor Evaluation - New User</title>
<style>
/* -------------------------------------
    GLOBAL
------------------------------------- */
* {
  font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
  font-size: 100%;
  line-height: 1.6em;
  margin: 0;
  padding: 0;
}
img {
  max-width: 600px;
  width: auto;
}
body {
  -webkit-font-smoothing: antialiased;
  height: 100%;
  -webkit-text-size-adjust: none;
  width: 100% !important;
}
/* -------------------------------------
    ELEMENTS
------------------------------------- */
a {
  color: #348eda;
}
.btn-primary {
  Margin-bottom: 10px;
  width: auto !important;
}
.btn-primary td {
  background-color: #348eda; 
  border-radius: 25px;
  font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
  font-size: 14px; 
  text-align: center;
  vertical-align: top; 
}
.btn-primary td a {
  background-color: #348eda;
  border: solid 1px #348eda;
  border-radius: 25px;
  border-width: 10px 20px;
  display: inline-block;
  color: #ffffff;
  cursor: pointer;
  font-weight: bold;
  line-height: 2;
  text-decoration: none;
}
.last {
  margin-bottom: 0;
}
.first {
  margin-top: 0;
}
.padding {
  padding: 10px 0;
}


/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1, 
h2, 
h3 {
  color: #111111;
  font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  font-weight: 200;
  line-height: 1.2em;
  margin: 40px 0 10px;
}
h1 {
  font-size: 36px;
}
h2 {
  font-size: 28px;
}
h3 {
  font-size: 22px;
}
p, 
ul, 
ol {
  font-size: 14px;
  font-weight: normal;
  margin-bottom: 10px;
}
ul li, 
ol li {
  margin-left: 5px;
  list-style-position: inside;
}
/* ---------------------------------------------------
    RESPONSIVENESS
------------------------------------------------------ */
/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
  clear: both !important;
  display: block !important;
  Margin: 0 auto !important;
  max-width: 600px !important;
  background: #157612;
}
/* Set the padding on the td rather than the div for Outlook compatibility */
.body-wrap .container {
  padding: 20px;
}
/* This should also be a block element, so that it will fill 100% of the .container */
.content {
  display: block;
  margin: 0 auto;
  max-width: 600px;
}
/* Let's make sure tables in the content area are 100% wide */
.content div {
  width: 100%;
}
/* ---------------------------------------------------
    Container shadow
------------------------------------------------------ */
 .container > .card
{
	border-radius: 0px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.50);
    background: #fff;
    font-size: 1.25em;
}
</style>
</head>

<body>

<!-- body -->
	<div class="container">
		<div class="card content">
			<p>Hello <?php echo $firstName." ".$lastName; ?>,</p>
			<p>You have been invited to use the Instructor Evaluation Site, your portal to getting anonymous feedback from your students.</p> 
			<p>Your login information:</p>
			<ul>
				<li>Username: <?php echo $username; ?></li>
			</ul>
			<p>This link will allow you to set your password and will expire within 48 hours.</p>
			<a href="<?php echo $siteAddress.'/ChangePassword/'.$link; ?>"><?php echo $siteAddress.'/ChangePassword/'.$link; ?></a>
		</div>	
	</div>
<!-- /body -->


</body>
</html>