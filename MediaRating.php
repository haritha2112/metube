<?php
	include_once "function.php";
	if(isset($_POST['MediaRating'])){
		$values = explode("|", $_POST['values']);
		$mid = $values[0];
		$rating = $values[2];
		$u_id = $values[1];
		rate_media($mid, $rating, $u_id);
	}
?>