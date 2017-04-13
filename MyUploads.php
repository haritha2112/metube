<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['AddToChannel'])){
		$c_id = $_POST['SelectedChannel'];
		$m_id = $_POST['m_id'];
		add_to_channel($c_id, $m_id);
	}
	
	if(isset($_POST['DeleteMedia'])) {
		$m_id = $_POST['m_id'];
		delete_media($m_id);
	}
	
?>
<html>
	<head>
		<title> My Uploads </title>
		<link rel="stylesheet" href="CSS/bootstrap.min.css">
		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(function() {
				$(".addToChannelButton").click(function() {
					var mediaId = $(this).attr('data-mediaId');
					$(".modal-body #formMediaId").val(mediaId);
				});
			})
		</script>
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "BackHome" name="BackHome" method="post" action="Home.php">
			<input type="submit" value="Home" name = "Submit"/>
		</form>
		<hr>
		<form class = "BackProfile" name="BackProfile" method="post" action="Profile.php">
			<input  type="submit" value="Profile" name = "Submit"/>
		</form>
		<h2> My Uploads </h2>
		<?php
			$owner_u_id = get_current_uid($_SESSION['username']);
			$images = retrive_my_uploads($owner_u_id, "Image");
			$videos = retrive_my_uploads($owner_u_id, "Video");
			$audios = retrive_my_uploads($owner_u_id, "Audio");
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-12 jumbotron">
					<h4>Images</h4>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Media Name</th>
								<th>Description</th>
								<th>Category</th>
								<th> Uploaded on</th>
								<th>Allow Sharing?</th>
								<th>Allow Download?</th>
								<th>Allow Commenting?</th>
								<th>Allow Rating?</th>
								<th>View count</th>
								<th>Add to Channel</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = mysqli_fetch_assoc($images)) { ?>
								<tr>
									<td>
										<a href='MediaView.php?m_id=<?= $row['m_id'] ?>'><?= $row['m_title'] ?></a>
									</td>
									<td><p><?= $row['description'] ?></p></td>
									<td><p><?= $row['category'] ?></p></td>
									<td><p><?= substr($row['m_date'], 0, 10) ?></p></td>
									<td>
										<?php if ($row['share_type'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['download_type'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['allow_commenting'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['allow_rating'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td><p><?= $row['view_count'] ?></p></td>
									<td>
										<?php if ($row['share_type'] == 0) { ?>
											<button class='btn btn-primary addToChannelButton' data-mediaId=<?= $row['m_id'] ?> 
												data-toggle='modal' data-target='#addToChannelModal'>Add</button>
										<?php } else { ?>
											<p> Can't add private media </p>
										<?php } ?>
									</td>
									<td>
										<form method="POST">
											<input type="hidden" name="m_id" value="<?= $row['m_id'] ?>" />
											<input class="btn btn-danger" type="submit" name="DeleteMedia" value="Delete" />
										</form>
									</td>
								</tr>
							<?php } ?>
						</tbody>	
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 jumbotron">
					<h4>Videos</h4>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Media Name</th>
								<th>Description</th>
								<th>Category</th>
								<th> Uploaded on</th>
								<th>Allow Sharing?</th>
								<th>Allow Download?</th>
								<th>Allow Commenting?</th>
								<th>Allow Rating?</th>
								<th>View count</th>
								<th>Add to Channel</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = mysqli_fetch_assoc($videos)) { ?>
								<tr>
									<td>
										<a href='MediaView.php?m_id=<?= $row['m_id'] ?>'><?= $row['m_title'] ?></a>
									</td>
									<td><p><?= $row['description'] ?></p></td>
									<td><p><?= $row['category'] ?></p></td>
									<td><p><?= substr($row['m_date'], 0, 10) ?></p></td>
									<td>
										<?php if ($row['share_type'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['download_type'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['allow_commenting'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['allow_rating'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td><p><?= $row['view_count'] ?></p></td>
									<td>
										<?php if ($row['share_type'] == 0) { ?>
											<button class='btn btn-primary addToChannelButton' data-mediaId=<?= $row['m_id'] ?> 
												data-toggle='modal' data-target='#addToChannelModal'>Add</button>
										<?php } else { ?>
											<p> Can't add private media </p>
										<?php } ?>
									</td>
									<td>
										<form method="POST">
											<input type="hidden" name="m_id" value="<?= $row['m_id'] ?>" />
											<input class="btn btn-danger" type="submit" name="DeleteMedia" value="Delete" />
										</form>
									</td>
								</tr>
							<?php } ?>
						</tbody>	
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 jumbotron">
					<h4>Audio</h4>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Media Name</th>
								<th>Description</th>
								<th>Category</th>
								<th> Uploaded on</th>
								<th>Allow Sharing?</th>
								<th>Allow Download?</th>
								<th>Allow Commenting?</th>
								<th>Allow Rating?</th>
								<th>View count</th>
								<th>Add to Channel</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = mysqli_fetch_assoc($audios)) { ?>
								<tr>
									<td>
										<a href='MediaView.php?m_id=<?= $row['m_id'] ?>'><?= $row['m_title'] ?></a>
									</td>
									<td><p><?= $row['description'] ?></p></td>
									<td><p><?= $row['category'] ?></p></td>
									<td><p><?= substr($row['m_date'], 0, 10) ?></p></td>
									<td>
										<?php if ($row['share_type'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['download_type'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['allow_commenting'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td>
										<?php if ($row['allow_rating'] == 0) { ?>
											<p> Yes </p>
										<?php } else { ?>
											<p> No </p>
										<?php } ?>
									</td>
									<td><p><?= $row['view_count'] ?></p></td>
									<td>
										<?php if ($row['share_type'] == 0) { ?>
											<button class='btn btn-primary addToChannelButton' data-mediaId=<?= $row['m_id'] ?> 
												data-toggle='modal' data-target='#addToChannelModal'>Add</button>
										<?php } else { ?>
											<p> Can't add private media </p>
										<?php } ?>
									</td>
									<td>
										<form method="POST">
											<input type="hidden" name="m_id" value="<?= $row['m_id'] ?>" />
											<input class="btn btn-danger" type="submit" name="DeleteMedia" value="Delete" />
										</form>
									</td>
								</tr>
							<?php } ?>
						</tbody>	
					</table>
				</div>
			</div>
		</div>
		
		
		<!-- Add to channel modal-->
		<div id='addToChannelModal' class='modal fade' tabindex='-1' role='dialog'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<h4 class='modal-title'>Add to Channel</h4>
					</div>
					<div class='modal-body'>
						<form method='post'>
							<div class='form-group'>
								<label for="ChannelName" class="form-control-label">Select Channel Name</label>
								<select id="ChannelName" class="form-control" name='SelectedChannel'>
									<?php 
									$current_uid = get_current_uid($_SESSION['username']);
									$my_channels = get_my_channels($current_uid);
									while($row = mysqli_fetch_assoc($my_channels)) { ?>
										<option value = "<?= $row['c_id'] ?>" name = "SelectedChannel"> <?= $row['c_name'] ?> </option>
									<?php } ?>
								</select>
							</div>
							<div class='form-group'>
								<input class="btn btn-primary" type='submit' name='AddToChannel' value='Add to Channel' />
							</div>
							<input type='hidden' id="formMediaId" name='m_id' value="" />							
						</form>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Add to channel modal ends here -->
	</body>
</html>