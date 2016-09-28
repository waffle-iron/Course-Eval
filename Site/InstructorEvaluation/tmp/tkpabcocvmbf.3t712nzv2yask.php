<div class="container well col-lg-12">
	<div class="card">
		<div class="container-fluid">
			<div class="col-lg-8 col-lg-offset-2">
				<h2>View Evaluations:</h2>
			</div>
			<?php if(count($evaluation) > 0): ?>
			<?php foreach (($evaluation?:array()) as $evaluationInfo): ?>
				<div class="col-lg-8 col-lg-offset-2 container-fluid form-group">
					<a class="list-group-item" href="/InstructorEvaluation/report/<?php echo $evaluationInfo['evaluationID']; ?>"><?php echo $evaluationInfo['name']; ?><?php if(!empty($evaluationInfo['section'])): ?> - Section: <?php echo $evaluationInfo['section']; ?> <?php endif ?> - <?php echo $evaluationInfo['quarter']; ?> Quarter - <?php echo $evaluationInfo['year']; ?> - Taken: <?php echo $evaluationInfo['taken']; ?> - Expiration: <?php echo $evaluationInfo['expirationDate']; ?></a>
				</div>
			<?php endforeach; ?>
			<?php else: ?>
			<div class="container-fluid">
				<p>I am sorry, there are no evaluations for you to review, please create one by selecting "Create Evaluation" in the navbar</p>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>