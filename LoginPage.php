<html>
	<head>
		<title> MeTube Login Page </title>	
		<script type="text/javascript" src="JS/LoginPageValidation.js"> </script> 
		<link rel="stylesheet" href="CSS/LoginPage.css">	
	</head>
	<body align = "center">
		<div class = "container" >
			<div class = "Login">
				<br><br><br><br>
				<h1> MeTube </h1>
				<br>
				<h2> Login </h2>
				<form name="Login" action = "Home.php" method = "post" onsubmit = "return LoginPageValidation()">
					<label> UserName: </label><input type = "text" name = "username" class = "box"/> <br><br>
					<label> Password: </label><input type = "password" name = "pwd" class = "box"/> <br><br>
					<input type = "Submit" value = "Submit" /> <br>
				</form>
			</div>
			<div class = "NewUser">
				<p> New User? <a href = "Register.php"> Register Now! </a>
			</div>
		</div>
	</body>
</html>