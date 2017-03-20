<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<html>
	<head>
		<title> My Profile</title>
		<link rel="stylesheet" href="CSS/Profile.css">
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "Logout" name="Logout" method="post" action="">
			<input type="submit" value="Logout" name="logout" />
		</form>
		<hr>
		<form class = "BackHome" name="BackHome" method="post" action="Home.php">
			<input  type="submit" value="Home" />
		</form>
		<h2> My Profile </h2>
		<table class="navigation-grid">
			<tr>
				<td class="grid-item"><a href="ProfileUpdate.php"> Update Profile</a></td>
				<td class="grid-item"><a href="AddContacts.php"> Add Contacts </a></td>
			</tr>
			<tr>
				<td class="grid-item"><a href="MyPeople.php"> My People </a></td>
				<td class="grid-item"><a href="BlockedUsers.php"> Blocked Users </a></td>
			</tr>
		</table>
	</body>
</html>