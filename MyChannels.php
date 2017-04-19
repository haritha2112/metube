<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['CreateChannel'])){
		$current_uid = get_current_uid($_SESSION['username']);
		$c_name = $_POST['ChannelName'];
		$c_description = $_POST['ChannelDescription'];
		create_new_channel($current_uid, $c_name, $c_description);
	}
?>
<html>
	<head>
		<title> My Channels </title>
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
			.add-channel-div {
				margin-top:2%;
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
					<h1 class="sub-title">My Channels</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<div class="row text-center add-channel-div">
				<div class="col-md-12">
					<button class='btn btn-primary' id='create_channel' data-toggle='modal' data-target='#addChannelModal'>Create a New Channel</button>
				</div>
			</div>				
			<?php
				$current_uid = get_current_uid($_SESSION['username']);
				$my_channels = get_my_channels($current_uid);
			?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 main-content">
					<div class="panel-group" id="accordion">
						<?php while($row = mysqli_fetch_assoc($my_channels)) { 
							$my_channel_media = get_channel_media($row['c_id']);
						?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $row['c_id'] ?>"> <?= $row['c_name'] ?> </a>
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
		
		<!-- Add new channel modal-->
		<div id='addChannelModal' class='modal fade' tabindex='-1' role='dialog'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<h4 class='modal-title'>Create a new Channel</h4>
					</div>
					<div class='modal-body'>
						<form method='post'>
							<div class='form-group'>
								<label for="ChannelName" class="form-control-label">Enter Channel Name</label>
								<input type='text' id="ChannelName" class="form-control" name='ChannelName'/>
							</div>
							<div class='form-group'>
								<label for="ChannelDescription" class="form-control-label">Give a Description</label>
								<textarea rows="10" id="ChannelDescription" class="form-control" name="ChannelDescription" ></textarea>
							</div>
							<div class='form-group'>
								<input type='submit' name='CreateChannel' value='Create' /> 
							</div>
						</form>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Add new channel modal ends here -->
			
	</body>
</html>