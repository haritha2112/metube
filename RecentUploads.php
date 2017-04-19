<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<html>
	<head>
		<title> Recent Uploads </title>
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
			<hr>
			<div class="row">
				<div class="col-md-9">
					<h1 class="sub-title">Recent Uploads</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackHome" method="get" action="Home.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back"/>
					</form>
				</div>
			</div>
			<?php
				$recent_uploads = get_recent_uploads();
				$current_uid = get_current_uid($_SESSION['username']);
			?>
			<div class="row">
				<div class="col-md-10">
					<div class="list-group">
						<button type="button" class="list-group-item list-group-item-action active">
							<?php while($media_row = mysqli_fetch_assoc($recent_uploads)) { 
								if(!check_blocked_user($media_row['owner_u_id'], $current_uid)) { ?>
									<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
										<li class="list-group-item"><?= $media_row['m_title'] ?></li>
									</a>
								<?php }
							} ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>