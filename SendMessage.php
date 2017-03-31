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
?>
<html>
	<head>
		<title> Send Message </title>
		<link rel="stylesheet" href="CSS/SendMessage.css">
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "BackHome" name="BackHome" method="post" action="Home.php">
			<input type="submit" value="Home" name = "Submit"/>
		</form>
		<hr>
		<form class = "BackMessage" name="BackMessage" method="post" action="Message.php">
			<input  type="submit" value="Back" name = "Submit"/>
		</form>
		<h2> Send Message </h2>
		<form method="post" action="">
			<label> Choose	</label>
			<select name='SearchOption'>
				<option value = "CONTACT" name = "SearchOption"> My Contacts </option>
				<option value = "FRIEND" name = "SearchOption"> My Friends </option>
				<option value = "FAMILY" name = "SearchOption"> My Family </option>
			</select>
			<input  type="submit" value="Go" name = "Search"/>
		</form>
		<table class = "navigation-grid" align = "center">
		<tr>
			<th><i>Username</i></th>
			<th><i>Firstname</i></th>
			<th><i>Lastname</i></th>
			<th><i>Send Message</i></th>
		</tr>
		<?php
			if(isset($_POST['Search'])){
				$current_uid = get_current_uid($_SESSION['username']);
				$search_results = retrive_contact($current_uid, $_POST['SearchOption']);
				while($row = mysqli_fetch_assoc($search_results)) {
					echo "<tr>
						<td class = 'grid-item'>".$row['uname']."</td>
						<td class = 'grid-item'>".$row['fname']."</td>
						<td class = 'grid-item'>".$row['lname']."</td>
						<form action = '' method = 'post'>
							<td class = 'grid-item'>
								<select name = 'Type'>";
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
								echo "</select>
							</td>
						<td>
							<input type='submit' name='SendMessage' value='Send' />
							<input type='hidden' name='u_id' value='".$row['u_id']."' />
						</td>
						</form>
					</tr>";
				}
			}
		?>
		</table>
		</body>
</html>