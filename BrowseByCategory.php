<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<html>
	<head>
		<title> Browse by Category </title>
		<link rel="stylesheet" href="CSS/bootstrap.min.css">
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
					<h1 class="sub-title">Browse By Category</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackHome" method="get" action="Home.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back"/>
					</form>
				</div>
			</div>
			<?php $current_uid = get_current_uid($_SESSION['username']); ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse1"> Movie Trailers </a>
										</h4>
									</div>
									<div id="collapse1" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<ul class="list-group">
												<?php 
													$media_category = 'Movie Trailer';
													$get_category_media = get_media_by_categories($media_category);
													while($media_row = mysqli_fetch_assoc($get_category_media)) {
														if(!check_blocked_user($media_row['owner_u_id'], $current_uid)) { ?>
														<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
															<li class="list-group-item"><?= $media_row['m_title'] ?></li>
														</a>
													<?php }
													} 
												?>
											</ul>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse2"> TV Show </a>
										</h4>
									</div>
									<div id="collapse2" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<ul class="list-group">
												<?php 
													$media_category = 'TV Show';
													$get_category_media = get_media_by_categories($media_category);
													while($media_row = mysqli_fetch_assoc($get_category_media)) { 
														if(!check_blocked_user($media_row['owner_u_id'], $current_uid)) { ?>
															<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
																<li class="list-group-item"><?= $media_row['m_title'] ?></li>
															</a>
														<?php } 
													} 
												?>
											</ul>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> Music </a>
										</h4>
									</div>
									<div id="collapse3" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<ul class="list-group">
												<?php 
													$media_category = 'Music';
													$get_category_media = get_media_by_categories($media_category);
													while($media_row = mysqli_fetch_assoc($get_category_media)) { 
														if(!check_blocked_user($media_row['owner_u_id'], $current_uid)) { ?>
															<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
																<li class="list-group-item"><?= $media_row['m_title'] ?></li>
															</a>
														<?php } 
													} 
												?>
											</ul>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse4"> Sports </a>
										</h4>
									</div>
									<div id="collapse4" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<ul class="list-group">
												<?php 
													$media_category = 'Sports';
													$get_category_media = get_media_by_categories($media_category);
													while($media_row = mysqli_fetch_assoc($get_category_media)) { 
														if(!check_blocked_user($media_row['owner_u_id'], $current_uid)) { ?>
															<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
																<li class="list-group-item"><?= $media_row['m_title'] ?></li>
															</a>
														<?php } 
													}
												?>
											</ul>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse5"> Images and Gifs </a>
										</h4>
									</div>
									<div id="collapse5" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<ul class="list-group">
												<?php 
													$media_category = 'Images and Gifs';
													$get_category_media = get_media_by_categories($media_category);
													while($media_row = mysqli_fetch_assoc($get_category_media)) { 
														if(!check_blocked_user($media_row['owner_u_id'], $current_uid)) { ?>
															<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
																<li class="list-group-item"><?= $media_row['m_title'] ?></li>
															</a>
														<?php } 
													} 
												?>
											</ul>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse6"> Others </a>
										</h4>
									</div>
									<div id="collapse6" class="panel-collapse collapse" aria-expanded="false">
										<div class="panel-body">
											<ul class="list-group">
												<?php 
													$media_category = 'Others';
													$get_category_media = get_media_by_categories($media_category);
													while($media_row = mysqli_fetch_assoc($get_category_media)) { 
														if(!check_blocked_user($media_row['owner_u_id'], $current_uid)) { ?>
															<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
																<li class="list-group-item"><?= $media_row['m_title'] ?></li>
															</a>
														<?php } 
													}
												?>
											</ul>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>