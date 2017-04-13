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
		<link rel="stylesheet" href="CSS/MyUploadsView.css">
		<link rel="stylesheet" href="CSS/bootstrap.min.css">
		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "BackHome" name="BackHome" method="post" action="Home.php">
			<input type="submit" value="Home" name = "Submit"/>
		</form>
		<?php
			if(isset($_GET['m_id'])){
				$mid = $_GET['m_id'];
				$item = fetch_media($mid);
				$current_uid = get_current_uid($_SESSION['username']);
				$owner_u_id = $item['owner_u_id'];
				$mediatitle = $item['m_title'];
				$url = 'Media_Uploads/'.$owner_u_id.'/'.$mid;
				if ($item['media_type'] == "Image"){ ?>
					<img class='display-image' src='<?= $url ?>'/>
					<?php
						if ($current_uid != $owner_u_id) {
							increment_view_count($mid);
						}
					?>
					<table class='media-tool-bar' align='center'>
						<tr>
							<p>
								<?php
									$row = display_meta_data($mid);
									$owner_u_id = $row['owner_u_id'];
									$uname_result = get_user_details($owner_u_id);
									echo "Title: " .$row['m_title'];
									echo "Description: " .$row['description'];
									echo "Posted by: " .$uname_result['uname'];
									echo "Uploaded on: " .substr($row['m_date'], 0, 10);
									echo "Media Type: " .$row['media_type'];
									echo "Number of views: " .$row['view_count'];
								?>
							</p>
						</tr>
						<tr> 
							<td>
								<form action = '' method = 'POST'>
									<input type='submit' value='Favourites' name='Favourites'/>
									<input type='hidden' value='<?= $mid ?>' name='m_id'>
								</form>
							</td>
							<td>
								<button class='btn btn-primary' id='add_to_playlist' data-toggle='modal' data-target='#playlistModal'>Add to Playlist</button>
							</td>
							<td>
								<button class='btn btn-primary' id='download' data-toggle='modal' data-target='#downloadmodal'>Download</button>
							</td>
						</tr>
					</table>
					<form method='POST'>
						<?php
							$check_allow_commenting = check_allow_commenting($mid);
							if($check_allow_commenting['allow_commenting'] == 1){
								echo "Commenting is disabled for this media";
							}
							else { 
								$retrieve_media_comment = retrieve_media_comment($mid);
								while($row = mysqli_fetch_assoc($retrieve_media_comment))
								{ ?>
									<table class='media-comment-bar' align='center'>
										<tr>
											<td> <?=$row['user'] ?></td>
											<td> <?=$row['mc_comment'] ?></td>
											<td> <?=substr($row['mc_date'], 0,10) ?></td>
											<?php
												if($owner_u_id == $current_uid || $row['u_id'] == $current_uid) { ?> 
												<td>
													<input type='submit' name='Delete' value='Delete' />
													<input type='hidden' name='mc_id' value=<?=$row['mc_id'] ?> />
													<input type='hidden' name='m_id' value=<?=$mid?> />
												</td>
											<?php } ?>
										</tr>
							
								<?php } ?>
										<tr>
											<td> <?=$_SESSION['username'] ?></td>
											<td>
												<input type='text' name='media_comment' placeholder='Enter your comment here' />
											</td>
											<td>
												<input type='submit' name='PostMediaComment' value='Submit' />
												<input type='hidden' name='m_id' value=<?=$mid ?> />
											</td>
										</tr>
									</table>
							<?php }	
						?>			
					</form>
				<?php }
				else if ($item['media_type'] == "Video"){ ?>
					<video class='display-video' src='<?= $url ?>' width='560' height='315' frame='2' controls></video>
					<?php
						if ($current_uid != $owner_u_id) {
							$mid = $_GET['m_id'];
							increment_view_count($mid);
						}
					?>
					<table class='media-tool-bar' align='center'>
						<tr>
							<p>
								<?php
									$row = display_meta_data($mid);
									$owner_u_id = $row['owner_u_id'];
									$uname_result = get_user_details($owner_u_id);
									echo "Title: " .$row['m_title'];
									echo "Description: " .$row['description'];
									echo "Posted by: " .$uname_result['uname'];
									echo "Uploaded on: " .substr($row['m_date'], 0, 10);
									echo "Media Type: " .$row['media_type'];
									echo "Number of views: " .$row['view_count'];
								?>
							</p>
						</tr>
						<tr> 
							<td>
								<form action = '' method = 'POST'>
									<input type='submit' value='Favourites' name='Favourites'/>
									<input type='hidden' value='<?= $mid ?>' name='m_id'>
								</form>
							</td>
							<td>
								<button class='btn btn-primary' id='add_to_playlist' data-toggle='modal' data-target='#playlistModal'>Add to Playlist</button>
							</td>
							<td>
								<button class='btn btn-primary' id='download' data-toggle='modal' data-target='#downloadmodal'>Download</button>
							</td>
						</tr>
					</table>
					<form method='POST'>
						<?php
							$check_allow_commenting = check_allow_commenting($mid);
							if($check_allow_commenting['allow_commenting'] == 1){
								echo "Commenting is disabled for this media";
							}
							else { 
								$retrieve_media_comment = retrieve_media_comment($mid);
								while($row = mysqli_fetch_assoc($retrieve_media_comment))
								{ ?>
									<table class='media-comment-bar' align='center'>
										<tr>
											<td> <?=$row['user'] ?></td>
											<td> <?=$row['mc_comment'] ?></td>
											<td> <?= substr($row['mc_date'], 0, 10) ?></td>
											<?php
												if($owner_u_id == $current_uid || $row['u_id'] == $current_uid) { ?> 
												<td>
													<input type='submit' name='Delete' value='Delete' />
													<input type='hidden' name='mc_id' value=<?=$row['mc_id'] ?> />
													<input type='hidden' name='m_id' value=<?=$mid?> />
												</td>
											<?php } ?>
										</tr>
							
								<?php } ?>
										<tr>
											<td> <?=$_SESSION['username'] ?></td>
											<td>
												<input type='text' name='media_comment' placeholder='Enter your comment here' />
											</td>
											<td>
												<input type='submit' name='PostMediaComment' value='Submit' />
												<input type='hidden' name='m_id' value=<?=$mid ?> />
											</td>
										</tr>
									</table>
							<?php }	
						?>			
					</form>
				<?php }
				else if ($item['media_type'] == "Audio"){ ?>
					<audio class='display-audio' src="<?= $url ?>" controls></audio>
					<?php
						if ($current_uid != $owner_u_id) {
							$mid = $_GET['m_id'];
							increment_view_count($mid);
						}
					?>
					<table class='media-tool-bar' align='center'>
						<tr>
							<p>
								<?php
									$row = display_meta_data($mid);
									$owner_u_id = $row['owner_u_id'];
									$uname_result = get_user_details($owner_u_id);
									echo "Title: " .$row['m_title'];
									echo "Description: " .$row['description'];
									echo "Posted by: " .$uname_result['uname'];
									echo "Uploaded on: " .substr($row['m_date'], 0, 10);
									echo "Media Type: " .$row['media_type'];
									echo "Number of views: " .$row['view_count'];
								?>
							</p>
						</tr>
						<tr> 
							<td>
								<form action = '' method = 'POST'>
									<input type='submit' value='Favourites' name='Favourites'/>
									<input type='hidden' value="<?= $mid ?>" name='m_id' />
								</form>
							</td>
							<td>
								<button class='btn btn-primary' id='add_to_playlist' data-toggle='modal' data-target='#playlistModal'>Add to Playlist</button>
							</td>
							<td>
								<button class='btn btn-primary' id='download' data-toggle='modal' data-target='#downloadmodal'>Download</button>
							</td>
						</tr>
					</table>
					<form method='POST'>
						<?php
							$check_allow_commenting = check_allow_commenting($mid);
							if($check_allow_commenting['allow_commenting'] == 1){
								echo "Commenting is disabled for this media";
							}
							else { 
								$retrieve_media_comment = retrieve_media_comment($mid);
								while($row = mysqli_fetch_assoc($retrieve_media_comment))
								{ ?>
									<table class='media-comment-bar' align='center'>
										<tr>
											<td> <?=$row['user'] ?></td>
											<td> <?=$row['mc_comment'] ?></td>
											<td> <?= substr($row['mc_date'], 0,10) ?></td>
											<?php
												if($owner_u_id == $current_uid || $row['u_id'] == $current_uid) { ?> 
												<td>
													<input type='submit' name='Delete' value='Delete' />
													<input type='hidden' name='mc_id' value=<?=$row['mc_id'] ?> />
													<input type='hidden' name='m_id' value=<?=$mid?> />
												</td>
											<?php } ?>
										</tr>
							
								<?php } ?>
										<tr>
											<td> <?=$_SESSION['username'] ?></td>
											<td>
												<input type='text' name='media_comment' placeholder='Enter your comment here' />
											</td>
											<td>
												<input type='submit' name='PostMediaComment' value='Submit' />
												<input type='hidden' name='m_id' value=<?=$mid ?> />
											</td>
										</tr>
									</table>
							<?php }	
						?>			
					</form>
				<?php } 
			}
			
			$current_uid = get_current_uid($_SESSION['username']);
			$my_playlists = get_playlists($current_uid);
			?>
			
			<div id='playlistModal' class='modal fade' tabindex='-1' role='dialog'>
				<div class='modal-dialog' role='document'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<h4 class='modal-title'>Add to Playlist/Collection</h4>
						</div>
						<div class='modal-body'>
							<form method='post'>
								<input type='text' placeholder='Enter playlist name' name='PlaylistName'/>
								<input type='hidden' value='<?= $mid ?>' name='m_id'>
								<input type='submit' name='AddToNewPlaylist' value='Create and Add' /> 
							</form>
							<form method='post'>
								<select name='SelectedPlaylist'>
									<?php while($row = mysqli_fetch_assoc($my_playlists)) { ?>
										<option value = "<?= $row['p_id'] ?>" name = "SelectedPlaylist"> <?= $row['p_name'] ?> </option>
									<?php } ?>
								</select>
								<input type='hidden' value='<?= $mid ?>' name='m_id'>
								<input type='submit' name='AddToExistingPlaylist' value='Add to Playlist' />
							</form>
						</div>
						<div class='modal-footer'>
							<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						</div>
					</div>
				</div>
			</div>
	</body>
</html>