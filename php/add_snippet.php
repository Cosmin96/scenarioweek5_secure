<?php

	session_start();

	$title = $_POST['title'];
	$text = $_POST['text'];
	$pic_link = $_POST['pic_link'];
	$csrf = $_POST['csrf'];
	require_once('valid.php');


	$role = $_SESSION['role'];
	
	if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($role == 0)
		$ans = 'We are sorry, but you do not have editing privileges at the moment!';
	else if($title == '' || $text == ''){
		$ans = 'Details are missing! Please complete all the required fields!';
	}else if(!valid_input($title) || !valid_input($text) || !valid_input($pic_link)){
		$ans = "Invalid input!";
	}
	else{
		require_once('database.php');
		$conn = new mysqli($servername, $usn, $psw, $database);

		if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
		else{
			$id = $_SESSION['id'];
			if($pic_link == ''){
				$pic_no = rand(1, 8);
				$pic_link = $domain . '/images/pic0' . $pic_no . '.jpg';
			}

			$query="INSERT INTO snippets(title,full_text,pic_link,user_id) VALUES('$title','$text','$pic_link','$id')";
			$conn->query($query);

			date_default_timezone_set('GMT');
			
			$curr = date('Y-m-d H:i:s', time());
			$query="UPDATE users SET last_snippet='$curr' WHERE id='$id'";
			$conn->query($query);

			$ans = "OK";
		}
	}

	echo $ans;
?>