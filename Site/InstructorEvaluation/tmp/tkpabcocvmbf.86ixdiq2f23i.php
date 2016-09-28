<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
  	<ul class="nav navbar-nav">
  	<?php if(!empty($SESSION['userID'])): ?>
  		<li><a href="<?php echo $siteRoot.'/makeEvaluation'; ?>">Create Evaluation</a></li>
  		<li><a href="<?php echo $siteRoot.'/reports'; ?>">View Results</a></li>
	<?php endif ?>
  	<?php if($SESSION['permissions'][2]): ?>
  		<li><a href="<?php echo $siteRoot.'/Instructor/CreateUser'; ?>">Add New User</a></li>
	<?php endif ?>
  	</ul>
    <ul class="nav navbar-nav navbar-right">
  	<?php if(empty($SESSION['userID'])): ?>
        <li><a href="<?php echo $siteRoot.'/Login'; ?>">Login</a></li>
    <?php else: ?>
        <li><a href="<?php echo $siteRoot.'/Logout'; ?>">Logout</a></li>
  	<?php endif ?>
    </ul>
  </div>
</nav>