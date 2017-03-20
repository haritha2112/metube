<html>
	<head>
		<title> MeTube Login Page </title>	
		<link rel="stylesheet" href="CSS/LoginPage.css">	
	</head>
	<body align = "center">
	<?php
	
	include_once "function.php";

	if(isset($_POST['Submit'])) {
		if($_POST['username'] == "" || $_POST['pwd'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['pwd']); // Call functions from function.php
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
		<div class = "container" >
			<div class = "Login">
				<br><br><br><br>
				<h1> MeTube </h1>
				<br>
				<h2> Login </h2>
				<form action="" method = "POST">
					<label> UserName: </label><input type = "text" name = "username" class = "box"/> <br><br>
					<label> Password: </label><input type = "password" name = "pwd" class = "box"/> <br><br>
					<input type = "submit" value = "submit" name = "Submit" /> <br>
				</form>
			</div>
			<div class = "NewUser">
				<p> New User? <a href = "Register.php"> Register Now! </a>
			</div>
		</div>
	</body>
<?php
  if(isset($login_error))
   {  echo "<div id='passwd_result'>".$login_error."</div>";}
?>
</html>