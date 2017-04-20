<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['SaveType'])){
		$type = $_POST['Type'];
		$u_id = $_POST['u_id'];
		$current_id = get_current_uid($_SESSION['username']);
		update_contact_type($current_id, $u_id, $type);
	}
	
	if(isset($_POST['DeleteContact'])){
		$u_id = $_POST['u_id'];
		$current_id = get_current_uid($_SESSION['username']);
		delete_contact($current_id, $u_id);
	}
?>
<html>
	<head>
		<title> MyPeople </title>
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
					<h1 class="sub-title"> My People </h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
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
								<option value = "BLOCKED" name = "SearchOption"> Blocked </option>
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
								<th><i>Action</i></th>
								<th><i>Save</i></th> 
								<th><i>Delete</i></th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Search'])){
									$current_uid = get_current_uid($_SESSION['username']);
									$search_results = retrive_contact($current_uid, $_GET['SearchOption']);
									while($row = mysqli_fetch_assoc($search_results)) {
										echo "<tr>
											<td>".$row['uname']."</td>
											<td>".$row['fname']."</td>
											<td>".$row['lname']."</td>
											<form action = '' method = 'post'>
												<td>
													<select  class='form-control' name = 'Type'>";
													if($row['type'] == 'CONTACT') {
														echo "<option value = 'CONTACT' name = 'Type' selected> Contact </option>";
													} else {
														echo "<option value = 'CONTACT' name = 'Type'> Contact </option>";
													}
													
													if($row['type'] == 'FRIEND') {
														echo "<option value = 'FRIEND' name = 'Type' selected> Friend </option>";
													} else {
														echo "<option value = 'FRIEND' name = 'Type'> Friend </option>";
													}
													
													if($row['type'] == 'FAMILY') {
														echo "<option value = 'FAMILY' name = 'Type' selected> Family </option>";
													} else {
														echo "<option value = 'FAMILY' name = 'Type'> Family </option>";
													}
													
													if($row['type'] == 'BLOCKED') {
														echo "<option value = 'BLOCKED' name = 'Type' selected> Blocked </option>";
													} else {
														echo "<option value = 'BLOCKED' name = 'Type'> Blocked </option>";
													}
													echo "</select>
												</td>
											<td>
												<input class='btn btn-info' type='submit' name='SaveType' value='Save' />
												<input type='hidden' name='u_id' value='".$row['u_id']."' />
											</td>
											<td>
												<input class='btn btn-danger' type='submit' name='DeleteContact' value='Delete' />
												<input type='hidden' name='u_id' value='".$row['u_id']."' />
											</td>											
											</form>
										</tr>";
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>