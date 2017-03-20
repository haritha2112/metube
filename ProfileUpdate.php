	<?php
		include_once "function.php";
		
		check_logged_in();
	
		if(isset($_SESSION['username'])) { 
			$uname = $_SESSION['username'] ;
			echo $uname;
			$row = user_profile_display($uname);
		}
		
		if(isset($_POST['Delete'])) { 
			$uname = $_SESSION['username'] ;
			$delete = delete_profile($uname);
		}
		
		if(isset($_POST['Save'])) { 
			$uname = $_SESSION['username'] ;
			if($_POST['cfname'] == "" || $_POST['clname'] == "" || $_POST['cpwd'] == "" || $_POST['cgender'] == "") {
				$profile_update_error = "One or more fields are missing.";
			}
			elseif( strlen($_POST['cpwd']) < 4 ||  strlen($_POST['cpwd']) > 10 ) {
				$profile_update_error = "Passwords should have 4 to 9 characters. Try again?";
			}
			else {
				$check = user_profile_update($_POST['cfname'],$_POST['clname'],$_SESSION['username'],$_POST['cpwd'],$_POST['cgender']);	
				if($check == 1){
					header('Location: ProfileUpdate.php');
				}
			}
		}
	?>
	<html>
	<head>
		<title> Profile Update</title>
		<link rel="stylesheet" href="CSS/ProfileUpdate.css">
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
		<h2> Update Profile </h2>
		<form  action=""  method="post" onsubmit="return confirm('Are you sure you want to proceed?')">
		<table class = "navigation-grid" align = "center">
			<tr> 
				<td class = "grid-item"> Username </td>
				<td class = "grid-item">
					<label name= "uname"><?php echo $row[2] ?></label>
				</td>
				<td class = "grid-item"><i> You cannot change your username </i></td>
			</tr>
			<tr> 
				<td class = "grid-item"> Firstname </td>
				<td class = "grid-item">
					<label name= "fname"><?php echo $row[0] ?></label>
				</td>
				<td class = "grid-item">
					<input type = "text" name = "cfname" class = "box" value="<?php echo $row[0] ?>">
				</td>
			</tr>
			<tr> 
				<td class = "grid-item"> Lastname </td>
				<td class = "grid-item">
					<label name= "lname"><?php echo $row[1] ?></label>
				</td>
				<td class = "grid-item">
					<input type = "text" name = "clname" class = "box" value="<?php echo $row[1] ?>">
				</td>
			</tr>
			<tr> 
				<td class = "grid-item"> Password </td>
				<td class = "grid-item">
					<label name= "pwd"><?php echo $row[3] ?></label>
				</td>
				<td class = "grid-item">
					<input type = "text" name = "cpwd" class = "box" value="<?php echo $row[3] ?>">
				</td>
			</tr>
			<tr> 
				<td class = "grid-item"> Gender </td>
				<td class = "grid-item">
					<label name= "gender"><?php echo $row[4] ?></label>
				</td>
				<td class = "grid-item">
					<?php
						if($row[4] == "F") {
							echo "<input type='radio' name='cgender' value='M'> Male
								  <input type='radio' name='cgender' value='F' checked> Female";
						}
						else {
							echo "<input type='radio' name='cgender' value='M' checked> Male
								  <input type='radio' name='cgender' value='F'> Female";
						}
					?>
				</td>
			</tr>
			<tr>
				<td> </td>
				<td>
					<input  type="submit" value="Delete Account" name = "Delete"/>
				</td>
				<td>
					
					<input  type="submit" value="Save Details" name = "Save"/>
					
				</td>
			</tr>
			<tr>
				<?php
					if(isset($profile_update_error))
					{  echo "<div id='profile_update_error'>".$profile_update_error."</div>";}
				?>
			</tr
		</table>
		</form>
		<br>
		<br>
		<br>
		
	</body>
</html>