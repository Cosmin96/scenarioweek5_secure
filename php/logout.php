<?php

	session_start();
	require_once('valid.php');

	if(!isset($_SESSION['id']))
		echo "Wrong request";
	else if(!valid_input($_SESSION['id']))
		echo "Wrong request";
	else{
		session_destroy();
		echo 'OK';
	}
	header("Location: ../index.php");
?>