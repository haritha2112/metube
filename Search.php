<?php
	include_once "function.php";
	check_logged_in();
	
	if(isset($_POST['logout'])) {
		logout();
	}
?>
<html>
	<head>
		<title> Search </title>
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
			.list-group{
				margin-top: 1%;
			}
			.list-group-item{
				text-align: center;
			}
			.shift-down {
				margin-top: 3%;
			}
			.search-results-list {
				padding-left: 0px;
			}
			.wordcloud{
				margin-top: 1%;
				border-style: ridge;
			}
		</style>
		<script src="js/jqcloud-1.0.4.min"></script>
		<link rel="stylesheet" href="CSS/jqcloud.css">
		<?php
			$keywords = wordCloud();
			//echo json_encode($keywords);
			$cnt = count($keywords);
			$cnt2 = $cnt - 1 ;
			
		?>
		<script type="text/javascript">
			var words =[];
			<?php foreach($keywords as $word => $m_id) { ?>
				var m_id = '<?php echo json_encode($m_id[0]); ?>'.replace(new RegExp('"', 'g'), '');
				words.push({text: "<?= $word ?>", 
							weight: Math.random() * 100, 
							link: "MediaView.php?m_id=" + m_id});
			<?php } ?>
			$(document).ready(function() {
				$('#wordcloud').jQCloud(words);
			});
		</script>
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
					<form class = "logout" name="Logout" method="post" action="">
						<input class="btn btn-basic pull-right logout" type="submit" value="Logout" name="logout" />
					</form>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-9">
					<h1 class="sub-title">Search</h1>
				</div>
				<div class="col-md-3 sub-title-button">
					<form name="BackHome" method="get" action="Home.php">
						<input class="btn btn-primary pull-right" type="submit" value="Back" name = "Home"/>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 ">
					<div id="wordcloud" class="jqcloud wordcloud text-center" style="height:150px;width:auto"></div>
				</div>
			</div>
			<div class="row shift-down text-center">
				<div class="col-md-6 recommendations-div">
						<div class="row">
							<div class="col-md-11 jumbotron text-center">
								<h3> Media Recommendations </h3>
								<ul class="list-group">
								<?php
									$recommendations = recommendation();
									if (sizeof($recommendations) == 0) { ?>
										<li>No suitable recommendations found!</li>
									<?php }
									else {
										foreach ($recommendations as $media_id => $media_title) { ?>
											<a href="MediaView.php?m_id=<?= $media_id ?>">
												<?php 
													$current_title = json_encode($media_title[0]);
													$length = strlen($current_title); 
												?>
												<li class="list-group-item"><?= substr($current_title, 1,  $length - 2) ?>
												</li>
											</a>
										<?php }
									}
								?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6 search-div">
						<div class="row">
							<div class="col-md-offset-1 col-md-11 jumbotron text-center">
								<h3> Search Media </h3>
								<form class="form-inline" action="" method="get">
									<select class="form-control" name="Feature">
										<option value="title" selected>Media Title</option>
										<option value="description">Description</option>
										<option value="extension">Extension</option>
										<option value="media_type">Media Type</option>
									</select>
									<input name="SearchText" id="search-key" type="text" class="form-control" placeholder="Enter here..." />
									<input name="Search" class="btn btn-info" type="submit" value="Go">
								</form>
								<ul class="search-results-list">
									<?php
									if(isset($_GET["Search"])) {
										$search_text = trim($_GET['SearchText']);
										$feature = trim($_GET['Feature']);
										$found = false;
										if ($search_text != "") {
											$keywords = explode(" ",$search_text);
											foreach($keywords as $keyword) {
												$getSearchMedia = browseMedia($keyword, $feature);
												if(mysqli_num_rows($getSearchMedia) > 0) {	
													$found = true;
													while($media_row = mysqli_fetch_assoc($getSearchMedia)) { ?>
														<a href="MediaView.php?m_id=<?= $media_row['m_id'] ?>">
															<li class="list-group-item"><?= $media_row['m_title'] ?></li>
														</a>
													<?php 
													}
												}
											}										
										}	
										if(!$found) { ?> 
											<li>No matching results found!</li> 
										<?php 
										}
									} ?>
								<ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>