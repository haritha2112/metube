<html>
	<head>
		<title> MeTube Register Page </title>
		<script type="text/javascript" src="JS/RegisterPageValidation.js"> </script> 
		<link rel="stylesheet" href="CSS/Register.css">
	</head>
	<body align = "center">
		<div class = "container" >
			<div class = "Register">
				<br><br><br>
				<h1> Register! </h1>
				<form name="Register" action = "Home.php" method = "post" onsubmit = "return RegisterPageValidation()">	
					<label> First Name:	</label><input type = "text" name = "fname" class = "box" /> <br><br>
					<label> Last Name:	</label><input type = "text" name = "lname" class = "box" /> <br><br> 
					<label> User Name:	</label><input type = "text" name = "uname" class = "box" /> <br><br>
					<label> Email:	</label><input type = "text" name = "emailid" class = "box" /> <br><br>
					<label> Password:	</label><input type = "password" name = "pwd" class = "box" /><br><br>
					<label> Confirm Password:	</label><input type = "password" name = "cpwd" class = "box" /><br><br>
					<label> Gender:	</label>
						<input type="radio" name="gender" value="Male"> Male
						<input type="radio" name="gender" value="Female"> Female <br><br>
					<input type="Reset" value = "Reset"/> <input type = "submit" value = "Submit"/>  
					<br><br>
					<div class = "OldUser">
						<p> Already a member? <a href = "LoginPage.php"> Login Now! </a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
		