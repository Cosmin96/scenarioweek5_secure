<?php

	session_start();

	require_once('valid.php');

	$sid = $_POST['snippet_id'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$pic_link = $_POST['pic_link'];
	$priv = $_POST['priv'];
	$csrf = $_POST['csrf'];
	
	$role = $_SESSION['role'];
	
	if($_SESSION['logged_in']==false || $_SESSION['role']<2){
        $ans = "Wrong request";
    }
	else if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($role == 0)
		$ans = 'We are sorry, but you do not have editing privileges at the moment!';
	else if($title == '' || $text == ''){
		$ans = 'Details are missing! Please complete all the required fields!';
	}else if(!valid_input($title) || !valid_input($text) || !valid_input($pic_link) || !valid_input($priv) || !valid_input($sid)){
		$ans = "Invalid input!";
	}
	else{
		require_once('database.php');
		$conn = new mysqli($servername, $usn, $psw, $database);

		if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
		else{
			$id = $_POST['id'];
			if($pic_link == ''){
				$pic_no = rand(1, 8);
				$pic_link = $domain . '/images/pic0' . $pic_no . '.jpg';
			}

			$query="UPDATE snippets SET private='$priv',title='$title',full_text='$text',pic_link='$pic_link' WHERE id='$sid'";
			$conn->query($query);

			date_default_timezone_set('GMT');

			$curr = date('Y-m-d H:i:s', time());
			$query="UPDATE users SET last_snippet='$curr' WHERE id='$id'";
			$conn->query($query);

			$ans = 'OK';
		}
	}

	echo $ans;
?>