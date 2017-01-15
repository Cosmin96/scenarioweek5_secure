<?php

	session_start();

	$id = $_POST['id'];
	$csrf = $_POST['csrf'];

	if($_SESSION['logged_in']==false || $_SESSION['role']<3){
        $ans = "Wrong request";
    }
	else if($_SESSION['logged_in']==false){
		$ans = "Bad request";
	}
	else if($_SESSION['role'] != 3){
		$ans = "Bad request";
	} else{

	require_once('database.php');
	require_once('valid.php');

	$conn = new mysqli($servername, $usn, $psw, $database);

	if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if(!valid_input($id))
		$ans = "Invalid request";
	else if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
	else{
		$query="DELETE FROM users WHERE id='$id'";
		$conn->query($query);

		$ans = "OK";
	}
}

	echo $ans;
?>