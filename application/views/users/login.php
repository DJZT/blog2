<div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
	<!-- <div class="row">
		<div class="panel panel-default">
			<div class="panel-body"> -->
				<form role="form" name="login" method="POST" action="<?=base_url('users/login')?>">
					<div class="form-group">
						<label>E-Mail</label>
						<input type="email" name="email" class="form-control"  placeholder="Электронный адресс">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" placeholder="Пароль">
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success" name="submit" value="Войти">
						<a class="btn btn-info" href="<?=base_url('users/register')?>">Регистрация</a> <a class="btn btn-link" href="<?=base_url('users/reset_password')?>">Забыли пароль?</a>
					</div>
				</form>
			<!-- </div>
		</div>
	</div>  -->
</div>