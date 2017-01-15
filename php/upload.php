<?php

	session_start();

	require_once('valid.php');

	$name = $_POST['name'];
	$description = $_POST['description'];
	$csrf = $_POST['csrf'];

	if($csrf != $_SESSION['csrf']){
		$ans = 'Wrong request';
	}
	else if($name == '' || $_FILES['file']['name'] == ''){
		$ans = 'Details are missing! Please complete all the required fields!';
	}else if(!valid_input($name) || !valid_input($description)){
		$ans = "Invalid input!";
	}
	else{
		require_once('database.php');
		$conn = new mysqli($servername, $usn, $psw, $database);

		if($conn->connect_errno)$ans =  'There was a problem with connecting to our server. Please, try again!';
		else{
			$id = $_SESSION['id'];
			$target = '../'.$id;
			mkdir($target);
			$target .= '/'.$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $target);

			$link = $domain .'/'. $id .'/'. $_FILES['file']['name'];

			$query="INSERT INTO files(name,description,link,user_id) VALUES('$name','$description','$link','$id')";
			$conn->query($query);

			$ans = "OK";
		}
	}

	echo $ans;
?>