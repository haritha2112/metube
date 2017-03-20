<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<html>
	<head>
		<title> MeTube Home Page</title>
		<link rel="stylesheet" href="CSS/Home.css">
	</head>
	<body>
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "Logout" name="Logout" method="post" action="">
			<input type="submit" value="Logout" name = "logout"/>
		</form>
		<hr>
		<br>
			<form class = "Profile" name="Profile" action="Profile.php"  method = "post">
				<input type="submit" value="My Profile" name = "Submit"/>
			</form>
		<table class="navigation-grid">
			<tr>
				<td class="grid-item"><a href="RecentUploads.php">Whats new</a></td>
				<td class="grid-item"><a href="Browse.php">Browse by Category</a></td>
				<td class="grid-item"><a href="MostViewed.php">Most Viewed</a></td>
			</tr>
			<tr>
				<td class="grid-item"><a href="Playlist.php">My Playlists</a></td>
				<td class="grid-item"><a href="Upload.php">Upload</a></td>
				<td class="grid-item"><a href="Channel.php">My Channels</a></td>
			</tr>
		</table>
	</body>
</html>