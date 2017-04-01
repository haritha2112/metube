<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['DeleteMessage'])){
		$msg_id = $_POST['msg_id'];
		delete_personal_message($msg_id);
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
		<table class = "navigation-grid" align = "center">
			<tr>
				<th><i> From </i></th>
				<th><i> Message </i></th>
				<th><i> Time </i></th>
			</tr>
			<?php
				$current_uid = get_current_uid($_SESSION['username']);
				$display_messages = retrive_personal_message($current_uid);
				while($row = mysqli_fetch_assoc($display_messages)) {
					echo "<tr>
						<td class = 'grid-item'>".$row['uname']."</td>
						<td class = 'grid-item'>".$row['message']."</td>
						<td class = 'grid-item'>".$row['msg_date']."</td>
						<form action = '' method = 'post'>
							<td>
								<input type='submit' name='DeleteMessage' value='Delete' />
								<input type='hidden' name='msg_id' value='".$row['msg_id']."' />
							</td>
						</form>
					</tr>";
				}
			?>
		</table>
	</body>
</html>