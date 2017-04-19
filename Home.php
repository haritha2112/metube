<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<!-- MeTube Home Page -->
<html>
	<head>
		<title> MeTube Home Page</title>
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
		<div class = "container">
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
			<hr>
			<div class="row">
				<div class="col-md-9 text-center">
					<h1 class="sub-title"> Home </h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="Profile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="My Profile" name = "Profile"/>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="navigation-grid">
						<tbody>
							<tr>
								<td>
									<a href="RecentUploads.php">
										<img class="home-page-icons" src="images/whats_new.png" title="Whats new!" width="100" height="100">
									</a>
									<br>
									<i>What's New!</i>
								</td>
								<td>
									<a href="BrowseByCategory.php">
										<img class="home-page-icons" src="images/browse_by_category.png" title="Browse By Category" width="100" height="100">
									</a>
									<br>
									<i>Browse By Category</i>
								</td>
								<td>
									<a href="MostViewed.php">
										<img class="home-page-icons" src="images/most_viewed.png" title="Most Viewed" width="100" height="100">
									</a>
									<br>
									<i>Most Viewed</i>
								</td>
							</tr>
							<tr>
								<td>
									<a href="Search.php">
										<img class="home-page-icons" src="images/search.png" title="Search" width="100" height="100">
									</a>
									<br>
									<i>Search</i>
								</td>
								<td>
									<a href="MediaUpload.php">
										<img class="home-page-icons" src="images/upload_media.png" title="Upload Media" width="100" height="100">
									</a>
									<br>
									<i>Upload Media</i>
								</td>
								<td>
									<a href="SearchChannels.php">
										<img class="home-page-icons" src="images/search_channels.png" title="Channels" width="100" height="100">
									</a>
									<br>
									<i>Search Channels</i>
								</td>								
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>