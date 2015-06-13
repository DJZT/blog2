<div class="col-md-6 col-lg-offset-3">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-body">
				<h2>Регистрация</h2>
				<form role="form" name="register" method="POST" action="<?=base_url('users/register')?>">
					<div class="form-group has-feedback">
						<label class="control-label">E-Mail</label>
						<input type="email" name="email" class="form-control" aria-invalid="true" placeholder="E-Mail" onchange="valid_email(this)">
						<span class="help-block sr-only"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback sr-only"></span>
					</div>
					<div class="form-group has-feedback">
						<label>Password</label>
						<input id="pass" type="password" name="password" class="form-control" aria-invalid="true" placeholder="Password" onchange="valid_password(this)" required maxlength="16">
						<span class="help-block sr-only"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback sr-only"></span>
					</div>
					<div class="form-group has-feedback">
						<label>Confirm password</label>
						<input type="password" name="conf_password" class="form-control" aria-invalid="true" placeholder="Confirm password" onchange="valid_conf_password(this)" required maxlength="16">
						<span class="help-block sr-only"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback sr-only"></span>
					</div>
					<div class="form-group has-feedback">
						<label>First name</label>
						<input type="text" name="first_name" class="form-control" aria-invalid="true" placeholder="First name" onchange="valid_first_name(this)">
						<span class="help-block sr-only"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback sr-only"></span>
					</div>
					<div class="form-group has-feedback">
						<label>Last name</label>
						<input type="text" name="last_name" class="form-control" aria-invalid="true" placeholder="Last name" onchange="valid_last_name(this)">
						<span class="help-block sr-only"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback sr-only"></span>
					</div>
					<div class="form-group">
						<input id="submit_button" type="submit" class="btn btn-success disabled" name="register" value="Register" />
						<a href="<?=base_url('users/login')?>">Sign in</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	function check_form(){
		if($("[aria-invalid=true]").length){
			$("#submit_button").addClass("disabled");
		}else{
			$("#submit_button").removeClass("disabled");
		}
	}

	function invalid_field(el, text){
		$(el).attr("aria-invalid", true);
		$(el).parent().addClass('has-error');
		$(el).next("span.help-block").removeClass('sr-only').text(text);
		$(el).nextAll("span.form-control-feedback").addClass('sr-only');

		$("#submit_button").addClass("disabled");
	}

	function valid_field(el){
		$(el).attr("aria-invalid", false);
		$(el).parent().removeClass('has-error');
		$(el).parent().addClass('has-success');
		$(el).nextAll("span.help-block").addClass('sr-only');
		$(el).nextAll("span.form-control-feedback").removeClass('sr-only');
		check_form();
	}

	

	function valid_email(el){
		if (!el.value.length) {
			invalid_field(el, "Поле E-Mail должно быть заполненно");
		}else if(( !el.value.match(/[0-9a-z_]+@[0-9a-z_]+\.[a-z]{2,5}/i) )){
			invalid_field(el, "Поле E-Mail должно содержать реальный эмайл аддресс");
		}else{
			valid_field(el);
			return false;
		}

	}

	function valid_password(el){
		if (el.value.length < 6 || el.value.length > 16) {
			invalid_field(el, "Поле Пароль должно содержать от 6 до 16 символов");
		}else if(!el.value.match(/[0-9A-Za-z_]/i)){
			invalid_field(el, "Поле Пароль должно содержать только символы 0-9, A-Z, a-z и _");
		}else{
			valid_field(el);
			return false;
		};
	}

	function valid_conf_password(el){
		if (el.value != $('#pass').val()) {
			invalid_field(el, "Пароли не совпадают");
		}else{
			valid_field(el);
		};
	}

	function valid_first_name(el){
		if (!el.value.length) {
			invalid_field(el, "Поле Имя должно быть заполненно");
		}else{
			valid_field(el);
			return false;
		}
	}

	function valid_last_name(el){
		if (!el.value.length) {
			invalid_field(el, "Поле Фамилия должно быть заполненно");
		}else{
			valid_field(el);
			return false;
		}
	}


	function valid_group(el){
		if ($(el).children(':selected:empty').length == 1) {
			invalid_field(el, "Выберите группу");
		}else{
			valid_field(el);
		};
	}
	

</script>