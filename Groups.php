<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['CreateGroup'])) {
		$u_id = get_current_uid($_SESSION['username']);
		$group_topic = $_POST['GroupTopic'];
		create_group($u_id,$group_topic);
	}
?>
<html>
	<head>
		<title> Groups </title>
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
				padding-top: 2%;
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
					<h1 class="sub-title"> Groups </h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackMessage" method="get" action="Message.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back"/>
					</form>
				</div>
			</div>
			<div class="row text-center main-content">
				<div class="col-md-12">
					<form class="form-inline" name="CreateGroup" method="post" action="">
						<div class="form-group">
							<label for="group-name"> Group Name </label>
							<input id="group-name" class="form-control" type="text" name="GroupTopic" placeholder="Enter the group's topic" />
						</div>
						<input class="btn btn-basic create_group" type="submit" value="Create New Group" name = "CreateGroup"/>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 text-center main-content">
					<table class = "table table-striped" align = "center">
						<thead>
							<tr>
								<th><i> Group Topic </i></th>
								<th><i> Date Created </i></th>
								<th><i> View </i></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$current_uid = get_current_uid($_SESSION['username']);
								$search_results = retrive_groups($current_uid);
								while($row = mysqli_fetch_assoc($search_results)) { ?>
									<tr>
										<td><?= $row['g_topic'] ?></td>
										<td><?= substr($row['g_date'], 0, 10) ?></td>
										<form action = 'GroupDiscussion.php' method = 'get'>
											<td>
												<input class="btn btn-info" type='submit' name='ViewGroupDiscussion' value='View' />
												<input type='hidden' name='g_id' value='<?= $row['g_id'] ?>' />
												<input type='hidden' name='g_topic' value='<?= $row['g_topic'] ?>' />
												<input type='hidden' name='owner_u_id' value='<?= $row['owner_u_id'] ?>' />
											</td>
										</form>
									</tr>
								<?php }
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>