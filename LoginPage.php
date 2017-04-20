<?php
	include_once "function.php";

	if(isset($_POST['Submit'])) {
		if($_POST['username'] == "" || $_POST['pwd'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['pwd']); //Function to check login credentials
			if($check == 1) {
				$login_error = "User ".$_POST['username']." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				session_start();
				echo "Field values are right";
				$_SESSION['username'] = $_POST['username']; //Set the $_SESSION['username']
				echo "session started";
				header('Location: Home.php');
			}		
		}
	}
?>
<!-- Login Page -->
<html>
	<head>
		<title> MeTube Login Page </title>
		<link rel="stylesheet" href="CSS/bootstrap.min.css">
		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			body {
				background-image: url('images/background.jpg');
				background-size: cover;
			}
			.logo {
				height: auto;
				width: 120px;
			}
			.login-div {
				height: 48%;
			}
			.register {
				font-size: 17px !important;
			}
			.main-title {
				font-size: 63px;
			}
			.main-content {
				margin-top: 2%;
			}
			
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<img src="images/Logo.png" class="logo pull-right">
				</div>
				<div class="col-md-10">
					<h1 class="pull-left main-title">MeTube</h1>
				</div>
			</div>
			<div class="row text-center">
				<div class="main-content">
					<div class="col-md-offset-2 col-md-8">
						<?php if(isset($login_error)){ ?>
								<div class="alert alert-danger fade-in">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong> <?= $login_error ?> </strong>
								</div>
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-md-offset-3 col-md-6 text-center main-content">
						<h2> Login </h2>
							<form action="" method = "POST">
								<table class = "table" align = "center">
									<tbody>
										<tr>
											<td> <label> UserName </label> </td>
											<td> <input type = "text" name = "username" class = "form-control"/> </td>
										</tr>
										<tr>
											<td> <label> Password </label> </td>
											<td> <input type = "password" name = "pwd" class = "form-control"/></td>
										</tr>
									</tbody>
								</table>
								<input class="btn btn-primary" type="submit" value = "Login" name = "Submit" /> <br/> <br/>
								<p class="register"> New User? <a href = "Register.php"> Register Now! </a> </p>								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>