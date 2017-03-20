<html>
	<head>
		<title> MeTube Register Page </title>
		<link rel="stylesheet" href="CSS/Register.css">
	</head>
	<body align = "center">
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
				$check = user_exist_check($_POST['fname'],$_POST['lname'],$_POST['uname'],$_POST['pwd'],$_POST['gender']);	
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
		<div>
			<div class = "Register">
				<br><br><br>
				<h1> Register! </h1>
				<form action = "" method = "post" >	
					<label> First Name:	</label><input type = "text" name = "fname" class = "box" /> <br><br>
					<label> Last Name:	</label><input type = "text" name = "lname" class = "box" /> <br><br> 
					<label> User Name:	</label><input type = "text" name = "uname" class = "box" /> <br><br>
					<label> Password:	</label><input type = "password" name = "pwd" class = "box" /><br><br>
					<label> Confirm Password:	</label><input type = "password" name = "cpwd" class = "box" /><br><br>
					<label> Gender:	</label>
						<input type="radio" name="gender" value="M"> Male
						<input type="radio" name="gender" value="F"> Female <br><br>
					<input type="Reset" value = "Reset"/> <input type = "submit" value = "Submit" name = "Submit"/>  
					<br><br>
					<div class = "OldUser">
						<p> Already a member? <a href = "LoginPage.php"> Login Now! </a>
					</div>
				</form>
			</div>
		</div>
		<?php
			if(isset($register_error))
			{  echo "<div id='passwd_result'>".$register_error."</div>";}
		?>
	</body>
</html>
