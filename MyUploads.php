<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
?>
<html>
	<head>
		<title> My Uploads </title>
		<link rel="stylesheet" href="CSS/MyUploads.css">
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
		<h2> My Uploads </h2>
		<p align="left">
			<?php
				if(isset($_GET['id']))
				{
					$id = $_GET['id'];
					$search_results = display_my_uploads($id);
					while($row = mysqli_fetch_assoc($search_results))
					{
						$owner_u_id = $row['owner_u_id'];
						$mediatitle = $row['m_title'];
						$mediatype = $row['media_type'];
						$url = 'Media_Uploads/'.$owner_u_id.'/'.$mediatitle;
				
							echo "Viewing Picture:";
							echo "<img src='".$url."'/ width='560' height='315'>";
							echo "<video src='".$url."' width='560' height='315' frame='2' controls></video>";
						
					}
					
				}
				else
				{
					echo "List";
					echo "<br>";
					$owner_u_id = get_current_uid($_SESSION['username']);
					$search_results = retrive_my_uploads($owner_u_id);
					while($row = mysqli_fetch_assoc($search_results))
					{
						$id = $row['m_id'];
						$mediatype = $row['media_type'];
						$mediatitle = $row['m_title'];
							echo "<a href='MyUploads.php?id=".$id."> Video </a>";
	
							echo "<a href='MyUploads.php?id=".$id."> Image </a>";
						
						
					}
				}
			?>
		</p>
	</body>
</html>