<div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-10 col-xs-offset-1">
	<div class="container-fluid well">
		<form action="" method="POST">
			<?php if($login['alert']): ?>
			<div class="alert alert-<?php echo $login['alertType']; ?>" role="alert">
				<?php if(!is_array($login['alert'])): ?>
					<?php echo $login['alert']; ?>

				<?php else: ?>
				<ul>
				<?php foreach (($login['alert']?:array()) as $error): ?>
					<li><?php echo $error; ?></li>
				<?php endforeach; ?>
				</ul>
				<?php endif ?>
			</div>
			<?php endif ?>

			<h2 class="form-signin-heading">Please sign in</h2>
			<div class="col-lg-8 col-centered">
				<div class="form-group">
					<label for="inputEmail">Username</label>
					<div class="input-group">
					    <input type="text" id="inputEmail" name="username" class="form-control" placeholder="please enter your username" value="<?php echo $login['username']; ?>" required autofocus aria-describedby="basic-addon2"/>
					    <span class="input-group-addon">@greenriver.edu</span>
					</div>
				</div>

				<div class="form-group">
					<label for="inputPassword">Password</label>
				    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required />
				    <a class="btn btn-link" data-toggle="modal" data-target="#forgotPassword">Forgot your password?</a>
				</div>
				<div class="col-lg-12">
					<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
				</div>
			</div>
		</form>
		
		<!-- Modal -->
		<div id="forgotPassword" class="modal fade" role="dialog">
		  	<div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Please enter your email below</h4>
			      	</div>
			      	<div class="modal-body">
			      		<form action="/PasswordReset" method="post">
			      			<div class="form-group">
								<div class="input-group">
							        <input type="email" id="resetPassword" class="form-control"/>
							    	<span class="input-group-addon">@greenriver.edu</span>
						        </div>
					        </div>	
			      		</form>
			      	</div>
			      	<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	</div>
			    </div>
		  	</div>
		</div>
		<!-- /Modal -->
	</div>
</div>

