<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['Favourites'])){
		$mid = $_GET['m_id'];
		$item = fetch_media($mid);
		$owner_u_id = $item['owner_u_id'];
		add_media_favourites($mid,$owner_u_id);
	}	
	
	if(isset($_POST['AddToNewPlaylist'])){
		$m_id = $_POST['m_id'];
		$p_name = $_POST['PlaylistName'];
		$u_id = get_current_uid($_SESSION['username']);
		add_to_new_playlist($m_id,$p_name,$u_id);
	}
	
	if(isset($_POST['AddToExistingPlaylist'])){
		$m_id = $_POST['m_id'];
		$p_id = $_POST['SelectedPlaylist'];
		add_to_existing_playlist($m_id,$p_id);
	}
	
	if(isset($_POST['PostMediaComment'])){
		$m_id = $_POST['m_id'];
		$media_comment = $_POST['media_comment'];
		$u_id = get_current_uid($_SESSION['username']);
		post_media_comment($media_comment, $m_id, $u_id);
	}
	
	if(isset($_POST['Delete'])){
		$mc_id = $_POST['mc_id'];
		$m_id = $_POST['m_id'];
		delete_media_comment($mc_id, $m_id);
	}
?>
<html>
	<head>
		<title> Media View </title>
		<link rel="stylesheet" href="CSS/bootstrap.min.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
		<link rel="stylesheet" href="CSS/fontawesome-stars.css">
		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.barrating.min.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#media_rating').barrating({
					theme: 'fontawesome-stars',
					onSelect: function(value, text, event) {
						if (typeof(event) !== 'undefined') {
							$.post("MediaRating.php", {"MediaRating":1, "values": value}, function(){})
						}
					}
				});
			});
		</script>
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
			.comment-section {
				margin-top: 2%;
			}
			.display-image {
				max-height: 600px;
				max-width: 730px;
			}
			.error-image {
				height: 65%;
				width: auto;
			}
			video::-internal-media-controls-download-button {
				display:none;
			}
			video::-webkit-media-controls-enclosure {
				overflow:hidden;
			}
			video::-webkit-media-controls-panel {
				width: calc(100% + 30px); /* Adjust as needed */
			}
			audio::-internal-media-controls-download-button {
				display:none;
			}
			audio::-webkit-media-controls-enclosure {
				overflow:hidden;
			}
			audio::-webkit-media-controls-panel {
				width: calc(100% + 30px); /* Adjust as needed */
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
			<div class="row">
				<div class="col-md-offset-9 col-md-2">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Profile" name = "Profile"/>
					</form>
				</div>
				<div class="col-md-1">
					<form name="BackHome" method="get" action="Home.php">
						<input class="btn btn-primary pull-right" type="submit" value="Home" name = "Home"/>
					</form>
				</div>
			</div>
			<hr/>
			<?php
				if(isset($_GET['m_id'])){
					$mid = $_GET['m_id'];
					$current_uid = get_current_uid($_SESSION['username']);
					if (!user_has_access($mid, $current_uid)) { ?>
						<div class="row">
							<div class="col-md-12 text-center">
								<img class="error-image" src="images/access_denied.png"></img>
							</div>
						</div>
					<?php }
					else {
						$item = fetch_media($mid);
						$owner_u_id = $item['owner_u_id'];
						$mediatitle = $item['m_title'];
						$url = 'Media_Uploads/'.$owner_u_id.'/'.$mid; 
						$uname_result = get_user_details($owner_u_id);
						if ($current_uid != $owner_u_id) {
								increment_view_count($mid);
							}
						?>
						
						<div class="row">
							<div class="col-md-4 jumbotron">
								<div class="row">
									<div class="col-md-12">
										<h2><?= $item['m_title'] ?></h2>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h4><?= $item['description'] ?></h4>
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-12">
										<h5>By : <strong> <?= $uname_result['fname'] ?> <?= $uname_result['lname'] ?> </strong></h5>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h5>Uploaded On : <strong> <?= substr($item['m_date'], 0, 10) ?> </strong> </h5>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h5>Media Type : <strong> <?= $item['media_type'] ?> </strong> </h5>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h5>View Count : <strong> <?= $item['view_count'] ?> </strong> </h5>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<?php if($item['allow_rating'] == 1) { ?>
												<h5><strong>Rating is disabled</strong></h5>
											<?php }
											else {
												$current_rating = get_rating($mid, $current_uid); ?>
												<select id='media_rating' name="MediaRating">
													<option value=""></option>
													<?php 
														foreach(range(1,5) as $num) {
													?>
															<option name="MediaRating" value="<?= $mid ?>|<?= $current_uid ?>|<?= $num ?>" <?php if($num==$current_rating) echo 'selected' ?>> 
																<?= $num ?>
															</option>
													<?php
														}
													?>
												</select>
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<form method = 'POST'>
											<input class="btn btn-warning" type='submit' value='Favourite/Unfavourite' name='Favourites'/>
											<input type='hidden' value='<?= $mid ?>' name='mid'>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<button class='btn btn-primary' id='add_to_playlist' data-toggle='modal' data-target='#playlistModal'>Add to Playlist</button>
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-12">
										<?php if($item['download_type'] == 1) { ?>
												<h5><strong>Download is disabled</strong></h5>
										<?php }
										else { ?>
											<form method = 'GET' action="Download.php">
												<input class="btn btn-success" type='submit' value='Download' name='Download'/>
												<input type='hidden' value='<?= $mid ?>' name='m_id'>
											</form>
										<?php } ?>
									</div>
								</div>
								<hr/>
							</div>
							<div class="col-md-8 text-center">
								<?php if ($item['media_type'] == "Image"){ ?>
									<img class='display-image' src='<?= $url ?>'/>
								<?php }
								else if ($item['media_type'] == "Video"){ ?>
									<video class='display-video' src='<?= $url ?>' width='560' height='315' frame='2' type="video/<?=$item['extension'] ?>" controls></video>
								<?php }
								else if ($item['media_type'] == "Audio"){ ?>
									<audio class='display-audio' src="<?= $url ?>" controls></audio>
								<?php } ?>
							</div>
						</div>
						<div class="row jumbotron comment-section">
							<div class="col-md-12">
								<form method='POST'>
									<?php if($item['allow_commenting'] == 1){ ?>
											<h5><strong>Commenting has been disabled</strong></h5>
									<?php }
									else { 
										$retrieve_media_comment = retrieve_media_comment($mid); ?>
										<table class="table">
											<thead>
												<tr>
													<th><i>Username</i></th>
													<th><i>Comment</i></th>
													<th><i>Date</i></th>
													<th><i>Action</i></th>
												</tr>
											</thead>
											<tbody>
												<?php while($row = mysqli_fetch_assoc($retrieve_media_comment)) { ?>
													<tr>
														<td> <?=$row['user'] ?></td>
														<td> <?=$row['mc_comment'] ?></td>
														<td> <?=substr($row['mc_date'], 0,10) ?></td>
														<?php
															if($owner_u_id == $current_uid || $row['u_id'] == $current_uid) { ?> 
															<td>
																<input class="btn btn-danger" type='submit' name='Delete' value='Delete' />
																<input type='hidden' name='mc_id' value=<?=$row['mc_id'] ?> />
																<input type='hidden' name='m_id' value=<?=$mid?> />
															</td>
														<?php } ?>
													</tr>
												<?php } ?>
												<tr>
													<td> <?=$_SESSION['username'] ?></td>
													<td colspan=2>
														<textarea class="form-control" rows=3 type='text' name='media_comment' placeholder='Enter your comment here'></textarea>
													</td>
													<td>
														<input class="btn btn-info" type='submit' name='PostMediaComment' value='Submit' />
														<input type='hidden' name='m_id' value=<?=$mid ?> />
													</td>
												</tr>
											</tbody>
										</table>
									<?php } ?>			
								</form>
							</div>
						</div>
					<?php
					}	
					}
					
				$current_uid = get_current_uid($_SESSION['username']);
				$my_playlists = get_playlists($current_uid);
				?>
				
				<!-- Playlist modal starts here -->
				<div id='playlistModal' class='modal fade' tabindex='-1' role='dialog'>
					<div class='modal-dialog' role='document'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
								<h4 class='modal-title'>Add to Playlist/Collection</h4>
							</div>
							<div class='modal-body'>
								<form class="form-inline" method='post'>
									<input class="form-control" type='text' placeholder='Enter playlist name' name='PlaylistName'/>
									<input type='hidden' value='<?= $mid ?>' name='m_id'>
									<input class="btn btn-primary" type='submit' name='AddToNewPlaylist' value='Create and Add' /> 
								</form>
								<hr />
								<form class="form-inline" method='post'>
									<select class="form-control" name='SelectedPlaylist'>
										<?php while($row = mysqli_fetch_assoc($my_playlists)) { ?>
											<option value = "<?= $row['p_id'] ?>" name = "SelectedPlaylist"> <?= $row['p_name'] ?> </option>
										<?php } ?>
									</select>
									<input type='hidden' value='<?= $mid ?>' name='m_id'>
									<input class="btn btn-primary" type='submit' name='AddToExistingPlaylist' value='Add to Playlist' />
								</form>
							</div>
							<div class='modal-footer'>
								<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Playlist modal starts here -->
		</div>
	</body>
</html>