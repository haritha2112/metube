<html>
	<head>
		<title> Upload </title>
		<link rel="stylesheet" href="CSS/Upload.css">
		<link rel="stylesheet" href="CSS/font-awesome-4.7.0/css/font-awesome.min.css">
		<meta http-equiv="pragma" content="no-cache" />
	</head>
	<body align = "center">
		<h1 align = "center"> <b> MeTube </b> </h1>
		<form class = "Logout" name="Logout" method="post" action="index.php">
			<input type="submit" value="Logout" />
		</form>
		<hr>
		<form class = "BackHome" name="BackHome" method="post" action="Home.php">
			<input type="submit" value="Home" />
		</form>
		<h2> Upload </h2>
		<div id='uploadWindow'>
			<form method="post" enctype="multipart/form-data" action="Upload.php">
				
				Select Video : 
				<input type='file' name='video'  placeholder='Upload video..'>
					<button type='submit'>
  						<i class="fa fa-upload" aria-hidden="true">Upload</i>
					</button>
					<?php
					
					if(isset($_FILES['video'])) {
					$name = $_FILES['video']['name'];
					$type = explode('.', $name);
					$type = end($type);
					$size = $_FILES['video']['size'];
					$random_name = rand();
					$tmp = $_FILES['video']['tmp_name'];
					
						/*if ($type != 'mp4' && $type != 'MP4' && $type != 'flv') {
						$message = "Video format is not supported";
						} else {*/
						move_uploaded_file($tmp,'videos/'.random_name.'.'.$type);
						$message = "Successfully Uploaded";
					
						/*}*/
					echo "$message <br/>";
					}
				?>
			</form>
		</div>
	</body>
</html>