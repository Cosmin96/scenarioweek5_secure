<?php

	session_start();

	$old = $_POST['old_psswd'];
	$new = $_POST['new_psswd'];
	$id = $_SESSION['id'];
	$csrf = $_POST['csrf'];

	function verify_strength($pass){
		$upp = 0; $low = 0; $no = 0;
		for($i = 0; $i < strlen($pass); $i++){
			if($pass[$i] >= 'A' && $pass[$i] <= 'Z')
				$upp = 1;
			if($pass[$i] >= 'a' && $pass[$i] <= 'z')
				$low = 1;
			if($pass[$i] >= '0' && $pass[$i] <= '9')
				$no = 1;
		}
		if($upp == 1 && $low == 1  && $no == 1)
			return true;
		return false;
	}

	require_once('database.php');
	require_once('valid.php');
	$conn = new mysqli($servername, $usn, $psw, $database);

	if($_SESSION['logged_in']==false || $_SESSION['role']<2){
        $ans = "Wrong request";
    }
	else if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($old == '' || $new == '')
		$ans='Please, complete all the required information before submitting!';
	else if(!valid_input($old) || !valid_input($new)){
		$ans = "Invalid input";
	}else if(!(strlen($new) >= 6)){
		$ans = "Passwords should be at least 6 characters long";
	}else if(!verify_strength($new)){
		$ans = "Passwords should contain at least: 1 uppercase letter, 1 lowercase letter, 1 digit";
	}
	else if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
	else{
		$query="SELECT * from users where id='$id'";
		$result=$conn->query($query);
		$row=$result->fetch_assoc();
		if($row['password'] != $old)
			$ans = "Invalid old password inserted!";
		else{
			$query = "UPDATE users SET password='$new' WHERE id='$id'";
			$conn->query($query);

			//$_SESSION['password'] = $password;
			
			$ans = "OK";
		}
	}

	echo $ans;
?>