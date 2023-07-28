

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
  body {
    padding-top: 90px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #1CB94E;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #1CA347;
	border-color: #1CA347;
}

</style>

<script>

  $(function() {

		$('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
		});

		$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
		$("#login-form").fadeOut(100);
		$("#password-forgot-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$('#forgot-password-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
		})

		$('#forgot-password-form-link').click(function(e) {
		$("#password-forgot-form").delay(100).fadeIn(100);
		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
		});

});
</script>

<script>
	function checkpassword(){
	let pass=$("#password").val();
	let pass_confirm=$("#confirm-password").val();
		if (pass!=pass_confirm) {
			$("#checkpass").removeClass();
			$("#checkpass").addClass("alert alert-danger");
			$("#checkpass").html("mot de pass incorrect!");
		} else {
			$("#checkpass").removeClass();
			$("#checkpass").addClass("alert alert-success");
			$("#checkpass").html("mot de pass correct!");
		}
	}


$(document).ready(function(){
	$("#register-form").submit(function(e) {
		e.preventDefault()
		$.ajax({
			type:"post",
			url:"ajaxdata.php",
			data:$("#register-form").serialize(),
			dataType:"json",
			success:function(response){
				if (response.user) {
					$("#checkusername").addClass("alert alert-danger");
					$("#checkusername").html(response.user);
					$("#checkusername").css("text-align","center");
				}else{
					$("#checkusername").remove()
					if(response.email){
						$("#checkmail").addClass("alert alert-danger");
						$("#checkmail").html(response.email);
					
					}else{
							$("#register-form")[0].reset();
							$("#checkpass").removeClass();
							$("#checkpass").empty();
							$("#register-form-link").removeClass();
							$("#login-form-link").addClass("active");
							$("#login-form").css("display","block");
							$("#register-form").css("display","none");
						}
				}				
			},
			error:function(err){
				console.log(JSON.stringify(err.responseText))
			}
		})
	})
	$("#confirm-password").keyup(checkpassword);

	$("#forget").click(function(e){
		e.preventDefault();
	
		$("#login-form").css("display","none");
		$("#password-forgot-form").css("display","block");	
		$("#login-form-link").removeClass("active");
		$("#forgot-password-form-link").addClass("active");	
		$("#forgot-password-form-link").css("display","block");	
		$("#login-form-link").css("display","none");
		
	})
	$("#login-form").submit(function(e){
		e.preventDefault();
		$.ajax({
			type:"post",
			url:"ajaxdata.php",
			data:$("#login-form").serialize(),
			dataType:"json",
			success:function (reponse) {
				if (reponse.user) {
				$("#checkuser").addClass("alert alert-danger");
				$("#checkuser").html(reponse.user);
				}
				else{
					
					if (reponse.value==false) {
						$("#checkpsw").addClass("alert alert-danger");
						$("#checkpsw").html(reponse.msg);
					} if (reponse.value==true) {
						window.location="index.php";
					}
				}
			},
			error:function (erro) {
				console.log(JSON.stringify(erro.reponseText));
			},
		})
	});
	$("#password-forgot-form").submit(function(e){
		e.preventDefault();
		$.ajax({
			type:"post",
			url:"ajaxdata.php",
			data:$("#password-forgot-form").serialize(),
			dataType:"json",
			success:function(response){
					if (!response.value) {
						$("#check-email-password-forget").removeClass();
						$("#check-email-password-forget").empty();
						$("#check-email-password-forget").addClass("alert alert-danger");
						$("#check-email-password-forget").html(response.msg);
					}else{
						$("#check-email-password-forget").removeClass();
						$("#check-email-password-forget").empty();
						$("#check-email-password-forget").addClass("alert alert-success");
						$("#check-email-password-forget").html(response.msg);
					}
			},
		})
	})
	$("#change-password-form").submit(function(e){
		e.preventDefault();
		$.ajax({
			type:"post",
			url:"ajaxdata.php",
			data:$("#change-password-form").serialize(),
			dataType:"json",
			success:function (response) {
				if (response.value == false) {
					$("#checuser").addClass("alert alert-danger");
					$("#checuser").html(response.msg);
				}else{
					window.location="login.php"
				}
				
			},
		})
	})
})
</script>

  <title>Gestion de commande</title>
</head>
<body>
	<?php 
	$mail=!empty($_GET["email"])?trim($_GET["email"]):"";
	$token=!empty($_GET["token"])?trim($_GET["token"]):"";
	$user_id=!empty($_GET["user"])?trim($_GET["user"]):"";
	?>
  <!------ Include the above in your HEAD tag ---------->
<div class="container">
	<?php if ($mail && $token && $user_id ):?> 

    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active"id="change-form-link"> Password Change</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">

								<form id="change-password-form" method="post" role="form" style="display:block;">
										<div class="form-group">
											<div id="checuser" ></div>
											<input type="hidden" name="user_mail" value="<?= $mail ?>"  >
											<input type="hidden" name="token" value="<?= $token ?>"  >
											<input type="password" name="new-password" id="password" tabindex="1" class="form-control" placeholder="New password" required>
										</div>
										<div class="form-group">
											<input type="password" name="confirm-password_register" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm New Password" required>
										</div>
											<div id="checkpass" ></div>										
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="change-password-submit" id="change-password-submit" tabindex="4" class="form-control btn btn-register" value="Submit">
												</div>
											</div>
										</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php  else:?>
			<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active"id="login-form-link">Login</a>
								<a href="#"  id="forgot-password-form-link" style="display:none;" >Forgot password</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="username_login" id="username_login" tabindex="1" class="form-control" placeholder="Username" required >
									</div>
									<div id="checkuser" style="text-align:center;" ></div>
									
									<div class="form-group">
										<input type="password" name="password_login" id="password_login" tabindex="2" class="form-control" placeholder="Password" required >
									</div>
									<div id="checkpsw" ></div>
									<div class="form-group text-center">
										<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
										<label for="remember"> Remember Me</label>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="" id="forget"  tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
											</div>
										</div>
									</div>
								</form>		

								<form id="password-forgot-form" action="" method="post" role="form" style="display: none;">
										<div class="form-group">
											<input type="email" name="email_password-forget" id="email_password-forget" tabindex="1" class="form-control" placeholder="Email Address"required>
										</div>
										<div id="check-email-password-forget" ></div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="password-forget-submit" id="password-forget-submit" tabindex="4" class="form-control btn btn-login" value="submit">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href=""  tabindex="5" class="forgot-password">Back to login </a>
												</div>
											</div>
										</div>
									</div>
								</form>

								<form id="register-form"action="" method="post" role="form" style="display:none;">
										<div class="form-group">
											<input type="text" name="username_register" id="username_register" tabindex="1" class="form-control" placeholder="Username" required >
										</div>
										<div id="checkusername" ></div>
										<div class="form-group">
											<input type="email" name="email_register" id="email_register" tabindex="1" class="form-control" placeholder="Email Address"required>
										</div>
										<div id="checkmail" style="text-align:center;"></div>
										<div class="form-group">
											<input type="password" name="password_register" id="password" tabindex="2" class="form-control" placeholder="Password"required>
										</div>
										<div class="form-group">
											<input type="password" name="confirm-password_register" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password"required>
										</div>
										<div id="checkpass" style="text-align:center;" ></div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
												</div>
											</div>
										</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php endif ?>
	</div>
</body>
</html>


