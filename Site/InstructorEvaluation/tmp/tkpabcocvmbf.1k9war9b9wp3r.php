<div class="col-lg-12">
	<div class="col-lg-10 col-lg-offset-1 row">
		<?php if($formInfo['alert']): ?> 
		<div class="alert alert-<?php echo $formInfo['alertType']; ?>" role="alert">
			<?php if($formInfo['alertType'] == "success"): ?>
				<?php echo $formInfo['alert']; ?>

			<?php else: ?>
			<ul>
			<?php foreach (($formInfo['alert']?:array()) as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
			</ul>
			<?php endif ?>
		</div>
	</div>
		<?php endif ?>
		<div class="row-fluid col-lg-12">
			<h2 class="form-signin-heading">New User Information</h2>
		</div>
		<div class="col-md-10 col-md-offset-1">
		
		
		<div class="form-group">
			<label for="firstName">First Name:</label>
		    <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" value="<?php echo $formInfo['firstName']; ?>" required />
		</div>

		<div class="form-group">
			<label for="lastName">Last Name:</label>
		    <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name" value="<?php echo $formInfo['lastName']; ?>" required />
		</div>

		<div class="form-group">
			<label for="inputEmail">Username:</label>
			<div class="input-group">
			    <input type="text" id="inputEmail" name="username" class="form-control" placeholder="ex: Jzstaab" value="<?php echo $formInfo['username']; ?>" required autofocus aria-describedby="basic-addon2"/>
			    <span class="input-group-addon">@greenriver.edu</span>
			</div>
		</div>

		
	</div>
	<div class="col-md-5 pull-right form-group">
			<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		</div>
</div>