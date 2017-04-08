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
		<hr>
		<form class = "BackMyUploads" name="BackMyUploads" method="post" action="MyUploads.php">
			<input  type="submit" value="Back" name = "Submit"/>
		</form>
		<?php
			if(isset($_GET['m_id'])){
				$mid = $_GET['m_id'];
				$item = fetch_media($mid);
				$current_uid = get_current_uid($_SESSION['username']);
				$owner_u_id = $item['owner_u_id'];
				if ($current_uid != $owner_u_id) {
					increment_view_count($m_id);
				}
				$mediatitle = $item['m_title'];
				$url = 'Media_Uploads/'.$owner_u_id.'/'.$mid;
				if ($item['media_type'] == "Image"){ ?>
					<img class='display-image' src='<?= $url ?>'/>
					<table class='media-tool-bar' align='center'>
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
						</tr>
					</table>
				<?php }
				else if ($item['media_type'] == "Video"){ ?>
					<video class='display-video' src='<?= $url ?>' width='560' height='315' frame='2' controls></video>
					<table class='media-tool-bar' align='center'>
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
						</tr>
					</table>
				<?php }
				else if ($item['media_type'] == "Audio"){ ?>
					<audio class='display-audio' src="<?= $url ?>" controls></audio>
					<table class='media-tool-bar' align='center'>
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
						</tr>
					</table>
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