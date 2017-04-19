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
	
	if(isset($_POST['EditMetaData'])){
		$m_id = $_POST['m_id'];
		$description = $_POST['description'];
		$share_type = $_POST['ShareType'];
		$download_type = $_POST['DownloadType'];
		$rate = $_POST['Rate'];
		$comment = $_POST['Comment'];
		edit_meta_data($m_id, $description, $share_type, $download_type, $rate, $comment);
	}
	
?>

<!-- User's Media Upload's Page -->
<html>
	<head>
		<title> My Uploads </title>
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
				font-size: 35px;
			}
			.sub-sub-title {
				font-size: 28px;
			}
			.logout{
				margin-top: 20%;
			}
			.sub-title-button {
				margin-top: 3%;
			}
			.sub-part{
				margin-top: 1%;
			}
			th {
				padding-top: 1% !important;
				padding-bottom: 1% !important;
				font-size: 16px;
				background: #428bca;
				color: white
			}
			td a,p {
				font-size: 14px !important;
				word-break: break-all;
				word-wrap: break-word;
			}
			td:nth-child(1) {
				width: 10%;
			}
			td:nth-child(2) {
				width: 15%;
			}
			table {
				background: lightgray;
				border-radius: 20px;
			}
		</style>
		<script type="text/javascript">
			$(function() {
				$(".addToChannelButton").click(function() {
					var mediaId = $(this).attr('data-mediaId');
					$(".modal-body #formMediaId").val(mediaId);
				});
				$(".editMetaData").click(function() {
					var mediaId = $(this).attr('data-mediaId');
					$(".modal-body #formMediaId").val(mediaId);
				});
			})
		</script>
	</head>
	<body>
		<div class="container-fluid">
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
					<h1 class="sub-title">My Uploads</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<?php
				$owner_u_id = get_current_uid($_SESSION['username']);
				$images = retrive_my_uploads($owner_u_id, "Image");
				$videos = retrive_my_uploads($owner_u_id, "Video");
				$audios = retrive_my_uploads($owner_u_id, "Audio");
				$all_media_types = array("Images" => $images, "Videos" => $videos, "Audio" => $audios);
			?>
			<?php foreach ($all_media_types as $media_type => $media_elements) { ?>
				<div class="row text-center">
					<div class="col-md-12 sub-part">
						<div class="row">
							<div class="col-md-12">
								<h2 class="sub-sub-title"> <?= $media_type ?> </h2>
							</div>
						</div>
						<table class="table">
							<thead>
								<tr>
									<th>Media</th>
									<th>Description</th>
									<th>Category</th>
									<th>Uploaded on</th>
									<th>Sharing?</th>
									<th>Download?</th>
									<th>Commenting?</th>
									<th>Rating?</th>
									<th>View count</th>
									<th>Add to Channel</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php while($row = mysqli_fetch_assoc($media_elements)) { ?>
									<tr>
										<td>
											<a href='MediaView.php?m_id=<?= $row['m_id'] ?>'><?= $row['m_title'] ?></a>
										</td>
										<td><p><?= $row['description'] ?></p></td>
										<td><p><?= $row['category'] ?></p></td>
										<td><p><?= substr($row['m_date'], 0, 10) ?></p></td>
										<td>
											<?php if ($row['share_type'] == 0) { ?>
												<p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p>
											<?php } else { ?>
												<p><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></p>
											<?php } ?>
										</td>
										<td>
											<?php if ($row['download_type'] == 0) { ?>
												<p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p>
											<?php } else { ?>
												<p><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></p>
											<?php } ?>
										</td>
										<td>
											<?php if ($row['allow_commenting'] == 0) { ?>
												<p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p>
											<?php } else { ?>
												<p><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></p>
											<?php } ?>
										</td>
										<td>
											<?php if ($row['allow_rating'] == 0) { ?>
												<p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></p>
											<?php } else { ?>
												<p><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></p>
											<?php } ?>
										</td>
										<td><p><?= $row['view_count'] ?></p></td>
										<td>
											<?php if ($row['share_type'] == 0) { ?>
												<p> <button class='glyphicon glyphicon-plus addToChannelButton' data-mediaId=<?= $row['m_id'] ?> 
													data-toggle='modal' data-target='#addToChannelModal'></button>
												</p>
											<?php } else { ?>
												<p> Can't add private media </p>
											<?php } ?>
										</td>
										<td>
											<p> <button class='glyphicon glyphicon-pencil editMetaData' data-mediaId=<?= $row['m_id'] ?> 
												data-toggle='modal' data-target='#editMetaDataModal'></button>
											</p>
										</td>
										<td>
											<form method="POST" onsubmit="return confirm('Are you sure you want to proceed?')">
												<input type="hidden" name="m_id" value="<?= $row['m_id'] ?>" />
												<button class="glyphicon glyphicon-trash" type="submit" name="DeleteMedia" value="X" ></button>
											</form>
										</td>
									</tr>
								<?php } ?>
							</tbody>	
						</table>
					</div>
				</div>
			<?php } ?>
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
							<div class='form-group text-center'>
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
		
		<!-- Meta Data Edit Modal-->
		<div id='editMetaDataModal' class='modal fade' tabindex='-1' role='dialog'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<h4 class='modal-title'> Edit Meta Data</h4>
					</div>
					<div class='modal-body'>
						<form method='post'>
							<div class='form-group'>
								<label for="Description" class="form-control-label">Description</label>
								<textarea id="Description" rows=3 class="form-control" name="description" placeholder="Enter new description" required></textarea>
							</div>
							<div class='form-group'>
								<label for="AllowSharing" class="form-control-label">Allow Sharing?</label>
								<div class="input-group" id="AllowSharing">
									<input type="radio" name="ShareType" value="0" required> Yes
									<input type="radio" name="ShareType" value="1"> No
								</div>
							</div>
							<div class='form-group'>
								<label for="AllowDownload" class="form-control-label">Allow Downloading?</label>
								<div class="input-group" id="AllowDownload">
									<input type="radio" name="DownloadType" value="0" required> Yes
									<input type="radio" name="DownloadType" value="1"> No
								</div>
							</div>
							<div class='form-group'>
								<label for="AllowCommenting" class="form-control-label">Allow Commenting?</label>
								<div class="input-group" id="AllowCommenting">
									<input type="radio" name="Comment" value="0"required> Yes
									<input type="radio" name="Comment" value="1"> No
								</div>
							</div>
							<div class='form-group'>
								<label for="AllowRating" class="form-control-label">Allow Rating?</label>
								<div class="input-group" id="AllowRating">
									<input type="radio" name="Rate" value="0" required> Yes
									<input type="radio" name="Rate" value="1"> No
								</div>
							</div>
							<div class='form-group'>
								<input class="btn btn-primary" type='submit' name='EditMetaData' value='Save Changes' />
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
		<!--  Meta Data Edit Modal ends here -->
	</body>
</html>