<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<html>
	<head>
		<title> Contacts </title>
		<link rel="stylesheet" href="CSS/Contacts.css">
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
		<h2> My Contacts </h2>
		<form class = "SearchContact" name="SearchContact" method="post" action="">
			<label> Search	</label><input type = "text" name = "contactsearch" class = "search_box" /> 
			<input  type="submit" value="Go" name = "Search"/>
			<p><i> Search for username or Full name </i></p>
		</form>
		<table class = "navigation-grid" align = "center">
		<tr>
			<th><i>Username</i></th>
			<th><i>Firstname</i></th>
			<th><i>Lastname</i></th>
			<th><i>Add Contact</i></th>
		</tr>
		<?php
			if(isset($_POST['Search'])){
				$search_results = search_contact($_POST['contactsearch'],$_SESSION['username']);
				while($row = mysqli_fetch_assoc($search_results)) {
					echo "<tr>
						<td class = 'grid-item'>".$row['uname']."</td>
						<td class = 'grid-item'>".$row['fname']."</td>
						<td class = 'grid-item'>".$row['lname']."</td>
						<td class = 'grid-item'>
							<form action = '' method = 'post'>
								<input type='submit' value='Add' name='AddContact'/>
								<input type='hidden' >
							</form>
						</td>
					</tr>";
				}
			}
		?>
		</table>
	</body>
</html>