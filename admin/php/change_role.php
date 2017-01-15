<?php

	session_start();

	$role = $_POST['role'];
	$id = $_POST['id'];
	$csrf = $_POST['csrf'];

	require_once('database.php');
	require_once('valid.php');
	
	$conn = new mysqli($servername, $usn, $psw, $database);
	
	if($_SESSION['logged_in']==false || $_SESSION['role']<2){
        $ans = "Wrong request";
    }
	else if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($role < 0 && $role > 2)
		$ans ="Select a valid role before submitting!";
	else if(!valid_input($role) && !valid_input($id))
		$ans = "Invalid input";
	else if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
	else{
		
		$query = "UPDATE users SET role='$role' WHERE id='$id'";
		$conn->query($query);

		if($_SESSION['id'] == $id)
			$_SESSION['role'] = $role;
			
		$ans = 'OK';
	}

	echo $ans;
?>