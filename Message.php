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
		<title> Message </title>
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
			.main-content {
				margin-top: 5%;
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
			.grid-item {
				width: 25%;
			}
			.navigation-grid {
				margin-top: 1%;
				position: relative;
				top: 15%;
				width: 95%;
				left: 5%;
				height: 50%;
				text-align: center;
			}
			.home-page-icons{
				color: #000000;
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
					<form class = "logout" name="Logout" method="post" action="">
						<input class="btn btn-basic pull-right logout" type="submit" value="Logout" name="logout" />
					</form>
				</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-9">
					<h1 class="sub-title">Messages</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="navigation-grid">
						<tbody>
							<tr>
								<td>
									<a href="Inbox.php">
										<img class="home-page-icons" src="images/inbox.png" title="Inbox" width="100" height="100">
									</a>
									<br>
									<i>Inbox</i>
								</td>
								<td>
									<a href="SendMessage.php">
										<img class="home-page-icons" src="images/send_message.png" title="Send a Message" width="100" height="100">
									</a>
									<br>
									<i>Send a Message</i>
								</td>
								<td>
									<a href="Groups.php">
										<img class="home-page-icons" src="images/group_messages.png" title="Group Discussion" width="100" height="100">
									</a>
									<br>
									<i>Group Discussion</i>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>