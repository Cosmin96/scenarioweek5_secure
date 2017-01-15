<?php

	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];
	$csrf = $_POST['csrf'];

	require_once('valid.php');

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
	if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($username == '' || $password == ''){
		$ans = 'Details are missing! Please complete all the required fields!';
	}else if(!valid_input($username) || !valid_input($password)){
		$ans = "Invalid input!";
	}
	else if(strlen($username) < 2){
		$ans = 'Username is too short!';
	}else if(!(strlen($password) >= 6)){
		$ans = "Passwords should be at least 6 characters long";
	}else if(!verify_strength($password)){
		$ans = "Passwords should contain at least: 1 uppercase letter, 1 lowercase letter, 1 digit";
	}
	else{
		require_once('database.php');
		$conn = new mysqli($servername, $usn, $psw, $database);

		if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
		else{

			$query="SELECT * from users where username='$username'";
			$result=$conn->query($query);

			if($result->num_rows > 0)
				$ans = "Username is already registered";
			else{
				$password = password_hash($password, PASSWORD_BCRYPT);
				
				$pic_no = rand(1, 8);
				$pic = $domain . '/images/pic0' . $pic_no . '.jpg';

				$query="INSERT INTO users(username,password,pic) VALUES('$username','$password','$pic')";
				$conn->query($query);

				$query="SELECT * from users where username='$username' AND password='$password'";
				$result=$conn->query($query);
				$row = $result->fetch_assoc();
				$id=$row['id'];
				$role=$row['role'];

				$_SESSION['logged_in'] = true;
				$_SESSION['id'] = $id;
				
				$_SESSION['username'] = $username;
				$_SESSION['pic'] = $pic;
				$_SESSION['role'] = $role;

				$ans = "OK";
			}
		}
	}

	echo $ans;

?>