<?php

	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];
	$csrf = $_POST['csrf'];

	require_once('database.php');
	require_once('valid.php');
	$conn = new mysqli($servername, $usn, $psw, $database);

	if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($username == '' || $password == ''){
		$ans = 'Complete all the required fields!';
	}else if(!valid_input($username) || !valid_input($password)){
		$ans = "Invalid input!";
	}
	else if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
	else{
		$query="SELECT * from users where username='$username'";
		$result=$conn->query($query);
		
		if($result->num_rows <= 0)
			$ans =  'Wrong details entered! Please, try again!';
		else{
			$row = $result->fetch_assoc();
			$id=$row['id'];
			$pic=$row['pic'];
			$role=$row['role'];

			if(password_verify($password, $row['password'])) {
				$_SESSION['logged_in'] = true;
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;
				$_SESSION['password'] = $password;
				$_SESSION['pic'] = $pic;
				$_SESSION['role'] = $role;
			
				$ans = "OK";
			}
			else{
				$ans = 'Wrong credentials!';
			}
		}
	}

	echo $ans;
?>