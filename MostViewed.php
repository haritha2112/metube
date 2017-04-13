<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<html>
	<head>
		<title> Most Viewed </title>
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
		<h2> Most Viewed </h2>
		<?php
			$current_uid = get_current_uid($_SESSION['username']);
			$most_viewed_media = most_viewed_media($current_uid);
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse1"> Most Viewed </a>
									</h4>
								</div>
								<div id="collapse1" class="panel-collapse collapse" aria-expanded="true">
									<div class="panel-body">
										<ul class="list-group">
											<?php while($media_row = mysqli_fetch_assoc($most_viewed_media)) { ?>
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