

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $description; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="https://itlamp.greenriver.edu/grtech/assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="https://itlamp.greenriver.edu/grtech/assets/img/grtech.jpg">
	<link rel="stylesheet" type="text/css" href="<?php echo $assets.'/css/bootstrap.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $assets.'/css/bootstrap-theme.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $assets.'/css/font-awesome.min.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $assets.'/css/site.css'; ?>">
</head>
<body id="bodySelector">
	<?php echo $this->render($header,$this->mime,get_defined_vars(),0); ?>
	<div class="container">
		<?php echo $this->render($bodyContent,$this->mime,get_defined_vars(),0); ?>
	</div>

	<?php echo $this->render($footer,$this->mime,get_defined_vars(),0); ?>

	<script type="text/javascript" src="<?php echo $assets.'/js/jquery.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo $assets.'/js/bootstrap.js'; ?>"></script>
</body>
</html>