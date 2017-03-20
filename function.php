<?php

function check_logged_in() {
	session_start();
	if(!isset($_SESSION['username'])){ // logged in, get user info
        header("Location: LoginPage.php");
	}
}

function logout() {
	if(isset($_SESSION['username'])){
		unset($_SESSION['username']);
	}
	header('Location: LoginPage.php');
}

function user_exist_check ($fname,$lname,$uname,$pwd,$gender){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from USER where uname='$uname'";
	$result = mysqli_query( $con,$query );
	if (!$result){
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}
	else {
		$row = mysqli_fetch_assoc($result);
		if($row == 0){
			$query = "insert into USER (fname,lname,uname,pwd,gender) values ('$fname','$lname', '$uname','$pwd','$gender')";
			$insert = mysqli_query($con,$query );
			if($insert)
				return 1;
			else
				die ("Could not insert into the database: <br />". mysql_error());		
		}
		else{
			return 2;
		}
	}
}


function user_pass_check($username, $password)
{
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select uname,pwd from USER where uname='$username' and pwd = '$password'";
	$result = mysqli_query($con,$query );		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		$row = mysqli_fetch_row($result);
			if($row[0]==$username && $row[1]==$password){
				return 0;
			}
		
		else {
			return 2;
		}
	}	
}

function user_profile_display($uname){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select fname,lname,uname,pwd,gender from USER where uname='$uname'";
	$result = mysqli_query($con,$query);
	if (!$result){
		die("Falied. Could not query the database: <br />". mysql_error());
	}
	$row = mysqli_fetch_array($result);
	return $row;
}

function user_profile_update($fname,$lname,$uname,$pwd,$gender){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select fname,lname,uname,pwd,gender from USER where uname='$uname'";
	$result = mysqli_query( $con,$query );
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	else {
		$row = mysqli_fetch_assoc($result);
		if($row['uname'] == $uname){
			$query = "update USER set fname = '$fname', lname = '$lname', pwd = '$pwd', gender = '$gender' where uname = '$uname'";
			$update = mysqli_query($con,$query );
			if($update)
				return 1;
			else
				die ("Could not update the database: <br />". mysql_error());		
		}
		else{
			return 2;
		}
	}
}

function delete_profile($username){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from USER where uname = '$username'";
	$result = mysqli_query($con,$query);
	if (!$result){
		die ("Sorry could not delete your profile!: <br />". mysql_error());
	}
	else{
		$row = mysqli_fetch_assoc($result);
		$query = "delete from USER where u_id = ".$row['u_id'];
		$update = mysqli_query($con,$query);
		if($update)
			header('Location: LoginPage.php');
		else
			die ("Sorry could not delete your profile!: <br />". mysql_error());
	}
}

function search_contact($field, $uname){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$current_uid = get_current_uid($uname);
	$query = "select u_id,fname,lname,uname from USER where uname not like '$uname' 
			and (fname like '%$field%' or lname like '%$field%' or uname like '%$field%')
			and u_id not in (select u_id2 from CONTACT where u_id1=".$current_uid.")";
	$result = mysqli_query($con,$query);
	return $result;
}

function get_current_uid($username){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select u_id from USER where uname = '$username'";
	$result = mysqli_query($con,$query);
	$row = mysqli_fetch_array($result);
	return $row[0];
}

function add_contact($u_id1, $u_id2,$contact){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into CONTACT values ('$u_id1','$u_id2','$contact')";
	$insert = mysqli_query($con,$query );
	if(!$insert){
		die ("Could not insert into the database: <br />". mysql_error());	
	}
	header('Location: AddContacts.php');
}

function retrive_contact($current_uid, $type){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select u_id, uname, fname, lname, type from USER, CONTACT where u_id1 = ".$current_uid." and u_id2 = u_id and type = '".$type."'";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	else {
		return $result;
	}
}

function update_contact_type($current_id, $u_id, $type){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "update CONTACT set type = '".$type."' where u_id1 = ".$current_id." and u_id2 = ".$u_id."";
	$update = mysqli_query($con, $query);
	if (!$update){
	   die ("Could not update the contact type! <br />". mysql_error());
	}
	header('Location: MyPeople.php');
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
	}
}

function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "File has already been uploaded";
	case 6:
		return  "Failed to move file from temporary directory";
	case 7:
		return  "Upload file failed";
	}
}

function other()
{
	//You can write your own functions here.
}
	
?>
