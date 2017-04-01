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
		<link rel="stylesheet" href="CSS/Groups.css">
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
		<h2> Groups </h2>
		<div>
			<form name="CreateGroup" method="post" action="">
				<input type="text" name="GroupTopic" placeholder="Enter the group's topic" />
				<input  type="submit" value="Create New Group" name = "CreateGroup"/>
			</form>
		</div>
		<div>
			<table class = "navigation-grid" align = "center">
				<tr>
					<th><i> Group Topic </i></th>
					<th><i> Date Created </i></th>
					<th><i> View </i></th>
				</tr>
				<?php
					$current_uid = get_current_uid($_SESSION['username']);
					$search_results = retrive_groups($current_uid);
					while($row = mysqli_fetch_assoc($search_results)) {
						echo "<tr>
							<td class = 'grid-item'>".$row['g_topic']."</td>
							<td class = 'grid-item'>".$row['g_date']."</td>
							<form action = 'GroupDiscussion.php' method = 'get'>
								<td>
									<input type='submit' name='ViewGroupDiscussion' value='View' />
									<input type='hidden' name='g_id' value='".$row['g_id']."' />
									<input type='hidden' name='g_topic' value='".$row['g_topic']."' />
									<input type='hidden' name='owner_u_id' value='".$row['owner_u_id']."' />
								</td>
							</form>
						</tr>";
					}
				?>
			</table>
		</div>
	</body>
</html>