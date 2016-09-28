<div class="col-md-10 col-md-offset-1">

	<?php if($formInfo['alert']): ?> 
	<div class="alert alert-<?php echo $formInfo['alertType']; ?>" role="alert">
		<?php if($formInfo['alertType'] == "success" || !is_array($formInfo['alert'])): ?>
			<?php echo $formInfo['alert']; ?>

		<?php else: ?>
		<ul>
		<?php foreach (($formInfo['alert']?:array()) as $error): ?>
			<li><?php echo $error; ?></li>
		<?php endforeach; ?>
		</ul>
		<?php endif ?>
	</div>
	<?php endif ?>

	<h2 class="form-signin-heading">Password Change</h2>

	<div class="form-group">
		<label for="inputEmail">Username</label>
		<div class="input-group">
		    <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" value="<?php echo $login['username']; ?>" required autofocus aria-describedby="basic-addon2"/>
		    <span class="input-group-addon">@greenriver.edu</span>
		</div>
	</div>

	<div class="form-group" <?php if($resetFromURL): ?> style="display: none;" <?php endif ?> >
		<label for="inputPassword">Old Password</label>
	    <input type="password" id="inputOldPassword" name="oldPassword" class="form-control" placeholder="Password" value="<?php echo oldPassword; ?>" required  <?php if($resetFromURL): ?> disabled <?php endif ?>/>
	</div>

	<div class="form-group">
		<label for="inputPassword">New Password</label>
	    <input type="password" id="inputNewPassword" name="newPassword" class="form-control" placeholder="Password" required />
	</div>
	<div class="form-group">
		<label for="inputPassword">Confirm New Password</label>
	    <input type="password" id="inputNewPasswordConfirm" name="newPasswordConfirmed" class="form-control" placeholder="Password"  required />
	</div>
	<div class="col-md-6">
	    <a href="#"><span>Forgot your password?</span></a>
    </div>
	<div class="col-md-6">
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	</div>
</div>
