<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['AddToGroup'])){
		$g_id = $_POST['g_id'];
		$u_id = $_POST['u_id'];
		$g_topic = $_POST['g_topic'];
		$owner_u_id = $_POST['owner_u_id'];
		add_user_to_group($g_id, $u_id, $owner_u_id, $g_topic);
	}
	
	if(isset($_POST['RemoveUser'])){
		$g_id = $_POST['g_id'];
		$u_id = $_POST['u_id'];
		$g_topic = $_POST['g_topic'];
		$owner_u_id = $_POST['owner_u_id'];
		remove_user_from_group($u_id, $g_id);
		header('Location: GroupDiscussion.php?g_id='.$g_id.'&owner_u_id='.$owner_u_id.'&g_topic='.$g_topic.'');
	}
	
	if(isset($_POST['SendGroupMessage'])){
		$g_id = $_POST['g_id'];
		$message = $_POST['message'];
		$g_topic = $_POST['g_topic'];
		$current_id = get_current_uid($_SESSION['username']);
		$owner_u_id = $_POST['owner_u_id'];
		send_group_message($g_id, $message, $owner_u_id, $current_id, $g_topic);
	}
	
	if(isset($_POST['Delete'])){
		$gmsg_id = $_POST['gmsg_id'];
		$g_id = $_POST['g_id'];
		$owner_u_id = $_POST['u_id'];
		$g_topic = $_POST['g_topic'];
		delete_group_message($gmsg_id, $g_id, $owner_u_id, $g_topic);
	}
	

?>
<html>
	<head>
		<title> Group Discussion </title>
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
				padding-top: 3%;
			}
			.logout{
				margin-top: 20%;
			}
			.sub-title-button {
				margin-top: 3%;
			}
			.select-bar {
				margin-top: 2%;
			}
			th {
				text-align: center;
				padding-top: 1% !important;
				padding-bottom: 1% !important;
				font-size: 16px;
				background: #428bca;
				color: white
			}
			td {
				text-align: center;
				font-size: 14px !important;
				word-break: break-all;
				word-wrap: break-word;
			}
			table {
				background: lightgray;
				border-radius: 20px;
			}
		</style>
		<meta http-equiv="pragma" content="no-cache" />
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
					<h1 class="sub-title"> Group Discussion </h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackMessage" method="get" action="Groups.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<div class="row main-content">
				<div class="col-md-4">
					<?php
						$current_uid = get_current_uid($_SESSION['username']);
						if($current_uid == $_GET['owner_u_id']) { ?>
							<div class="row main-content text-center">
								<div class="col-md-12">
									<form class="form-inline" method='get' action=''>
										<div class="form-group">
											<label for="SearchOption"> Choose </label>
											<select class="form-control" id="SearchOption" name='SearchOption'>
												<option value = 'CONTACT' name = 'SearchOption'> My Contacts </option>
												<option value = 'FRIEND' name = 'SearchOption'> My Friends </option>
												<option value = 'FAMILY' name = 'SearchOption'> My Family </option>
											</select>
										</div>
										<input class="btn btn-basic" type='submit' value='Go' name = 'Search'/>
										<input type='hidden' name='g_id' value='<?= $_GET['g_id'] ?>' />
										<input type='hidden' name='owner_u_id' value='<?= $_GET['owner_u_id'] ?>' />
										<input type='hidden' name='g_topic' value='<?= $_GET['g_topic'] ?>' />
									</form>
								</div>
							</div>
							<hr/>
							<div class="row">
								<div class="col-md-12">
									<?php
									if(isset($_GET['Search'])){ ?>
										<table class ='table table-striped' align = 'center'>
											<thead>
												<tr>
													<th><i>Username</i></th>
													<th><i>Name</i></th>
													<th><i>Action</i></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$search_results = search_group_contact($current_uid, $_GET['SearchOption'], $_GET['g_id']);
												while($row = mysqli_fetch_assoc($search_results)) { ?>
													<tr>
														<td><?= $row['uname'] ?></td>
														<td><?= $row['fname'] ?> <?= $row['lname'] ?></td>
														<td>
															<form action = '' method = 'post'>
																<input class="btn btn-info" type='submit' name='AddToGroup' value='Add To Group' />
																<input type='hidden' name='u_id' value='<?= $row['u_id'] ?>' />
																<input type='hidden' name='g_id' value='<?= $_GET['g_id'] ?>' />
																<input type='hidden' name='g_topic' value='<?= $_GET['g_topic'] ?>' />
																<input type='hidden' name='owner_u_id' value='<?= $_GET['owner_u_id'] ?>' />
															</form>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									<?php } ?>
								</div>
							</div>
						<?php } 
					?>
					<hr/>
					<div class="row">
						<div class="col-md-12">
							<h4> Group Users </h4>
							<table class="table table-striped">
								<thead>
									<tr>
										<th><i>Username</i></th>
										<?php if ($current_uid == $_GET['owner_u_id']) { ?>
											<th><i>Action</i></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php 
										$group_users = fetch_group_users($_GET['g_id']);
										while($row = mysqli_fetch_assoc($group_users)) { ?>
											<tr>
												<td><?= $row['uname'] ?> </td>
												<?php if($current_uid == $_GET['owner_u_id'] && $row['u_id'] != $current_uid) { ?> 
													<form method="post" action="" onsubmit="return confirm('Are you sure you want to proceed?')">
														<td>
															<input class="btn btn-danger" type='submit' name='RemoveUser' value='Remove' />
															<input type='hidden' name='u_id' value='<?= $row['u_id'] ?>' />
															<input type='hidden' name='g_id' value='<?= $_GET['g_id'] ?>' />
															<input type='hidden' name='g_topic' value='<?= $_GET['g_topic'] ?>' />
															<input type='hidden' name='owner_u_id' value='<?= $_GET['owner_u_id'] ?>' />
														</td>
													</form>
												<?php } ?>
											</tr>
									<?php } ?>
								</tbody>
							</table>			
						</div>
					</div>
				</div>
				<div class="col-md-offset-1 col-md-7 text-center">
					<h2><?= $_GET['g_topic'] ?></h2>
					<hr/>
					<form method='POST'>
						<table class="table">
							<thead>
								<tr>
									<th><i>Username</i></th>
									<th><i>Message</i></th>
									<th><i>Date</i></th>
									<th><i>Action</i></th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$result = retrieve_group_messages($_GET['g_id']);
									while($row = mysqli_fetch_assoc($result)){ ?>
										<tr>
											<td><?= $row['uname'] ?></td>
											<td><?= $row['message'] ?></td>
											<td><?= substr($row['gmsg_date'], 0, 10) ?></td>
											<?php
												if($row['u_id'] == $current_uid) { ?> 
												<td>
													<input class="btn btn-danger Delete" type='submit' name='Delete' value='Delete' />
													<input type='hidden' name='gmsg_id' value=<?=$row['gmsg_id'] ?> />
													<input type='hidden' name='g_id' value=<?=$row['g_id']?> />
													<input type='hidden' name='u_id' value=<?=$row['u_id']?> />
													<input type='hidden' name='g_topic' value=<?=$row['g_topic']?> />
												</td>
											<?php } ?>
										</tr>
								<?php } ?>
							</tbody>
						</table>
					</form>
					<form class="form-inline" method='post' action=''>
							<input class="form-control" type='text' name='message' placeholder='Enter your message here' />
							<input class="btn btn-info" type='submit' name='SendGroupMessage' value='Send' />
							<input type='hidden' name='g_id' value='<?= $_GET['g_id'] ?>' />
							<input type='hidden' name='g_topic' value='<?= $_GET['g_topic'] ?>' />
							<input type='hidden' name='owner_u_id' value='<?= $_GET['owner_u_id'] ?>' />
					</form>
				</div>
			</div>
		</div>
	</body>
</html>