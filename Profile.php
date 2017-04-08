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
			<input  type="submit" value="Home" name = "Home"/>
		</form>
		<h2> My Profile </h2>
		<a class="btn btn-primary" href="ProfileUpdate.php" align="left">Update Profile</a>
		<table class="navigation-grid">
			<tr>
				<td class="grid-item"><a href="MyFavourites.php"> My Favourites</a></td>
				<td class="grid-item"><a href="AddContacts.php"> Add Contacts </a></td>
				<td class="grid-item"><a href="Message.php"> Messages </a></td>
			</tr>
			<tr>
				<td class="grid-item"><a href="MyPeople.php"> My People </a></td>
				<td class="grid-item"><a href="MyUploads.php"> My Uploads </a></td>
				<td class="grid-item"><a href="Groups.php"> Groups </a></td>
			</tr>
		</table>
	</body>
</html>