<?php

	session_start();

	$username = $_POST['username'];
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
	else if($username == '')
		$ans ="Fill in the username before submitting!";
	else if(!valid_input($username)){
		$ans = "Invalid input!";
	}
	else if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
	else{
		$query="SELECT * from users where username='$username'";
		$result=$conn->query($query);
		
		if($result->num_rows > 0)
			$ans =  'Username is already taken. Try another one!';
		else{
			$query = "UPDATE users SET username='$username' WHERE id='$id'";
			$conn->query($query);

			if($_SESSION['id'] == $id)
				$_SESSION['username'] = $username;
			
			$ans = 'OK';
		}
	}

	echo $ans;
?>