<?php
	include_once "function.php";
	check_logged_in();
	if(isset($_POST['Upload'])){
		if(isset($_FILES['file'])){
			$ownerid = get_current_uid($_SESSION['username']);
			if(!file_exists('Media_Uploads/')){
				mkdir('Media_Uploads/', 0755);	
			}
			$dirfile = 'Media_Uploads/'.$ownerid.'/';
			if(!file_exists('Media_Uploads/'.$ownerid.'/')){
				mkdir($dirfile, 0755);	
			}
			$mediatitle = $_POST['Media_Title'];
			$description = $_POST['Description'];
			$category = $_POST['Category'];
			$mediatype = $_POST['MediaType'];
			$sharetype = $_POST['ShareType'];
			$downloadtype = $_POST['DownloadType'];
			$comment = $_POST['Comment'];
			$rate = $_POST['Rate'];
			$filename = $_FILES['file']['name'];
			$type = $_FILES['file']['type'];
			$size = $_FILES['file']['size'];
			$tmp = $_FILES['file']['tmp_name'];
			$path = $dirfile.urlencode($_FILES["file"]["name"]);
			if($mediatitle == "" || $description == "" || $category == "" || $mediatype == "" || $sharetype == "" || $downloadtype == "" || $comment == "" || $rate == "") {
				$media_upload_error = "One or more fields are missing.";
			}
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$allowed_types = array('mp4', 'mpg', 'wma', 'mov', 'flv', 'avi', 'qt', 'wmv', 'wmv', 'mp3', 'mpeg', 'jpeg', 'gif', 'png', 'jpg', 'pjeg', 'img');
			if(!in_array($extension, $allowed_types)) {
				$message= "Media Format Not Supported!";
			}
			else
			{
				$media_id = add_media($mediatitle, $description, $category, $extension, $mediatype, $sharetype, $downloadtype, $comment, $rate, $ownerid);
				$path = 'Media_Uploads/'.$ownerid.'/'.$media_id.'.'.$extension;
				move_uploaded_file($tmp, $path);
				$message="Media Uploaded Successfully!";
				echo $message;
			}
			echo "<script type='text/javascript'>alert('$message);</script>";
			echo 'Filename : '.$filename;
			echo 'Extension : '.$extension;
		}
	}
?>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Media Upload</title>
	<link rel="stylesheet" href="CSS/MediaUpload.css">
</head>
<body align = "center">
	<h1 align = "center"> <b> MeTube </b> </h1>
	<form class = "Logout" name="Logout" method="post" action="index.php">
		<input type="submit" value="Logout" name="logout" />
	</form>
	<hr>
	<form class = "BackHome" name="BackHome" method="post" action="Home.php">
		<input  type="submit" value="Home" name = "Home"/>
	</form>
	<h2> Media Upload </h2>
	<form method="post" enctype="multipart/form-data" action = " ">
		<table class = "navigation-grid" align = "center">
			<tr>
				<td  class = 'grid-item'> Name: <input type='text' name='Media_Title' /> </td>
			</tr>
			<tr>
				<td  class = 'grid-item'>
					Media:  <input  name="file" type="file" />
				</td>
				
			</tr>
			<tr>
				<td  class = 'grid-item'> Description <input type="text" name="Description" placeholder="Character Limit 400" /> </td>
			</tr>
			<tr>
				<td  class = 'grid-item'>
				Select Media Type<select class = 'MediaType' name='MediaType'>
					<option value="Video" name="MediaType"> Video </option>
					<option value="Audio" name="MediaType"> Audio </option>
					<option value="Image" name="MediaType"> Image </option>
				</select>
				</td>
			</tr>
			<tr>
				<td  class = 'grid-item'>
				Select Category <select class = 'Category' name='Category'>
					<option value="Movie Trailer" name="Category"> Movie Trailer </option>
					<option value="Albums" name="Category"> Albums </option>
					<option value="Random Clips" name="Category"> Random Clips </option>
					<option value="Images" name="Category"> Image </option>
					<option value="Random Audio" name="Category"> Random Audio </option>
					<option value="Songs" name="Category"> Songs </option>
					<option value="TV Show CLips" name="Category"> TV Show Clips</option>
				</select>
				</td>
			</tr>	
			<tr>
				<td class='grid-item'>
				Share Type	<input type="radio" name="ShareType" value="0"> Public
							<input type="radio" name="ShareType" value="1"> Private
				</td>
			</tr>
			<tr>
				<td class='grid-item'>
				Download Permission <input type="radio" name="DownloadType" value="0"> Allow Download
									<input type="radio" name="DownloadType" value="1"> Disable Download
				</td>
			</tr>
			<tr>
				<td class='grid-item'>
				Commenting Permission <input type="radio" name="Comment" value="0"> Allow Commenting
									<input type="radio" name="Comment" value="1"> Disable Commenting
				</td>
			</tr>
			<tr>
				<td class='grid-item'>
				Rating Permission <input type="radio" name="Rate" value="0"> Allow Rating
									<input type="radio" name="Rate" value="1"> Disable Rating
				</td>
			</tr>
			<tr>
				<td  class = 'grid-item'><input value="Upload" name="Upload" type="submit" /> </td>
			</tr>
		</table>          
	</form>
	<?php
		if(isset($_POST['Upload'])){
			echo "Video Uploaded";
		}
		
	?>
</body>
</html>