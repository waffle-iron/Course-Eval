<div class="container well col-lg-12">
	<div class="card">
		<!-- <div class="row">
			<span class='col-md-12'><?php echo $evaluationHeader['name']; ?> Quarter:<?php echo $evaluationHeader['quarter']; ?> Year:<?php echo $evaluationHeader['year']; ?> Section<?php echo $evaluationHeader['section']; ?></span>
		</div> -->
		<?php foreach (($evaluationQuestions?:array()) as $questionNumber=>$question): ?>
			<div class="row-fluid form-group">
				<h3 class='col-md-12 questionText'><?php echo ($questionNumber + 1).": ". $question['questionText']; ?></h3>
				
				<?php if(!$question['isFillIn']): ?>
				<div class="container-fluid text-center">
					<p class="col-md-2 ">Almost Always: <?php echo $question[1]; ?></p>
					<p class="col-md-2 ">Often: <?php echo $question[2]; ?></p>
					<p class="col-md-2 ">Sometimes: <?php echo $question[3]; ?></p>
					<p class="col-md-2 ">Rarely: <?php echo $question[4]; ?></p>
					<p class="col-md-2 ">Almost Never: <?php echo $question[5]; ?></p>
					<p class="col-md-2 ">N/A: <?php echo $question[6]; ?></p>
				</div>
				<?php else: ?>
				<div class="container-fluid">
					<div class="striped col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
						<?php foreach (($question['answers']?:array()) as $text): ?>
							<div class="row">
								<div class="col-xs-12">
									<p><strong>Student <?php echo $text['coorelationID'] . ": "; ?></strong><?php echo $text['textAnswer']; ?><p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif ?>

			</div>
		<?php endforeach; ?>
	</div>
		<div class="col-lg-4">
		<a class="btn btn-primary btn-lg" href="<?php echo $siteRoot.'/reports'; ?>">View Evaluations</a>
		</div>

</div>

