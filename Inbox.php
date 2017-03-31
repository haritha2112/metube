<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['SaveType'])){
		$type = $_POST['Type'];
		$u_id = $_POST['u_id'];
		$current_id = get_current_uid($_SESSION['username']);
		update_contact_type($current_id, $u_id, $type);
	}
?>
<html>
	<head>
		<title> Inbox </title>
		<link rel="stylesheet" href="CSS/Inbox.css">
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "BackHome" name="BackHome" method="post" action="Home.php">
			<input type="submit" value="Home" name = "Submit"/>
		</form>
		<hr>
		<form class = "BackMessage" name="BackMessage" method="post" action="Message.php">
			<input  type="submit" value="Back" name = "Submit"/>
		</form>
		<h2> Inbox </h2>
	</body>
</html>