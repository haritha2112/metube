<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(isset($_POST['AddContact'])){
		$uname = $_SESSION['username'] ;
		$id = $_POST['u_id'];
		echo $id;
		$current_uid = get_current_uid($uname);
		echo $current_uid;
		add_contact($current_uid, $id, "CONTACT");
	}
?>
<html>
	<head>
		<title> AddContacts </title>
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
			.search-bar {
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
					<h1 class="sub-title">Add New Contacts</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackProfile" method="get" action="Profile.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Profile"/>
					</form>
				</div>
			</div>
			<div class="row search-bar">
				<div class="col-md-12 text-center">
					<form class="form-inline" name="SearchContact" method="get" action="">
						<div class="form-group">
							<label for="search-box"> Search	</label>
							<input class="form-control" type = "text" name = "contactsearch" id = "search-box" />
						</div>						
						<input class="btn btn-basic" type="submit" value="Go" name = "Search"/>
						<p><i> Search for username or Full name </i></p>
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
								<th><i>Add Contact</i></th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Search'])){
									$search_results = search_contact($_GET['contactsearch'],$_SESSION['username']);
									while($row = mysqli_fetch_assoc($search_results)) { ?>
										<tr>
											<td><?= $row['uname'] ?></td>
											<td><?= $row['fname'] ?></td>
											<td><?= $row['lname'] ?></td>
											<td>
												<form action = '' method = 'post'>
													<input class="btn btn-info" type='submit' value='Add' name='AddContact'/>
													<input type='hidden' value='<?= $row['u_id'] ?>' name='u_id'>
												</form>
											</td>
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