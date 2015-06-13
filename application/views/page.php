<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
	<link rel="stylesheet" type="text/css" href="../../../tests/css/bootstrap.min.css">
	<title><?=$title?></title>
</head>
<body>
	<!-- MENU -->
	<div class="navbar navbar-default">
	    <div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	        </button>
	        <a class="navbar-brand" href="javascript:void(0)">Blog</a>
	    </div>
	    <div class="navbar-collapse collapse navbar-responsive-collapse">
	        <ul class="nav navbar-nav">
	            <li ><a href="<?=base_url()?>">Home</a></li>
	            <li><a href="<?=base_url('articles')?>">Articles</a></li>
	        </ul>
	        <?php if ($User->is_logged()): ?>
	        	<ul class="nav navbar-nav navbar-right">
		            <li class="dropdown">
		                <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown"><?=$User->last_name?> <b class="caret"></b></a>
		                <ul class="dropdown-menu">
		                    <li><a href="<?=base_url('users/out')?>">Выйти</a></li>
		                </ul>
		            </li>
		        </ul>
		    <?php else: ?>
		    	<ul class="nav navbar-nav navbar-right">
		            <li><a href="<?=base_url('users/login')?>">Login</a><li>
		            <li><a href="<?=base_url('users/register')?>">Register</a></li>
		        </ul>
	        <?php endif ?>
	    </div>
	</div>
	<!-- /MENU -->

	<!-- NOTIFICATIONS -->
	<?php if (isset($errors) || validation_errors()): ?>
		<div class="alert alert-danger alert-dismissible" role="alert" id="errors">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<ul>
			<?php echo validation_errors(); ?>
			<?php if (isset($errors)): ?>
				<?php foreach ($errors as $key => $value): ?>
					<li><?php echo $value?></li>
				<?php endforeach ?>
			<?php endif ?>
			</ul>
		</div>
	<?php endif ?>

	<?php if (isset($success)): ?>
		<div class="alert alert-success alert-dismissible" role="alert" id="success">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<ul>
			<?php echo validation_errors(); ?>
			<?php if (isset($success)): ?>
				<?php foreach ($success as $key => $value): ?>
					<li><?php echo $value?></li>
				<?php endforeach ?>
			<?php endif ?>
			</ul>
		</div>
	<?php endif ?>
	<!-- /NOTIFICATIONS -->

	<div class="container">
		<div class="row">
			<?php $this->load->view($load_view);?>
		</div>
	</div>
		
	<script src="../../../tests/js/jquery-2.1.3.min.js"></script>
	<script src="../../../tests/js/bootstrap.min.js"></script>
</body>
</html>