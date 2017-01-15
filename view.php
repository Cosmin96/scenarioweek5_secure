<?php

session_start();

	require_once('php/database.php');
	$conn = new mysqli($servername, $usn, $psw, $database);

	$id = $_GET['profile_id'];
	$query="SELECT * from users where id='$id'";
	$result=$conn->query($query);

	if($result->num_rows <= 0){
		header("Location: index.php");
		die();
	}

	$row = $result->fetch_assoc();
	$username = $row['username'];
	$pic = $row['pic'];

	$query="SELECT * from files where user_id='$id'";
	$result=$conn->query($query);

	$query="SELECT * from snippets where user_id='$id' AND private=0";
	$result1=$conn->query($query);

?>

<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php echo $username ?>'s profile</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
		<link rel="stylesheet" href="assets/css/style.css">

	</head>
	<body>

		<!-- Page Wrapper -->
	    <div id="page-wrapper">

	        <!-- Header -->
	        <header id="header" class="alt">
	            <h1 style="text-align: left; color:white; font-family:'Raleway';"><a href="home.php"><?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?></a></h1>
	            <nav>
	                <?php
						if(isset($_SESSION['logged_in']))
							if($_SESSION['logged_in']==true){
								echo '<a id="home" class="cd-signup" href="home.php">Home</a>';
							}
							else{
								echo '<a id="home" class="cd-signup" href="index.php">Snippy</a>';

							}
						else{
							echo '<a id="home" class="cd-signup" href="index.php">Snippy</a>';
						}
					?>
	            </nav>
	        </header>

			<!-- Menu -->
				<nav id="menu">
						<div class="inner">
							<h2 style="color:white;">Menu</h2>
							<ul class="links">
								<li><a href="index.php">Snippy</a></li>
								<li><a href="home.php">Home</a></li>
								<li><a href="settings.php">Settings</a></li>
							<?php
                        if($_SESSION['role']>=2)
                            echo '<li><a href="admin/index.php">Admin Dashboard</a></li>';
                    ?>
							</ul>
							<a href="#" class="close">Close</a>
						</div>
				</nav>

					<!-- Banner -->
			        <section id="banner">
			            <div class="inner">
			                <div style="text-align:left;"class="logo"><span style="color:white;"class="icon fa-pencil"></span></div>
			                <h2 style="text-align:left; padding-bottom:15px;"><?php echo $username ?></h2>
			                <?php echo '<a href="'.$pic.'"><img class="profile-image" style="width:25%;" src="'.$pic.'" alt="images/pic01.jpg" /></a>'; ?>
			            </div>
			        </section>

					<!-- Wrapper -->
			        <section id="wrapper">

			            <!-- One -->
			            <section id="one" class="wrapper spotlight style2">
			                <div class="inner">
			                    <div class="content">
			                        <h2 class="major" style="text-align: left">Files</h2>
			                        <section>
			                            <div class="table-wrapper">
			                                <table>
			                                    <thead>
			                                        <tr>
														<th style="padding:10px;">Name</th>
			                                            <th style="padding:10px;">Description</th>
			                                            <th style="padding:10px;">Link</th>
			                                        </tr>
			                                    </thead>
			                                    <tbody>
			               <?php
			                 while($row = $result->fetch_assoc())
			                 {
			                 	echo '<tr style="text-align: left; color:white;"><td style="text-align: left">'.$row['name'].'</td><td style="text-align: left">'.$row['description'].'</td><td><a target="_blank" href="'.$row['link'].'">View</a></td></tr>';
			                 }

			               ?>

			                                    </tbody>
			                                    <tfoot>
			                                        <tr>
			                                            <td colspan="2"></td>
			                                        </tr>
			                                    </tfoot>
			                                </table>
			                            </div>
			                        </section>

			                    </div>
			                </div>
			            </section>


							<!-- Four -->
				            <section id="four" class="wrapper alt style1">
				                <div class="inner">
				                    <h2 class="major">Snippets</h2>
				                    <p style="padding:15px; font-family:'Source Sans Pro';font-size: 20px;">A collection of the user's snippets.</p>
				                    <section class="features">


				     <?php
			          	while($row = $result1->fetch_assoc())
			          	{
			              	echo '<article><a href="'.$row['pic_link'].'" class="image"><img src="'.$row['pic_link'].'" alt="images/pic01.jpg" /></a><h3 style="font-family:Raleway;font-weight: bold; font-size:18px; color:white;text-align:left;" class="major">'.$row['title'].'</h3><p style="padding:15px; font-family:Source Sans Pro; color:white; text-align:left;">'.$row['full_text'].'</p></article>';
			          	}

			        ?>

				                    </section>

				                </div>
				            </section>

				        </section>

						<!-- Footer -->
						<section id="footer">
							<div class="inner">
								<ul class="copyright">
									<li>&copy; Snippy Inc. All rights reserved.</li>
									<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
								</ul>
							</div>
						</section>
						</div>


		<!-- Scripts -->

			<!-- Sign In Javascript -->
			<script src="assets/js/jquery-1.11.1.min.js"></script>
	        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	        <script src="assets/js/jquery.backstretch.min.js"></script>
	        <script src="assets/js/scripts.js"></script>

			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>
