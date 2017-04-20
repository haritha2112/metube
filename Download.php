<?php
include_once "function.php";
if(isset($_GET['Download'])){
	$mid = $_GET['m_id'];
	$item = fetch_media($mid);
	$owner_u_id = $item['owner_u_id'];
	$extension = $item['extension'];
	$file = $mid.addslashes('.').$extension;
	$file = 'Media_Uploads/'.$owner_u_id.'/'.$file;
	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	}
}
?>