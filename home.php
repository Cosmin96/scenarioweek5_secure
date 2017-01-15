<?php

session_start();
	if($_SESSION['logged_in']==false){
		header("Location: index.php");
		die();
	}

	require_once('php/database.php');
	$conn = new mysqli($servername, $usn, $psw, $database);

	$id = $_SESSION['id'];
	$query="SELECT * from files where user_id='$id'";
	$result=$conn->query($query);

	$query="SELECT * from snippets where user_id='$id'";
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
		<title>Home</title>
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
		<link rel="stylesheet" href="assets/css/sweetalert.css">

	</head>
	<body>

		<!-- Page Wrapper -->
	    <div id="page-wrapper">

	        <!-- Header -->
	        <header id="header" class="alt">
	            <h1 style="text-align: left; color:white; font-family:'Raleway';"><a href="home.php"><?php echo $_SESSION['username'] ?></a></h1>
	            <nav>
	                <a class="cd-signin" href="php/logout.php">Sign Out</a>
	                <a href="#menu">Menu</a>
	            </nav>
	        </header>

				<!-- Menu -->
					<nav id="menu">
                        <div class="inner">
                            <h2 style="font-family:'Raleway'; font-weight:bold;font-size:24px;color:white;">Menu</h2>
                            <ul style="padding-top:15px; padding-bottom:0px;"class="links">
                                <li><a style="font-weight:bold;" href="index.php">Snippy</a></li>
                                <li><a style="font-weight:bold;" href="home.php">Home</a></li>
                                <li><a style="font-weight:bold;" href="settings.php">Settings</a></li>
                            <?php
                        if($_SESSION['role']>=2)
                            echo '<li><a style="font-weight:bold;" href="admin/index.php">Admin Dashboard</a></li>';
                    ?>
                            </ul>
                            <a href="#" class="close">Close</a>
                        </div>
            		</nav>

					<!-- Banner -->
			        <section id="banner">
			            <div class="inner">
			                <div style="text-align:left;"class="logo"><span style="color:white;"class="icon fa-pencil"></span></div>
			                <h2 style="text-align:left; padding-bottom:15px;">Welcome back, <?php echo $_SESSION['username'] ?></h2>
			                <?php echo '<a href="'.$_SESSION['pic'].'"><img class="profile-image" style="width:25%;" src="'.$_SESSION['pic'].'" alt="images/pic01.jpg" /></a>'; ?>
			                <p style="color:white; font-family:'Raleway'; font-weight:bold;">My Homepage</a>
			                </p>
			            </div>
			        </section>

					<!-- Wrapper -->
			        <section id="wrapper">

			            <!-- One -->
			            <section id="one" class="wrapper spotlight style2">
			                <div class="inner">
			                    <div class="content">
			                        <h2 class="major" style="text-align: left">My Files</h2>
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
						   <!--<td class="icon fa-trash-o"> Remove</td>-->

			                                    </tbody>
			                                    <tfoot>
			                                        <tr>
			                                            <td colspan="2"></td>
			                                        </tr>
			                                    </tfoot>
			                                </table>
			                            </div>
			                        </section>
			                        <ul class="actions">
			                            <li><a class="button icon fa-upload" href="#" data-toggle="modal" data-target="#modal-addfile">Add File</a></li>
			                        </ul>
			                    </div>
			                </div>
			            </section>


							<!-- Four -->
				            <section id="four" class="wrapper alt style1">
				                <div class="inner">

				                    <h2 class="major">My Snippets</h2>
				                    <p style="padding:15px; font-family:'Source Sans Pro';font-size: 20px;">Create and delete your snippets on the go.</p>
									<ul style="padding:15px;"class="actions">
										<li><a class="button icon fa-upload" href="#" data-toggle="modal" data-target="#modal-addsnippet">Create Snippet</a></li>
				                    </ul>

				                    <section class="features">

				    <?php
			          	while($row = $result1->fetch_assoc())
			          	{
			              	echo '<article id="snippet'.$row['id'].'"><a href="'.$row['pic_link'].'" class="image"><img src="'.$row['pic_link'].'" alt="images/pic01.jpg" /></a><h3 style="font-family:Raleway;font-weight: bold; font-size:18px; color:white;text-align:left;" class="major">'.$row['title'].'</h3><p style="padding:10px; font-family:Source Sans Pro; color:white; text-align:left;">'.$row['full_text'].'</p><div style="padding:20px;"><a href="settings.php#edit_snippet" class="button">Edit</a></div></article>';
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



			<div class="modal fade" id="modal-addfile" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
	        	<div class="modal-dialog">
	        		<div class="modal-content">

	        			<div class="modal-header">
	        				<a data-dismiss="modal" class="boxclose" id="boxclose1"></a>
	        				<h3 class="modal-title" id="modal-register-label">Submit file</h3>
	        				<p>Enter the details of the new file</p>
	        			</div>

	        			<div class="modal-body">

		                    <form id="fileForm" class="registration-form" enctype="multipart/form-data">
		                        <?php 
			$csrf = md5(rand(0, 1000000));
			echo '<input name="csrf" type="hidden" value="'.$csrf.'" id="csrf">';
			$_SESSION['csrf'] = $csrf;
		?>
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-name">Name</label>
		                        	<input type="text" name="name" placeholder="Name..." class="form-first-name form-control req" id="form-name">
		                        </div>
								<div class="form-group">
		                        	<label class="sr-only" for="form-description">Description</label>
		                        	<input type="text" name="description" placeholder="Description..." class="form-first-name form-control req" id="form-description">
		                        </div>
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-file">File</label>
		                        	<input type="file" name="file" placeholder="Description..." class="form-first-name form-control req" id="form-file" style="background-color:#333333; border:none;">
		                        </div>
		                        <button type="button" onclick="addFile();" class="btn">Add item</button>
		                    </form>

	        			</div>

	        		</div>
	        	</div>
	        </div>

<div class="modal fade" id="modal-addsnippet" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
	        	<div class="modal-dialog">
	        		<div class="modal-content">

	        			<div class="modal-header">
	        				<a data-dismiss="modal" class="boxclose" id="boxclose1"></a>
	        				<h3 class="modal-title" id="modal-register-label">Submit snippet</h3>
	        				<p>Enter the details of the new snippet</p>
	        			</div>

	        			<div class="modal-body">

		                    <form class="registration-form" enctype="multipart/form-data">
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-name">Title</label>
		                        	<input type="text" name="title" placeholder="Title..." class="form-first-name form-control req" id="form-title">
		                        </div>
								<div class="form-group">
		                        	<label class="sr-only" for="form-description">Full text</label>
		                        	<textarea name="text" placeholder="Full text..." class="form-first-name form-control req" id="form-text"></textarea>
		                        </div>
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-file">Snippet Image</label>
		                        	<input type="text" name="pic_link" placeholder="Enter image URL..." class="form-first-name form-control" id="form-pic" style="background-color:#333333; border:none;">
		                        </div>
		                        <button type="button" onclick="addSnippet();" class="btn">Add snippet</button>
		                    </form>

	        			</div>

	        		</div>
	        	</div>
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
			<script src="assets/js/sweetalert.min.js"></script>
			<script type="text/javascript">

			function addSnippet(){
    			var title = document.getElementById('form-title').value;
    			var text = document.getElementById('form-text').value;
    			var pic_link = document.getElementById('form-pic').value;
    			var csrf = document.getElementById('csrf').value;
    		$.ajax({
                type: 'POST',
                url: 'php/add_snippet.php',
                data: {csrf : csrf, title : title, text : text, pic_link : pic_link},
                success: function(data){
                    if(data!="OK")
                    {
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    else
                    {
                        window.location.reload();
                   	}
                }
            });
    	}

    	function addFile(){
    			var formdata = new FormData(document.getElementById('fileForm'));
    		$.ajax({
                type: 'POST',
                url: 'php/upload.php',
                data: formdata,
	        	processData: false,  // tell jQuery not to process the data
  				contentType: false,   // tell jQuery not to set contentType
  				cache:false,
                success: function(data){
                    if(data!="OK")
                    {
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    else
                    {
                        window.location.reload();
                   	}
                }
            });
    	}

			</script>

	</body>
</html>
