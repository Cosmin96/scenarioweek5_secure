<?php
	session_start();

	require_once('php/database.php');
	$conn = new mysqli($servername, $usn, $psw, $database);

	$query="SELECT * from users";
	$result=$conn->query($query);
?>

<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Snippy - Welcome</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

		<!-- Sign up forms-->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/sweetalert.css">

	</head>
	<body>
		<?php 
			$csrf = md5(rand(0, 1000000));
			echo '<input type="hidden" value="'.$csrf.'" id="csrf">';
			$_SESSION['csrf'] = $csrf;
		?>

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
		        <header id="header" class="alt">

		            <h1><a href="index.php">Snippy!</a></h1>

		            <nav>
		            	<?php
						if(isset($_SESSION['logged_in']))
							if($_SESSION['logged_in']==true){
								echo '<a id="home" class="cd-signup" href="home.php">Home</a>';
							}
							else{
								echo '<a id="open-login" class="cd-signup" href="#" data-toggle="modal" data-target="#modal-login">Sign in</a>
						<a id="open-register" class="cd-signup" href="#" data-toggle="modal" data-target="#modal-register">Sign up</a>';
							}
						else{
							echo '<a id="open-login" class="cd-signup" href="#" data-toggle="modal" data-target="#modal-login">Sign in</a>
						<a id="open-register" class="cd-signup" href="#" data-toggle="modal" data-target="#modal-register">Sign up</a>';
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
							</ul>
							<a href="#" class="close">Close</a>
						</div>
					</nav>

				<!-- Wrapper -->
					<section id="wrapper">
						<header>
							<div class="inner">
								<h2>Snippy</h2>
								<p style="text-transform: none; color:white;">Create and delete snippets, and store your favourite files, easily.</p>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">					<div class="content">
			                        <h2 class="major" font-style="bold"; style="text-align: left">Registered Users</h2>
			                        <section>
			                            <div class="table-wrapper">
			                                <table>
			                                    <thead>
			                                        <tr>
			                                            <th style="padding-top:10px;">User Name</th>
			                                            <th style="padding-top:10px;">Last Snippet Created</th>
			                                            <th style="padding-top:10px;">User's Snippets</th>
			                                        </tr>
			                                    </thead>
			                                    <tbody>
			                                       <?php
			                 while($row = $result->fetch_assoc())
			                 {
			                 	echo '<tr style="text-align: left; color:white;"><td style="text-align: left">'.$row['username'].'</td><td style="text-align: left">'.$row['last_snippet'].'</td><td><a target="_blank" href="'.$domain.'/view.php?profile_id='.$row['id'].'">View</a></td></tr>';
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
							</div>

					</section>

				<!-- Footer -->
					<section id="footer">
						<div class="inner">
							<ul class="copyright">
								<li>&copy; Snippy Inc. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
							</ul>
						</div>
					</section>

			</div>

			<!-- Sign In MODAL -->
	        <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
	        	<div class="modal-dialog">
	        		<div class="modal-content">

	        			<div class="modal-header">
	        				<a data-dismiss="modal" class="boxclose" id="boxclose1"></a>
	        				<h3 class="modal-title" id="modal-register-label">Sign In</h3>
	        				<p>Enter credentials</p>
	        			</div>

	        			<div class="modal-body">

		                    <form class="registration-form">
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-email">Username</label>
		                        	<input type="text" name="username" placeholder="Username..." class="form-email form-control req" id="form-username">
		                        </div>
								<div class="form-group">
		                        	<label class="sr-only" for="form-email">Password</label>
		                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control req" id="form-password">
		                        </div>
		                        <button onclick="login();" type="button" class="btn">Sign me in!</button>
		                    </form>

	        			</div>

	        		</div>
	        	</div>
	        </div>

			<!-- Sign Up MODAL -->
	        <div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
	        	<div class="modal-dialog">
	        		<div class="modal-content">

	        			<div class="modal-header">
	        				<a data-dismiss="modal" class="boxclose" id="boxclose2"></a>
	        				<h3 class="modal-title" id="modal-register-label">Sign up now</h3>
	        				<p>Fill in the form below to get instant access:</p>
	        			</div>

	        			<div class="modal-body">

		                    <form class="registration-form">

		                        <div class="form-group">
		                        	<label class="sr-only" for="form-email">Username</label>
		                        	<input type="text" name="username" placeholder="Username..." class="form-email form-control req" id="form-username1">
		                        </div>
								<div class="form-group">
		                        	<label class="sr-only" for="form-email">Password</label>
		                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control req" id="form-password1">
		                        </div>
		                        <button type="button" onclick="register();" class="btn">Sign me up!</button>
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
				function register(){
    			var username = document.getElementById('form-username1').value;
    			var csrf = document.getElementById('csrf').value;
    			var password = document.getElementById('form-password1').value;
    		$.ajax({
                type: 'POST',
                url: 'php/register.php',
                data: {username : username, password : password, csrf : csrf},
                success: function(data){
                    if(data!="OK")
                    {
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                        document.getElementById('form-password1').value = '';
                    }
                    else
                    {
                        window.location.href="home.php";
                   	}
                }
            });
    	}



    	function login(){
    			var username = document.getElementById('form-username').value;
    			var password = document.getElementById('form-password').value;
    			var csrf = document.getElementById('csrf').value;
    		$.ajax({
                type: 'POST',
                url: 'php/login.php',
                data: {username : username, password : password, csrf : csrf},
                success: function(data){
                    if(data!="OK")
                    {
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                        document.getElementById('form-password').value = '';
                    }
                    else
                    {
                        window.location.href="home.php";
                   	}
                }
            });
    	}
			</script>

	</body>
</html>
