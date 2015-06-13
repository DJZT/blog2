<div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
	<form role="form" name="login" method="POST" action="<?=base_url('users/login')?>">
		<div class="form-group">
			<label>E-Mail</label>
			<input type="email" name="email" class="form-control"  placeholder="E-Mail">
		</div>
		<div class="form-group">
			<label>Password</label>
			<input type="password" name="password" class="form-control" placeholder="Password">
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-success" name="submit" value="Sign in">
			<a class="btn btn-info" href="<?=base_url('users/register')?>">Sign up</a>
		</div>
	</form>
</div>