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
		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "Logout" name="Logout" method="post" action="">
			<input type="submit" value="Logout" name="logout" />
		</form>
		<hr>
		<a class="btn btn-primary" href="Home.php">Home</a>
		<h2> Browse by Category </h2>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse1"> Movie Trailer </a>
									</h4>
								</div>
								<div id="collapse1" class="panel-collapse collapse" aria-expanded="false">
									<div class="panel-body">
										<ul class="list-group">
											<?php 
												$media_category = 'Movie Trailer';
												$get_category_media = get_media_by_categories($media_category);
												while($media_row = mysqli_fetch_assoc($get_category_media)) { ?>
												<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
													<li class="list-group-item"><?= $media_row['m_title'] ?></li>
												</a>
											<?php } ?>
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
												while($media_row = mysqli_fetch_assoc($get_category_media)) { ?>
												<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
													<li class="list-group-item"><?= $media_row['m_title'] ?></li>
												</a>
											<?php } ?>
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
												while($media_row = mysqli_fetch_assoc($get_category_media)) { ?>
												<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
													<li class="list-group-item"><?= $media_row['m_title'] ?></li>
												</a>
											<?php } ?>
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
												while($media_row = mysqli_fetch_assoc($get_category_media)) { ?>
												<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
													<li class="list-group-item"><?= $media_row['m_title'] ?></li>
												</a>
											<?php } ?>
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
												while($media_row = mysqli_fetch_assoc($get_category_media)) { ?>
												<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
													<li class="list-group-item"><?= $media_row['m_title'] ?></li>
												</a>
											<?php } ?>
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
												while($media_row = mysqli_fetch_assoc($get_category_media)) { ?>
												<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
													<li class="list-group-item"><?= $media_row['m_title'] ?></li>
												</a>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>