<?php

	session_start();

	$link = $_POST['link'];
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
	else if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
	else if(!valid_input($link)){
		$ans = "Invalid input!";
	}
	else{
		if($link == ''){
			$pic_no = rand(1, 8);
			$link = $domain . '/images/pic0' . $pic_no . '.jpg';
		}
		
		$query = "UPDATE users SET pic='$link' WHERE id='$id'";
		$conn->query($query);

		if($_SESSION['id'] == $id)
			$_SESSION['pic'] = $link;
			
		$ans = "OK";
	}

	echo $ans;
?>