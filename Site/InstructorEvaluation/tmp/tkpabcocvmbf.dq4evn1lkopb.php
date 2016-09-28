<?php echo $this->render('views/EvaluationHeader.htm',$this->mime,array('info'=>$headerInfo)+get_defined_vars(),0); ?>
<div class="col-md-12">
	<?php if($alert): ?> 
	<div class="alert alert-<?php echo $alertType; ?>" role="alert">
		<?php echo $alert; ?>

	</div>
	<?php endif ?>
	<?php foreach (($evaluation?:array()) as $questionNumber=>$question): ?>
		<div class="row form-group">
			<?php if($question['error']): ?> 
				<div class="alert alert-danger" role="alert"><?php echo $question['error']; ?></div>
			<?php endif ?>
			<div class="row-fluid col-lg-12 questionText">
			<span><b><?php echo ($questionNumber + 1)."."; ?></b> <?php echo $question['questionText']; ?></span>
			</div>
			<?php if ($question['isFillIn']) : ?>
				<?php echo $this->render('views/InputTemplate.htm',$this->mime,array('question'=>$question)+get_defined_vars(),0); ?>
			<?php else: ?>
				<?php echo $this->render('views/OptionTemplate.php',$this->mime,array('question'=>$question)+get_defined_vars(),0); ?>
			<?php endif ?>
		</div>
	<?php endforeach; ?>
	<div class="row-fluid col-lg-11">
	<input class="btn btn-primary btn-lg pull-right" name="submitEval" type="submit" value="Submit Evaluation"/>
	</div>
</div>

