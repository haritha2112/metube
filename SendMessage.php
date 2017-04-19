<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['SendMessage'])){
		$message = $_POST['Message'];
		$to_u_id = $_POST['u_id'];
		$from_u_id = get_current_uid($_SESSION['username']);
		send_personal_message($from_u_id, $to_u_id, $message);
	}
?>
<html>
	<head>
		<title> Send Message </title>
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
					<h1 class="sub-title"> Send Message </h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackMessage" method="get" action="Message.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<div class="row select-bar">
				<div class="col-md-12 text-center">
					<form class="form-inline" method="get" action="">
						<div class="form-group">
							<label for="SearchOption"> Choose </label>
							<select class="form-control" id="SearchOption" name='SearchOption'>
								<option value = "CONTACT" name = "SearchOption"> My Contacts </option>
								<option value = "FRIEND" name = "SearchOption"> My Friends </option>
								<option value = "FAMILY" name = "SearchOption"> My Family </option>
							</select>
						</div>
						<input class="btn btn-basic" type="submit" value="Go" name = "Search"/>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 text-center main-content">
					<table class = "table table-striped" align = "center">
						<thead>
							<tr>
								<th><i>Username</i></th>
								<th><i>Firstname</i></th>
								<th><i>Lastname</i></th>
								<th><i>Type Message</i></th>
								<th><i>Action</i></th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Search'])){
									$current_uid = get_current_uid($_SESSION['username']);
									$search_results = retrive_contact($current_uid, $_GET['SearchOption']);
									while($row = mysqli_fetch_assoc($search_results)) { ?>
										<tr>
											<td class = 'grid-item'><?= $row['uname'] ?></td>
											<td class = 'grid-item'><?= $row['fname'] ?></td>
											<td class = 'grid-item'><?= $row['lname'] ?></td>
											<form action = '' method = 'post'>
												<td class = 'grid-item'>
													<textarea class='form-control' rows=3 type='text' name='Message' placeholder='600 Character limit'></textarea>
												</td>
											<td>
												<input class="btn btn-info" type='submit' name='SendMessage' value='Send' />
												<input type='hidden' name='u_id' value='<?= $row['u_id'] ?>' />
											</td>
											</form>
										</tr>
									<?php }
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>