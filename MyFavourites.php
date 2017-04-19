<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>

<!-- User's Favourite List Page -->
<html>
	<head>
		<title> My Favourites </title>
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
			.list-group{
				margin-top: 1%;
				margin-left: 20%;
			}
			.list-group-item{
				text-align: center;
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
					<h1 class="sub-title">Favourites</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<?php
				$current_uid = get_current_uid($_SESSION['username']);
				$my_favourite_media = get_favourite_media($current_uid);
			?>
			<div class="row">
				<div class="col-md-10">
					<div class="list-group">
						<button type="button" class="list-group-item list-group-item-action active">
							<?php
								while($media_row = mysqli_fetch_assoc($my_favourite_media)) { ?>
								<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
									<li class="list-group-item"><?= $media_row['m_title'] ?></li>
								</a>
							<?php } ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>