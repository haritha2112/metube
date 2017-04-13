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
	
	if(isset($_POST['SendGroupMessage'])){
		$g_id = $_POST['g_id'];
		$message = $_POST['message'];
		$g_topic = $_POST['g_topic'];
		$current_id = get_current_uid($_SESSION['username']);
		$owner_u_id = $_POST['owner_u_id'];
		send_group_message($g_id, $message, $owner_u_id, $current_id, $g_topic);
	}

?>
<html>
	<head>
		<title> Group Discussion </title>
		<link rel="stylesheet" href="CSS/GroupDiscussion.css">
		<meta http-equiv="pragma" content="no-cache" />
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "BackHome" name="BackHome" method="post" action="Home.php">
			<input type="submit" value="Home" name = "Submit"/>
		</form>
		<hr>
		<form class = "BackGroup" name="BackGroup" method="post" action="Groups.php">
			<input  type="submit" value="Back" name = "Submit"/>
		</form>
		<?php
			$current_uid = get_current_uid($_SESSION['username']);
			if($current_uid == $_GET['owner_u_id']) {
				echo "<form method='get' action=''>
						<label> Choose	</label>
						<select name='SearchOption'>
							<option value = 'CONTACT' name = 'SearchOption'> My Contacts </option>
							<option value = 'FRIEND' name = 'SearchOption'> My Friends </option>
							<option value = 'FAMILY' name = 'SearchOption'> My Family </option>
						</select>
						<input  type='submit' value='Go' name = 'Search'/>
						<input type='hidden' name='g_id' value='".$_GET['g_id']."' />
						<input type='hidden' name='owner_u_id' value='".$_GET['owner_u_id']."' />
						<input type='hidden' name='g_topic' value='".$_GET['g_topic']."' />
					</form>
					";
					if(isset($_GET['Search'])){
						$search_results = retrive_contact($current_uid, $_GET['SearchOption']);
						while($row = mysqli_fetch_assoc($search_results)) {
							echo "<table class = 'navigation-grid' align = 'center'>
								<tr>
									<th><i>Username</i></th>
									<th><i>Firstname</i></th>
									<th><i>Lastname</i></th>
									<th><i>Action</i></th>
								</tr>
								<tr>
								<td class = 'grid-item'>".$row['uname']."</td>
								<td class = 'grid-item'>".$row['fname']."</td>
								<td class = 'grid-item'>".$row['lname']."</td>
								<td>
									<form action = '' method = 'post'>
										<input type='submit' name='AddToGroup' value='Add To Group' />
										<input type='hidden' name='u_id' value='".$row['u_id']."' />
										<input type='hidden' name='g_id' value='".$_GET['g_id']."' />
										<input type='hidden' name='g_topic' value='".$_GET['g_topic']."' />
										<input type='hidden' name='owner_u_id' value='".$_GET['owner_u_id']."' />
									</form>
								</td>
							</tr>
							</table>";
						}
					}
			}
			echo "<hr/>";
			echo "<h3>".$_GET['g_topic']."</h3>";
			$result = retrieve_group_messages($_GET['g_id']);
			while($row = mysqli_fetch_assoc($result)){
				echo "<div>
				<p>".$row['uname']."   |   ".$row['fname']." ".$row['lname']."</p>
				<p>".$row['message']."</p>
				<p>".substr($row['gmsg_date'], 0, 10)."</p>
				</div>";
			}
			
			echo" <form method='post' action=''>
					<input type='text' name='message' placeholder='Enter your message here' />
					<input type='submit' name='SendGroupMessage' value='Send' />
					<input type='hidden' name='g_id' value='".$_GET['g_id']."' />
					<input type='hidden' name='g_topic' value='".$_GET['g_topic']."' />
					<input type='hidden' name='owner_u_id' value='".$_GET['owner_u_id']."' />
				</form>
				";
		?>
	</body>
</html>