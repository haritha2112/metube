<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['unsubscribe_button'])){
		$c_id = $_POST['c_id'];
		$current_uid = get_current_uid($_SESSION['username']);
		unsubscribe_from_channel($c_id, $current_uid);
	}
?>
<html>
	<head>
		<title> My Subscribed Channels </title>
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
			.main-content {
				background: #428bca;
				padding-top: 2%;
				margin-top: 2%;
			}
			.logout{
				margin-top: 20%;
			}
			.sub-title-button {
				margin-top: 3%;
			}
			.unsubscribe-button {
				margin-top: -17px;
			}
		</style>
		<meta http-equiv="pragma" content="no-cache" />
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
					<h1 class="sub-title"> My Subscribed Channels </h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<?php
				$current_uid = get_current_uid($_SESSION['username']);
				$channels = get_subscribed_channels($current_uid);
			?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 main-content">
					<div class="panel-group" id="accordion">
						<?php while($row = mysqli_fetch_assoc($channels)) { 
							$my_channel_media = get_channel_media($row['c_id']);
						?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row['c_id'] ?>"> <?= $row['c_name'] ?> </a>
										<form method="post" action="">
											<button type="submit" class="btn btn-danger pull-right unsubscribe-button" name="unsubscribe_button">Unubscribe</button>
											<input type="hidden" name="c_id" value="<?= $row['c_id'] ?>" />
										</form>
									</h4>
								</div>
								<div id="collapse<?= $row['c_id'] ?>" class="panel-collapse collapse" aria-expanded="false">
									<div class="panel-body">
										<p> <?= $row['c_description'] ?> </p>
										<ul class="list-group">
											<?php while($media_row = mysqli_fetch_assoc($my_channel_media)) { ?>
												<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
													<li class="list-group-item"><?= $media_row['m_title'] ?></li>
												</a>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>