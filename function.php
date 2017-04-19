<?php

function check_logged_in() {
	session_start();
	if(!isset($_SESSION['username'])){ // logged in, get user info
        header("Location: index.php");
	}
}

function logout() {
	if(isset($_SESSION['username'])){
		unset($_SESSION['username']);
	}
	header('Location: index.php');
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
			header('Location: index.php');
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

function get_user_details($u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select uname, fname, lname from USER where u_id = '$u_id'";
	$result = mysqli_query($con,$query);
	$row = mysqli_fetch_array($result);
	return $row;
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

function send_personal_message($from_u_id, $to_u_id, $message){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into PERSONAL_MESSAGE (message,from_u_id,to_u_id) values ('$message','$from_u_id','$to_u_id')";
	$insert = mysqli_query($con,$query );
	if(!$insert){
		die ("Could not insert into the database: <br />". mysql_error());	
	}
	header('Location: SendMessage.php');
}

function retrive_personal_message($current_uid){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select msg_id,uname,message,msg_date from PERSONAL_MESSAGE, USER where to_u_id = ".$current_uid." and from_u_id = u_id order by msg_date desc";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	else {
		return $result;
	}
}

function delete_personal_message($msg_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "delete from PERSONAL_MESSAGE where msg_id = '$msg_id'";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not delete from database: <br />". mysql_error());
	}
	header('Location: Inbox.php');
}

function create_group($u_id,$group_topic){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into GROUPS (g_topic,owner_u_id) values ('$group_topic','$u_id')";
	$result = mysqli_query($con,$query);
	if(!$result){
		die ("Failed. Could not insert into the database: <br />". mysql_error());
	}
	$group_id = mysqli_insert_id($con);
	$query = "insert into GROUP_USERS (g_id, u_id) values ('$group_id','$u_id')";
	$result = mysqli_query($con,$query);
	if(!$result){
		die ("Failed. Could not insert into the database: <br />". mysql_error());
	}
	header('Location: Groups.php');
}

function add_user_to_group($g_id, $u_id, $owner_u_id, $g_topic) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into GROUP_USERS (g_id, u_id) values ('$g_id','$u_id') on duplicate key update u_id=$u_id";
	$result = mysqli_query($con,$query);
	if(!$result){
		die ("Failed. Could not insert into the database: <br />". mysql_error());
	}
	header('Location: GroupDiscussion.php?g_id='.$g_id.'&owner_u_id='.$owner_u_id.'&g_topic='.$g_topic.'');
}

function retrive_groups($u_id) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select A.g_id, owner_u_id, g_topic, g_date from GROUPS A, GROUP_USERS B where B.g_id = A.g_id and B.u_id = ".$u_id." order by g_date DESC";
	$result = mysqli_query($con,$query);
	if(!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	else {
		return $result;
	}
}

function send_group_message($g_id, $message, $owner_u_id, $u_id, $g_topic){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into GROUP_MESSAGE (message,g_id,u_id) values ('$message','$g_id','$u_id')";
	$insert = mysqli_query($con,$query );
	if(!$insert){
		die ("Could not insert into the database: <br />". mysql_error());	
	}
	header('Location: GroupDiscussion.php?g_id='.$g_id.'&owner_u_id='.$owner_u_id.'&g_topic='.$g_topic.'');
}

function retrieve_group_messages($g_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select uname, fname, lname, message, gmsg_date, gmsg_id, A.g_id, A.u_id, C.g_id, g_topic  
				from GROUP_MESSAGE A, USER B, GROUPS C
				where A.g_id = '$g_id' and C.g_id = '$g_id' and A.u_id = B.u_id order by gmsg_date";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	else {
		return $result;
	}
}

function delete_group_message($gmsg_id, $g_id, $owner_u_id, $g_topic){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "delete from GROUP_MESSAGE where gmsg_id = $gmsg_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not delete from database: <br />". mysql_error());
	}
	header('Location: GroupDiscussion.php?g_id='.$g_id.'&owner_u_id='.$owner_u_id.'&g_topic='.$g_topic.'');
}

function search_group_contact($current_uid, $type, $group_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select u_id, uname, fname, lname from USER, CONTACT
				where u_id1 = ".$current_uid." and u_id2 = u_id and type = '".$type."' and 
				u_id2 not in (select u_id from GROUP_USERS where g_id=".$group_id." and u_id!=".$current_uid.")";
	$result = mysqli_query($con,$query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function fetch_group_users($g_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select U.fname as fname, U.lname as lname, U.uname as uname from GROUP_USERS G, USER U where G.g_id=".$g_id." and U.u_id = G.u_id";
	$result = mysqli_query($con,$query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function add_media($mediatitle, $description, $category, $extension, $mediatype, $sharetype, $downloadtype, $comment, $rate, $ownerid){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query ="insert into MEDIA (m_title, description, category, extension, media_type, share_type, download_type, allow_commenting, allow_rating, view_count, owner_u_id)".
			"values ('$mediatitle', '$description', '$category', '$extension', '$mediatype', '$sharetype', '$downloadtype', '$comment', '$rate', 'NULL', '$ownerid')";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not insert into the database: <br />". mysql_error());
	}
	header('Location: MediaUpload.php');
	return mysqli_insert_id($con);
}

function fetch_media($id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from MEDIA where m_id = '$id'";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	$row = mysqli_fetch_array($result);
	return $row;
}

function retrive_my_uploads($owner_u_id, $mediatype){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from MEDIA where owner_u_id = '$owner_u_id' and media_type = '$mediatype' order by m_date DESC";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function edit_meta_data($m_id, $description, $share_type, $download_type, $rate, $comment){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$update = "update MEDIA set description='$description', share_type=$share_type, download_type=$download_type, allow_commenting=$comment,
				allow_rating=$rate where m_id=$m_id";
	$result = mysqli_query($con, $update);
	if (!$result){
		die ("Failed. Could not update the database: <br />". mysql_error());
	}
	header('Location: MyUploads.php');
}

function get_media_owner($mid) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select owner_u_id from MEDIA where m_id = '$mid'";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	$row = mysqli_fetch_array($result);
	return $row['owner_u_id'];
}

function is_media_private($mid){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select count(*) from MEDIA where m_id=$mid and share_type=1";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	$row = mysqli_fetch_array($result);
	return $row[0] > 0;
}

function user_has_access($mid, $current_uid){
	$media_owner_id = get_media_owner($mid);
	if ($media_owner_id == $current_uid) {
		return true;
	}
	else if (check_blocked_user($media_owner_id, $current_uid)) {
		return false;
	}
	else {
		return !is_media_private($mid);
	}
}

function add_media_favourites($m_id, $u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from FAVOURITES where m_id = $m_id and u_id = $u_id"; 
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	if(!$row) {
		$insert_query = "insert into FAVOURITES (m_id, u_id) values ($m_id, $u_id)";
		$insert_result = mysqli_query($con, $insert_query);
		if (!$insert_result){
			die ("Failed. Could not favourite <br />". mysql_error());
		}
	}
	else {
		$delete_query = "delete from FAVOURITES where m_id = $m_id and u_id = $u_id";
		$delete_result = mysqli_query($con, $delete_query);
		if (!$delete_result){
			die ("Failed. Could not unfavourite <br />". mysql_error());
		}
	}
	header('Location: MediaView.php?m_id='.$m_id);
}

function recent_uploads(){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from MEDIA where share_type = '0' order by m_date DESC";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	if (!$result1){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	
}

function get_playlists($u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select p_id, p_name from PLAYLIST where u_id = $u_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function add_to_new_playlist($m_id,$p_name,$u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into PLAYLIST (p_name, u_id) values ('$p_name', $u_id)";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	$p_id = mysqli_insert_id($con);
	add_to_existing_playlist($m_id, $p_id);
}

function add_to_existing_playlist($m_id, $p_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into PLAYLIST_MEDIA (m_id, p_id) values ($m_id, $p_id)";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
}

function get_playlist_media($p_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select A.m_id, m_title from PLAYLIST_MEDIA as A, MEDIA as B where p_id = $p_id and A.m_id = B.m_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function get_favourite_media($u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select A.m_id, m_title from FAVOURITES as A, MEDIA as B where A.u_id = $u_id and A.m_id = B.m_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function get_recent_uploads(){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from MEDIA where share_type = '0' order by m_date DESC";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function create_new_channel($current_uid, $c_name, $c_description){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into CHANNEL (c_name, c_description, owner_u_id) values ('$c_name', '$c_description', $current_uid)";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not insert into the database: <br />". mysql_error());
	}
	header('Location: MyChannels.php');
}

function get_my_channels($current_uid) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select c_id, c_name, c_description from CHANNEL where owner_u_id = $current_uid";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function get_unsubscribed_channels($current_uid) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select c_id, c_name, c_description from CHANNEL where owner_u_id != $current_uid and c_id not in 
				(select c_id from CHANNEL_SUBSCRIBERS where u_id = $current_uid)";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function get_subscribed_channels($current_uid) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select C.c_id, c_name, c_description from CHANNEL C, CHANNEL_SUBSCRIBERS CS where C.c_id = CS.c_id and CS.u_id = $current_uid";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function subscribe_to_channel($c_id, $current_uid){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into CHANNEL_SUBSCRIBERS (c_id, u_id) values ($c_id, $current_uid) on duplicate key update u_id=$current_uid";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	header('Location: SubscribedChannels.php');
}

function unsubscribe_from_channel($c_id, $current_uid) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "delete from CHANNEL_SUBSCRIBERS where c_id = $c_id and u_id = $current_uid";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	header('Location: SubscribedChannels.php');
}

function delete_playlist($p_id, $current_uid) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "delete from PLAYLIST where p_id = $p_id and u_id = $current_uid";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	header('Location: MyPlaylist.php');
}

function delete_playlist_media($p_id, $m_id) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "delete from PLAYLIST_MEDIA where p_id = $p_id and m_id = $m_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	header('Location: MyPlaylist.php');
}

function get_channel_media($c_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select A.m_id, m_title from CHANNEL_MEDIA as A, MEDIA as B where c_id = $c_id and A.m_id = B.m_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function add_to_channel($c_id, $m_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert ignore into CHANNEL_MEDIA (c_id, m_id) values ($c_id, $m_id)";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	header('Location: MyUploads.php');
}

function delete_media($m_id){
	$item = fetch_media($m_id);
	$owner_u_id = $item['owner_u_id'];
	$extension = $item['extension'];
	$file = 'Media_Uploads/'.$owner_u_id.'/'.$m_id.'.'.$extension;
	if (!unlink($file)) {
		die("Failed to delete");
	}
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "delete from MEDIA where m_id = $m_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	header('Location: MyUploads.php');
}

function increment_view_count($m_id) {
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "update MEDIA set view_count = view_count + 1 where m_id = $m_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function display_meta_data($mid){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from MEDIA, USER where m_id = $mid";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	$row = mysqli_fetch_array($result);
	return $row;
}

function retrieve_media_comment($mid){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select mc_id, mc_comment, mc_date, m_id, MEDIA_COMMENT.u_id, USER.uname as user from MEDIA_COMMENT, USER where m_id = $mid and MEDIA_COMMENT.u_id = USER.u_id order by mc_date ";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function post_media_comment($media_comment, $m_id, $u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into MEDIA_COMMENT (mc_comment, m_id, u_id) values ('$media_comment', '$m_id', '$u_id')";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not insert into the database: <br />". mysql_error());
	}
	header('Location: MediaView.php?m_id='.$m_id);
}

function delete_media_comment($mc_id, $m_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "delete from MEDIA_COMMENT where mc_id = $mc_id";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not delete from database: <br />". mysql_error());
	}
	header('Location: MediaView.php?m_id='.$m_id);
}

function get_media_by_categories($media_category){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from MEDIA where share_type = '0' and category = '$media_category'";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function most_viewed_media($u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select * from MEDIA where share_type = '0' order by view_count DESC";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function check_blocked_user($u_id1, $u_id2){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select count(*) from CONTACT where u_id1=$u_id1 and u_id2=$u_id2 and type='BLOCKED'";
	$result = mysqli_query($con, $query);
	
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	$row = mysqli_fetch_array($result);
	return $row[0] > 0;
}

function get_rating($mid, $current_uid){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "select rating from MEDIA_RATING where m_id = $mid and u_id = $current_uid";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	if(mysqli_num_rows($result) == 0){
		return 0;
	} 
	else {
		$row = mysqli_fetch_assoc($result);
		return $row['rating'];
	}
}

function rate_media($mid, $rating, $u_id){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$query = "insert into MEDIA_RATING (rating, m_id, u_id) values ($rating, $mid, $u_id) on duplicate key update rating=$rating";
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
}

function browseMedia($find,$feature){
	require "config.php";
	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$current_uid = get_current_uid($_SESSION['username']);
	
	$query = "Select * from SEARCH where keyword='$find' and u_id=$current_uid ";
	
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) > 0) {   
		$query = "update SEARCH set count = (count+1) where keyword='$find' and u_id=$current_uid";
		$result = mysqli_query($con, $query);
	} else {
		$query = "Insert into SEARCH (u_id, keyword, count) values($current_uid, '$find', 1)";
		$result = mysqli_query($con, $query);
	}
	
	if($feature == "title") {
		$query = "Select * from MEDIA where lower(m_title) LIKE lower('%".$find."%') AND share_type = 0";
	} else {
		$query = "Select * from MEDIA where lower($feature) LIKE lower('%".$find."%') AND share_type = 0";
	}
	$result = mysqli_query($con, $query);
	if (!$result){
		die ("Failed. Could not query the database: <br />". mysql_error());
	}
	return $result;
}

function recommendation(){
	require "config.php";
	$con = mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$current_uid = get_current_uid($_SESSION['username']);
	$query = "select keyword from SEARCH where u_id=$current_uid order by count desc LIMIT 20";
	$result = mysqli_query($con,$query);
	
	$keywords = [];
	while ($k = mysqli_fetch_assoc($result)){
		$query = "select m_id,m_title from MEDIA where m_title LIKE '%".$k['keyword']."%' or description LIKE '%".$k['keyword']."%' AND share_type = 0";
		$r = mysqli_query($con,$query);	
		while($media_row = mysqli_fetch_assoc($r)){
			$keywords[$media_row['m_id']][] = $media_row['m_title'];
		}
	}
	return array_slice($keywords, 0, 20);
}

function wordCloud(){
 	require "config.php";
	$con = mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	$current_uid = get_current_uid($_SESSION['username']);
	
	$query = "select keyword,count from SEARCH order by count desc";
	$result = mysqli_query($con,$query);
	
	$keywords = [];
	while ($k = mysqli_fetch_assoc($result)){
		$query = "select m_id,m_title from MEDIA where m_title LIKE '%".$k['keyword']."%' or description LIKE '%".$k['keyword']."%' AND share_type = 0 LIMIT 1";
		$r = mysqli_query($con,$query);	
		while($media_row = mysqli_fetch_assoc($r)){
			$keywords[$k['keyword']][] = $media_row['m_id'];
		}
	}
	return array_slice($keywords, 0, 20);
}
?>

