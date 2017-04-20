<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['delete_playlist_button'])){
		$p_id = $_POST['p_id'];
		$current_uid = get_current_uid($_SESSION['username']);
		delete_playlist($p_id, $current_uid);
	}
	
	if(isset($_POST['DeleteMedia'])){
		$p_id = $_POST['p_id'];
		$m_id = $_POST['m_id'];
		delete_playlist_media($p_id, $m_id);
	}
?>
<html>
	<head>
		<title> My Playlist </title>
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
			}
			.logout{
				margin-top: 20%;
			}
			.sub-title-button {
				margin-top: 3%;
			}
			.delete-playlist-button {
				margin-top: -17px;
			}
			.delete-media-button {
				margin-top: 10px;
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
					<h1 class="sub-title">My Playlist</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<?php
				$current_uid = get_current_uid($_SESSION['username']);
				$my_playlists = get_playlists($current_uid);
			?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 main-content">
					<div class="panel-group" id="accordion">
						<?php while($row = mysqli_fetch_assoc($my_playlists)) { 
							$my_playlist_media = get_playlist_media($row['p_id']);
						?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row['p_id'] ?>"> <?= $row['p_name'] ?> </a>
										<form method="post" action="" onsubmit="return confirm('Are you sure you want to proceed?')">
											<button type="submit" class="btn btn-danger pull-right delete-playlist-button" name="delete_playlist_button">Delete</button>
											<input type="hidden" name="p_id" value="<?= $row['p_id'] ?>" />
										</form>
									</h4>
								</div>
								<div id="collapse<?= $row['p_id'] ?>" class="panel-collapse collapse" aria-expanded="false">
									<div class="panel-body">
										<ul class="list-group">
											<?php while($media_row = mysqli_fetch_assoc($my_playlist_media)) { ?>
												<div class="row">
													<div class="col-md-10">
														<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
															<li class="list-group-item"><?= $media_row['m_title'] ?></li>
														</a>
													</div>
													<div class="col-md-2 delete-media-button">
														<form method="POST" onsubmit="return confirm('Are you sure you want to proceed?')">
															<input type="hidden" name="m_id" value="<?= $media_row['m_id'] ?>" />
															<input type="hidden" name="p_id" value="<?= $row['p_id'] ?>" />
															<button class="glyphicon glyphicon-trash" type="submit" name="DeleteMedia" value="X" ></button>
														</form>
													</div>
												</div>
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