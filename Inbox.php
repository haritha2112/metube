<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['DeleteMessage'])){
		$msg_id = $_POST['msg_id'];
		delete_personal_message($msg_id);
	}
?>
<html>
	<head>
		<title> Inbox </title>
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
					<h1 class="sub-title">Inbox</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Message.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back"/>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 text-center main-content">
					<table class = "table table-striped" align = "center">
						<thead>
							<tr>
								<th><i> From </i></th>
								<th><i> Message </i></th>
								<th><i> Time </i></th>
								<th><i> Action </i></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$current_uid = get_current_uid($_SESSION['username']);
								$display_messages = retrive_personal_message($current_uid);
								while($row = mysqli_fetch_assoc($display_messages)) { ?>
									<tr>
										<td><?= $row['uname'] ?></td>
										<td><?= $row['message'] ?></td>
										<td><?= substr($row['msg_date'], 0, 10) ?></td>
										<form action = '' method = 'post'>
											<td>
												<input class='btn btn-danger' type='submit' name='DeleteMessage' value='Delete' />
												<input type='hidden' name='msg_id' value='<?= $row['msg_id'] ?>' />
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