<?php
	include_once "function.php";
	check_logged_in();
	if(isset($_POST['Upload'])){
		if(isset($_FILES['file'])){
			$ownerid = get_current_uid($_SESSION['username']);
			if(!file_exists('Media_Uploads/')){
				mkdir('Media_Uploads/', 0755);	
				chmod('Media_Uploads/', 0755);
			}
			$dirfile = 'Media_Uploads/'.$ownerid.'/';
			if(!file_exists('Media_Uploads/'.$ownerid.'/')){
				mkdir($dirfile, 0755);
				chmod($dirfile, 0755);
			}
			$mediatitle = $_POST['Media_Title'];
			$description = $_POST['Description'];
			$category = $_POST['Category'];
			$sharetype = $_POST['ShareType'];
			$downloadtype = $_POST['DownloadType'];
			$comment = $_POST['Comment'];
			$rate = $_POST['Rate'];
			$filename = $_FILES['file']['name'];
			$type = $_FILES['file']['type'];
			$size = $_FILES['file']['size'];
			$tmp = $_FILES['file']['tmp_name'];
			$path = $dirfile.urlencode($_FILES["file"]["name"]);
			if($mediatitle == "" || $description == "" || $category == "" || $sharetype == "" || $downloadtype == "" || $comment == "" || $rate == "") {
				$message = "Error! Media Format Not Supported!";
				header('Location: MediaUpload.php?error='.urlencode($message));
			}
			else {
				$extension = pathinfo($filename, PATHINFO_EXTENSION);
				$video_types = array('mp4', 'mpg', 'wma', 'mov', 'flv', 'avi', 'qt', 'wmv', 'mpeg', 'webm');
				$audio_types = array('mp3', 'ogg', 'wav');
				$image_types = array('jpeg', 'gif', 'png', 'jpg', 'pjeg', 'img');
				$allowed_types = array_merge($video_types, $audio_types, $image_types);
				if(!in_array($extension, $allowed_types)) {
					$message = "Error! Media Format Not Supported!";
					header('Location: MediaUpload.php?error='.urlencode($message));
				}
				else
				{
					$mediatype = "Unknown";
					if (in_array($extension, $video_types)) {
						$mediatype = 'Video';
					} else if (in_array($extension, $audio_types)) {
						$mediatype = 'Audio';
					} else if (in_array($extension, $image_types)) {
						$mediatype = 'Image';
					}
					$media_id = add_media($mediatitle, $description, $category, $extension, $mediatype, $sharetype, $downloadtype, $comment, $rate, $ownerid);
					$path = 'Media_Uploads/'.$ownerid.'/'.$media_id.'.'.$extension;
					move_uploaded_file($tmp, $path);
					chmod($path, 0755);
					$message = "Media Uploaded Successfully!";
					header('Location: MediaUpload.php?success='.urlencode($message));
				}
			}
		}
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Media Upload</title>
		<link rel="stylesheet" href="CSS/bootstrap.min.css">
			<script src="js/jquery-3.2.0.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<style>
				.logo {
					height: auto;
					width: 100px;
				}
				.main-title {
					font-size: 45px;
				}
				.sub-title {
					margin-top: 4%;
					padding-left: 35%;
					text-align: center;
				}
				.logout{
					margin-top: 20%;
				}
				.sub-title-button {
					margin-top: 3%;
				}
				.upload-button{
					text-align: center;
				}
			</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<img src="images/Logo.png" class="logo pull-right">
				</div>
				<div class="col-md-9">
					<h1 class="pull-left main-title">MeTube</h1>
				</div>
				<div class="col-md-1">
					<form class = "logout" name="Logout" method="post" action="LoginPage.php">
						<input class="btn btn-basic pull-right logout" type="submit" value="Logout" name="logout" />
					</form>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-9">
					<h1 class="sub-title">Media Upload</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackHome" method="get" action="Home.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Home"/>
					</form>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<?php if(isset($_GET['error'])){ ?>
							<div class="alert alert-danger fade-in">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong> <?= urldecode($_GET['error']) ?> </strong>
							</div>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<?php if(isset($_GET['success'])){ ?>
							<div class="alert alert-success fade-in">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong> <?= urldecode($_GET['success']) ?> </strong>
							</div>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 text-center">
					<form method="post" enctype="multipart/form-data" action = " ">
						<table class="table table-striped">
							<tbody>
								<tr>
									<td  class = 'grid-item'> Name </td>
									<td> <input class="form-control" type='text' name='Media_Title' required/> </td>
								</tr>
								<tr>
									<td  class = 'grid-item'> Media </td>
									<td><input name="file" type="file" required/></td>
								</tr>
								<tr>
									<td  class = 'grid-item'> Description </td>
									<td><textarea class="form-control" type="text" rows=3 name="Description" placeholder="Character Limit 400" required></textarea> </td>
								</tr>
								<tr>
									<td  class = 'grid-item'> Select Category </td>
									<td><select class = 'form-control Category' name='Category' required>
											<option value="Movie Trailer" name="Category"> Movie Trailer </option>
											<option value="TV Show" name="Category"> TV Show </option>
											<option value="Music" name="Category"> Music </option>
											<option value="Sports" name="Category"> Sports </option>
											<option value="Images And Gifs" name="Category"> Images and Gifs </option>
											<option value="Other" name="Category"> Others </option>
										</select>
									</td>
								</tr>	
								<tr>
									<td class='grid-item'> Share Type </td>
									<td><input type="radio" name="ShareType" value="0" required> Public
										<input type="radio" name="ShareType" value="1"> Private
									</td>
								</tr>
								<tr>
									<td class='grid-item'> Download Permission </td>
									<td> <input type="radio" name="DownloadType" value="0" required> Allow Download
										<input type="radio" name="DownloadType" value="1"> Disable Download
									</td>
								</tr>
								<tr>
									<td class='grid-item'> Commenting Permission </td>
									<td> <input type="radio" name="Comment" value="0" required> Allow Commenting
										<input type="radio" name="Comment" value="1"> Disable Commenting
									</td>
								</tr>
								<tr>
									<td class='grid-item'> Rating Permission </td>
									<td><input type="radio" name="Rate" value="0" required> Allow Rating
										<input type="radio" name="Rate" value="1"> Disable Rating
									</td>
								</tr>
							</tbody>
						</table>
						<button class="btn btn-primary upload-button" value="Upload" name="Upload" type="submit"> Upload </button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>