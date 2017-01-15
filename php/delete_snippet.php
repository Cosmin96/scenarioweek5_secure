<?php

	session_start();

	$sid = $_POST['snippet_id'];
	$csrf = $_POST['csrf'];

	require_once('database.php');
	require_once('valid.php');
	$conn = new mysqli($servername, $usn, $psw, $database);

	if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
	else if(!valid_input($sid)){
		$ans = "Invalid request!";
	}
	else{
		$id = $_SESSION['id'];
		$query="DELETE FROM snippets WHERE id='$sid' AND user_id='$id'";
		$conn->query($query);

		$ans = "OK";
	}

	echo $ans;
?>