<?php
	include_once "function.php";
	if(isset($_POST['Submit'])) {
		if($_POST['fname'] == "" || $_POST['lname'] == "" || $_POST['uname'] == "" || $_POST['pwd'] == "" || $_POST['cpwd'] == "" || $_POST['gender'] == "") {
			$register_error = "One or more fields are missing.";
		}
		elseif( $_POST['pwd'] != $_POST['cpwd']) {
			$register_error = "Passwords don't match. Try again";
		}
		elseif( strlen($_POST['pwd']) < 4 ||  strlen($_POST['pwd']) > 10 ) {
			$register_error = "Passwords should have 4 to 9 characters. Try again";
		}
		elseif( strlen($_POST['uname']) > 10) {
			$register_error = "Username can have upto 10 characters. Try again";
		}
		else {
			$check = user_exist_check($_POST['fname'],$_POST['lname'],$_POST['uname'],$_POST['pwd'],$_POST['gender']);	//Function to check and register a new user
			if($check == 1){
				session_start();
				$_SESSION['username'] = $_POST['username'];
				header('Location: Home.php');
			}
			if($check == 2){
				$register_error = "Username already exists. Please user a different username.";
			}
		}
	}
?>
<!-- Registeration Page -->
<html>
	<head>
		<title> MeTube Register Page </title>
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
			.register-div {
				height: 90%;
			}
			.login {
				font-size: 17px !important;
			}
			.main-title {
				font-size: 63px;
			}
			.main-content {
				margin-top: 5%;
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
						<?php if(isset($register_error)){ ?>
								<div class="alert alert-danger fade-in">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong> <?= $register_error ?> </strong>
								</div>
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-md-offset-2 col-md-8 register-div jumbotron">
						<h2> Register </h2>
						<br/>
							<form action="" method = "POST">
								<table class="table">
									<tbody>
										<tr>
											<td> <label> First Name	 </label> </td>
											<td> <input type = "text" name = "fname" placeholder="Your first name" class = "form-control" required/> </td>
										</tr>
										<tr>
											<td> <label> Last Name	 </label> </td>
											<td> <input type = "text" name = "lname" placeholder="Your last name" class = "form-control" required/> </td>
										</tr>
										<tr>
											<td> <label> User Name	 </label> </td>
											<td> <input type = "text" name = "uname" placeholder="Your username. This cannot be changed. (upto 10 characters)" class = "form-control" required/> </td>
										</tr>
										<tr>
											<td> <label> Password </label> </td>
											<td> <input type = "password" name = "pwd" placeholder="Enter a password" class = "form-control" required/></td>
										</tr>
										<tr>
											<td> <label> Confirm Password	 </label> </td>
											<td> <input type = "password" name = "cpwd" placeholder="Re-enter the password" class = "form-control" required/> </td>
										</tr>
										<tr>
											<td> <label> Gender	 </label> </td>
											<td>
												<input type="radio" name="gender" value="M" required/> Male
												<input type="radio" name="gender" value="F"/> Female 
											</td>
										</tr>
									</tbody>
								</table>
								<input class="btn btn-danger reset-button" type="Reset" value = "Reset"/> 
								<input class="btn btn-primary submit-button" type = "submit" value = "Submit" name = "Submit"/>  <br/> <br/>
								<p class="login"> Already a member? <a href = "index.php"> Login Now! </a> </p>								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
