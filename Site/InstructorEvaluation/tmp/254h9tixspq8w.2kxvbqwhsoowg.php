

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $description; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="assets/css/site.css">
</head>
<body id="bodySelector">
	<?php echo $this->render($header,$this->mime,get_defined_vars(),0); ?>

	<div class="container">
		<?php echo $this->render($bodyContent,$this->mime,get_defined_vars(),0); ?>
	</div>

	<?php echo $this->render($footer,$this->mime,get_defined_vars(),0); ?>

	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>
</html>