


<form id="<?php echo $formId; ?>" action="<?php echo $formAction; ?>" class="form-horizontal <?php echo $formClasses; ?>" method="<?php echo $formMethod; ?>">
	<div class="row">
		<?php echo $this->render($formContent,$this->mime,get_defined_vars(),0); ?>
	</div>
</form>