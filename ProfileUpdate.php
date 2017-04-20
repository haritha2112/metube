<?php
	include_once "function.php";
	check_logged_in();

	if(isset($_SESSION['username'])) { 
		$uname = $_SESSION['username'] ;
		$row = user_profile_display($uname);
	}
	
	if(isset($_POST['Delete'])) { 
		$uname = $_SESSION['username'] ;
		$delete = delete_profile($uname);
	}
	
	if(isset($_POST['Save'])) { 
		$uname = $_SESSION['username'] ;
		if($_POST['cfname'] == "" || $_POST['clname'] == "" || $_POST['cpwd'] == "" || $_POST['cgender'] == "") {
			$profile_update_error = "One or more fields are missing.";
		}
		elseif( strlen($_POST['cpwd']) < 4 ||  strlen($_POST['cpwd']) > 10 ) {
			$profile_update_error = "Passwords should have 4 to 9 characters. Try again?";
		}
		else {
			$check = user_profile_update($_POST['cfname'],$_POST['clname'],$_SESSION['username'],$_POST['cpwd'],$_POST['cgender']);	
			if($check == 1){
				header('Location: ProfileUpdate.php');
			}
		}
	}
?>
	<html>
	<head>
		<title> Profile Update</title>
		<link rel="stylesheet" href="CSS/bootstrap.min.css">
		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			.logo {
				height: auto;
				width: 100px;
			}
			.main-title {
				font-size: 45px;
			}
			.sub-title {
				margin-top: 4%;
				padding-left: 35%;
				text-align: center;
			}
			.logout{
				margin-top: 20%;
			}
			.sub-title-button {
				margin-top: 3%;
			}
			
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<img src="images/Logo.png" class="logo pull-right">
				</div>
				<div class="col-md-9">
					<h1 class="pull-left main-title">MeTube</h1>
				</div>
				<div class="col-md-1">
					<form class = "logout" name="Logout" method="post" action="LoginPage.php">
						<input class="btn btn-basic pull-right logout" type="submit" value="Logout" name="logout" />
					</form>
				</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-9">
					<h1 class="sub-title">Update Profile</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<form  action=""  method="post" onsubmit="return confirm('Are you sure you want to proceed?')">
						<table class="table table-striped">
							<tbody>
								<tr> 
									<td> Username </td>
									<td>
										<label name= "uname"><?php echo $row[2] ?></label>
									</td>
									<td><i> You cannot change your username </i></td>
								</tr>
								<tr> 
									<td> Firstname </td>
									<td>
										<label name= "fname"><?php echo $row[0] ?></label>
									</td>
									<td>
										<input type = "text" name = "cfname" class = "form-control" value="<?php echo $row[0] ?>">
									</td>
								</tr>
								<tr> 
									<td> Lastname </td>
									<td>
										<label name= "lname"><?php echo $row[1] ?></label>
									</td>
									<td>
										<input type = "text" name = "clname" class = "form-control" value="<?php echo $row[1] ?>">
									</td>
								</tr>
								<tr> 
									<td> Password </td>
									<td>
										<label name= "pwd"><?php echo $row[3] ?></label>
									</td>
									<td>
										<input type = "text" name = "cpwd" class = "form-control" value="<?php echo $row[3] ?>">
									</td>
								</tr>
								<tr> 
									<td> Gender </td>
									<td>
										<label name= "gender"><?php echo $row[4] ?></label>
									</td>
									<td>
										<?php
											if($row[4] == "F") {
												echo "<input type='radio' name='cgender' value='M'> Male
													  <input type='radio' name='cgender' value='F' checked> Female";
											}
											else {
												echo "<input type='radio' name='cgender' value='M' checked> Male
													  <input type='radio' name='cgender' value='F'> Female";
											}
										?>
									</td>
								</tr>
								<tr>
									<td> </td>
									<td>
										<input class="btn btn-danger" type="submit" value="Delete Account" name = "Delete"/>
									</td>
									<td>
										
										<input class="btn btn-primary" type="submit" value="Save Details" name = "Save"/>
										
									</td>
								</tr>
								<tr>
									<td colspan=3 class="text-center">
										<?php
											if(isset($profile_update_error))
											{  echo "<div id='profile_update_error'>".$profile_update_error."</div>";}
										?>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>