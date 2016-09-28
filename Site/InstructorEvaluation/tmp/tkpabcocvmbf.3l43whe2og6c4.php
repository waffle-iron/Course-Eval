<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12 text-center">
			<h1>Generate a test with default questions</h1>
		</div>
	</div>
	
	<div class="container-fluid">
		<?php if($message['alert']): ?> 
		<div class="alert alert-<?php echo $message['alertType']; ?>" role="alert">
			<?php if(!is_array($message['alert'])): ?>
				<?php echo $message['alert']; ?>

			<?php else: ?>
			<ul>
			<?php foreach (($message['alert']?:array()) as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
			</ul>
			<?php endif ?>
		</div>
		<?php endif ?>
		<div class="row-fluid col-lg-12">
			<h2>Course Information</h2>
			<div class='col-md-6'>
				<input type="text" name="className" placeholder="Class Name" class="form-control"  value="<?php echo $info['className']; ?>">
			</div>

			<div class='col-md-2'>
				<select class='form-control' name="year">
					<option value="">Year</option>
					<option value="20152016" <?php if($info['year'] == "20152016") : ?> selected <?php endif ?>>2015-2016</option>
					<option value="20162017"<?php if($info['year'] == "20162017") : ?>selected <?php endif ?>>2016-2017</option>
					<option value="20172018"<?php if($info['year'] == "20172018") : ?>selected <?php endif ?>>2017-2018</option>
					<option value="20182019"<?php if($info['year'] == "20182019"): ?>selected <?php endif ?>>2018-2019</option>
					<option value="20192020"<?php if($info['year'] == "20192020"): ?>selected <?php endif ?>>2018-2019</option>
				</select>		
			</div>
						
			<div class='col-md-4'>
				<select class='form-control' name="quarter" value="<?php echo $info['quarter']; ?>">
					<option value="">Quarter</option>
					<option value="1"<?php if($info['quarter'] == 1): ?>selected <?php endif ?>>Fall</option>
					<option value="2"<?php if($info['quarter'] == 2): ?>selected <?php endif ?>>Winter</option>
					<option value="3"<?php if($info['quarter'] == 3): ?>selected <?php endif ?>>Spring</option>
					<option value="4"<?php if($info['quarter'] == 4): ?>selected <?php endif ?>>Summer</option>
				</select>
			</div>
		
			<div class='col-md-6 col-md-offset-6'>
				<span>Section Number:</span>
				<input type="text" name="section" placeholder="Section Number" class="form-control"  value="<?php echo $info['section']; ?>">
			</div>		
		</div>
		
		<div class="row-fluid col-lg-12">
			<h2>Options:</h2>
				<div class="col-md-2">
					<span>Expiration Date:</span>
					<input type="date" name="endDate" class="form-control" placeholder="2016-03-14" value="<?php echo $info['expirationDate']; ?>">
				</div>
					
		
			<div class="col-md-6">
				<span>Notes:</span>
				<textarea rows="4" cols="50" class="form-control" placeholder="Notes about this test" name="notes"><?php echo $info['notes']; ?></textarea>
			</div>
		</div>
	
	</div>

	<div class="container-fluid pull-right">
			<input type="submit" value="Get Entry Code" class="btn btn-primary btn-lg">	
		</div>

		<!-- Generate Code Section -->
			<div class="row-fluid">
				<?php foreach (($div?:array()) as $ikey=>$idiv): ?><?php endforeach; ?>
				<?php if($previousEntry['0']): ?>
				<div class="panel panel-default coll-md-8">
				  <div class="panel-heading">Your last entry</div>
					  <div class="panel-body">
					  	<div><b>Entry Code:<a href="<?php echo $siteAddress.'/Evaluation/'. $previousEntry['1']; ?>"><?php echo $siteAddress.'/Evaluation/'. $previousEntry['1']; ?></a></b></div>
						<div>Evaluation ID:<?php echo $previousEntry['0']; ?></div>
						<div>Class Name:<?php echo $previousEntry['2']; ?></div>
						<div>Quarter:<?php echo $previousEntry['3']; ?></div>
						<div>Year:<?php echo $previousEntry['4']; ?></div>
						<div>Section Number:<?php echo $previousEntry['5']; ?></div>
						<div>Notes:<?php echo $previousEntry['6']; ?></div>
						<div>Expiration Date:<?php echo $previousEntry['7']; ?></div>
						<div>Number of Test Available:<?php echo $previousEntry['8']; ?></div>
					</div>
				</div>
				<?php endif ?>
			</div>
			<!-- END of Generated Code Section -->
</div>

