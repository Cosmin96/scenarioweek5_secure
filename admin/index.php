<?php

    session_start();
    if($_SESSION['logged_in']==false || $_SESSION['role']<2){
        header("Location: ../index.php");
        die();
    }

	require_once('../php/database.php');
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
    <title>Snippy - Admin</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="../assets/css/main.css" />
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

    <!-- Sign up forms-->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/form-elements.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <!-- Page Wrapper -->
    <div id="page-wrapper">

        <!-- Header -->
        <header id="header" class="alt">

            <h1><a href="../index.php">Snippy!</a></h1>

            <nav>
                <h1><a style="color:white;" href="../home.php">Home</a></h1>
            </nav>
        </header>

        <!-- Menu -->
        <nav id="menu">
            <div class="inner">
                <h2 style="color:white;">Menu</h2>
                <ul class="links">
                    <li><a href="../index.php">Snippy</a></li>
                    <li><a href="../home.php">Home</a></li>
                    <li><a href="../settings.php">Settings</a></li>
                </ul>
                <a href="#" class="close">Close</a>
            </div>
        </nav>

        <!-- Wrapper -->
        <section id="wrapper">
            <header>
                <div class="inner">
                    <h2>Admin Dashboard</h2>
                    <p style="text-transform: none; color:white;">Administrate registered users, manage their attributes and permissions.</p>
                </div>
            </header>

            <!-- Content -->
            <div class="wrapper">
                <div class="inner">
                    <div class="content">
                        <h2 class="major" font-style="bold" ; style="text-align: left">Registered Users</h2>
                        <section>
                            <div class="table-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="padding-top:10px;">Username</th>
                                            <th style="padding-top:10px;"></th>
											<th style="padding-top:10px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
							 while($row = $result->fetch_assoc())
				   							 {
				   							 echo '<tr style="text-align: left; color:white;"><td style="text-align: left">'.$row['username'].'</td><td style="text-align: left"><a href="settings.php?user_id='.$row['id'].'">Manage User</a></td><td><a target="_blank" href="'.$domain.'/view.php?profile_id='.$row['id'].'">View Profile</a></td></tr>';
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
                    <li>&copy; Snippy Inc. All rights reserved.</li>
                    <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                </ul>
            </div>
        </section>

    </div>

    <!-- Scripts -->

    <!-- Sign In Javascript -->
    <script src="../assets/js/jquery-1.11.1.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.backstretch.min.js"></script>
    <script src="../assets/js/scripts.js"></script>

    <script src="../assets/js/skel.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
    <script src="../assets/js/main.js"></script>

</body>

</html>
