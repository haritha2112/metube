<?php
	include_once "function.php";
	if(isset($_POST['Submit'])) {
		if($_POST['fname'] == "" || $_POST['lname'] == "" || $_POST['uname'] == "" || $_POST['pwd'] == "" || $_POST['cpwd'] == "" || $_POST['gender'] == "") {
			$register_error = "One or more fields are missing.";
		}
		elseif( $_POST['pwd'] != $_POST['cpwd']) {
			$register_error = "Passwords don't match. Try again?";
		}
		elseif( strlen($_POST['pwd']) < 4 ||  strlen($_POST['pwd']) > 10 ) {
			$register_error = "Passwords should have 4 to 9 characters. Try again?";
		}
		else {
			$check = user_exist_check($_POST['fname'],$_POST['lname'],$_POST['uname'],$_POST['pwd'],$_POST['gender']);	//Function to check and register a new user
			echo "user check function";
			if($check == 1){
				session_start();
				$_SESSION['username'] = $_POST['username'];
				header('Location: Home.php');
			}
			if($check == 2){
				echo "User exists";
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
						<div class="col-md-offset-2 col-md-8 register-div">
						<h2> Register </h2>
						<br/>
							<form action="" method = "POST">
								<table class="table table-striped">
									<tbody>
										<tr>
											<td> <label> First Name	 </label> </td>
											<td> <input type = "text" name = "fname" class = "form-control"/> </td>
										</tr>
										<tr>
											<td> <label> Last Name	 </label> </td>
											<td> <input type = "text" name = "lname"  class = "form-control"/> </td>
										</tr>
										<tr>
											<td> <label> User Name	 </label> </td>
											<td> <input type = "text" name = "uname" class = "form-control"/> </td>
										</tr>
										<tr>
											<td> <label> Password </label> </td>
											<td> <input type = "password" name = "pwd" class = "form-control"/></td>
										</tr>
										<tr>
											<td> <label> Confirm Password	 </label> </td>
											<td> <input type = "password" name = "cpwd"  class = "form-control"/> </td>
										</tr>
										<tr>
											<td> <label> Gender	 </label> </td>
											<td>
												<input type="radio" name="gender" value="M"/> Male
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
