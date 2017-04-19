<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	$uname = $_SESSION['username'];
	$result = user_profile_display($uname);
	$fname = $result['fname'];
?>
<!-- User Profile Page -->
<html>
	<head>
		<title> User Profile </title>
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
				margin-top: 5%;
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
				margin-top: 3%;
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
				<div class="col-md-offset-1 col-md-7">
					<h2 class="sub-title"> Hi <?=$fname ?>! </h2>
				</div>
				<div class="col-md-2 sub-title-button">
					<a class="btn btn-primary pull-right" href="ProfileUpdate.php" align="left">Update Profile</a>
				</div>
				<div class="col-md-2 sub-title-button">
					<form name="BackHome" method="get" action="Home.php">
						<input class="btn btn-primary pull-right" type="submit" value="Home" name = "Home"/>
					</form>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<table class="navigation-grid">
						<tbody>
							<tr>
								<td>
									<a href="MyFavourites.php">
										<img class="home-page-icons" src="images/my_favourites.png" title="My Favourites" width="100" height="100">
									</a>
									<br>
									<i>My Favourites</i>
								</td>
								<td>
									<a href="MyUploads.php">
										<img class="home-page-icons" src="images/my_uploads.png" title="My Uploads" width="100" height="100">
									</a>
									<br>
									<i>My Uploads</i>
								</td>
								<td>
									<a href="MyPlaylist.php">
										<img class="home-page-icons" src="images/my_playlists.png" title="My Playlists" width="100" height="100">
									</a>
									<br>
									<i>My Playlist</i>
								</td>
								<td>
									<a href="MyChannels.php">
										<img class="home-page-icons" src="images/my_channels.png" title="My Channels" width="100" height="100">
									</a>
									<br>
									<i>My Channels</i>
								</td>
							</tr>
							<tr>
								<td>
									<a href="AddContacts.php">
										<img class="home-page-icons" src="images/add_contact.png" title="Add New Contacts" width="100" height="100">
									</a>
									<br>
									<i>Add New Contacts</i>
								</td>
								<td>
									<a href="MyPeople.php">
										<img class="home-page-icons" src="images/my_people.png" title="My People" width="100" height="100">
									</a>
									<br>
									<i>My People</i>
								</td>
								<td>
									<a href="Message.php">
										<img class="home-page-icons" src="images/Messages.png" title="Messages" width="100" height="100">
									</a>
									<br>
									<i>Messages</i>
								</td>
								<td>
									<a href="SubscribedChannels.php">
										<img class="home-page-icons" src="images/channel.png" title="My Subscribed Channels" width="100" height="100">
									</a>
									<br>
									<i>My Subscribed Channels</i>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>