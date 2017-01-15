<?php
	require_once('php/database.php');
	$conn = new mysqli($servername, $usn, $psw, $database);

	session_start();
	if($_SESSION['logged_in']==false){
		header("Location: index.php");
		die();
	}

	$id = $_SESSION['id'];
	$query="SELECT * from snippets where user_id='$id'";
	$result1=$conn->query($query);
?>

<script type="text/javascript">
	var description = [];
	description
</script>

<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
    <title>My Settings</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/form-elements.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/sweetalert.css">

</head>

<body>
    <?php 
            $csrf = md5(rand(0, 1000000));
            echo '<input type="hidden" value="'.$csrf.'" id="csrf">';
            $_SESSION['csrf'] = $csrf;
        ?>

    <!-- Page Wrapper -->
    <div id="page-wrapper">

        <!-- Header -->
        <header id="header">
            <h1 style="text-align:left;"><a style="font-family:'Raleway';font-weight:bold;color:white;" href="home.php"><?php echo $_SESSION['username'] ?></a></h1>
            <nav>
            	<a class="cd-signin" href="php/logout.php">Sign Out</a>
                <a href="#menu">Menu</a>
            </nav>
        </header>

		<!-- Menu -->
			<nav id="menu">
				<div class="inner">
					<h2 style="font-family:'Raleway'; font-weight:bold;font-size:24px;color:white;">Menu</h2>
					<ul style="padding-top:15px; padding-bottom:0px;"class="links">
						<li><a style="font-weight:bold;" href="index.php">Snippy</a></li>
						<li><a style="font-weight:bold;" href="home.php">Home</a></li>
						<li><a style="font-weight:bold;" href="settings.php">Settings</a></li>
					<?php
				if($_SESSION['role']>=2)
					echo '<li><a style="font-weight:bold;" href="admin/index.php">Admin Dashboard</a></li>';
			?>
					</ul>
					<a href="#" class="close">Close</a>
				</div>
			</nav>

        <!-- Wrapper -->
        <section id="wrapper">
            <header>
                <div class="inner">
                    <h2>Settings</h2>
                    <p style="text-transform: none; color:white;">Add a profile picture, edit your snippets, change your username or password or pick a profile colour.</p>
                </div>
            </header>

            <!-- Content -->
            <div class="wrapper">
                <div class="inner">

					<h3 style="font-family:Raleway;font-weight:bold;color:white;text-align:left;font-size:16px;"class="major">Edit your profile picture</h3>
					<div style="text-align: center;">
					<br>
					<?php echo '<a href="'.$_SESSION['pic'].'"><img class="profile-image" style="width:25%;" src="'.$_SESSION['pic'].'" alt="images/pic01.jpg" /></a>'; ?>
					<br>
					<br>
					<ul class="actions">

					<li><a href="#" data-toggle="modal" data-target="#modal-photo" class="button special icon fa-camera"> Change picture</a></li>
					</ul>
					<br>
					</div>

					<h3 style="font-family:Raleway;font-weight:bold;color:white;text-align:left;font-size:16px;"id="edit_snippet"class="major">Edit your snippets</h3>

					<section>
						<div class="table-wrapper">
							<table>
								<thead>
									<tr>
										<th style="padding:10px; text-align:left;">Snippet Title</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>


			<?php
			    while($row = $result1->fetch_assoc())
			    {
			    	echo '<input type="hidden" value="'.$row['full_text'].'" id="full'.$row['id'].'"';
			        echo '<tr style="text-align: left; color:white;">
										<td style="text-align: left; color:white;">'.$row['title'].'</td>
										<td style="text-align: left; color:white; cursor: pointer;" onclick="go_to_snippet('.$row['id'].')">View</td>
										<td style="padding:5px;"><div class="6u 12u$(small)">
										</td>
										<td style="cursor: pointer; color:white;" class="icon fa-pencil-square-o" onclick="editSnippet('.$row['id'].','."'".$row['title']."'".','.$row['private'].','."'".$row['pic_link']."'".')" data-toggle="modal" data-target="#modal-editsnippet"> Edit</td>
										<td id="delete'.$row['id'].'" style="cursor: pointer; color:white;" class="icon fa-trash-o" onclick="deleteSnippet('.$row['id'].')"> Remove</td>
									</tr>';
			    }
			?>


								</tbody>
								<tfoot>
									<tr>
										<td colspan="2"></td>
									</tr>
								</tfoot>
							</table>

						</div>
					</section>

					<br>

					<section>

                    <h3 style="font-family:Raleway;font-weight:bold;color:white;text-align:left;font-size:16px;"class="major">Change your username</h3>
						<form>
							<div class="row uniform">
								<div style="text-align:left;font-size:14px;" class="6u 12u$(xsmall)">
									<label for="demo-name" style="padding:20px;" >New Username</label>
									<input type="text" name="username" placeholder="Enter a valid username..." id="new-username" value="" />
								</div>
								<div class="12u$">
									<ul style="text-align:left; "class="actions">
										<li><input type="button" onclick="usernameAjax();" value="Change username" class="special req" /></li>
									</ul>
								</div>
							</div>
						</form>

						<br>

					<h3  style="font-family:Raleway;font-weight:bold;color:white;text-align:left;font-size:16px;"class="major">Change your password</h3>
						<form>
							<div class="row uniform">
								<div  style="text-align:left;font-size:14px;" class="6u 12u$(xsmall)">
									<label for="old-psswd" style="padding:20px;">Enter old password</label>
									<input class="req" type="password" name="old-psswd" placeholder="Enter a valid password..." id="old-psswd" value="" />
								</div>
							</div>

							<div class="row uniform">
								<div style="text-align:left;font-size:14px;" class="6u 12u$(xsmall)">
									<label for="demo-psswd" style="padding:20px;">Enter new password</label>
									<input class="req" type="password" name="new-psswd" placeholder="Enter a valid password..." id="new-psswd" value="" />
								</div>
								<div class="12u$">
									<ul style="text-align:left;" class="actions">
										<li><input type="button" onclick="passwordAjax();" value="Change password" class="special req" /></li>
									</ul>
								</div>
							</div>
						</form>
					</p>
					</section>


                </div>
            </div>

        </section>

        <!-- Footer -->
        <section id="footer">
            <div class="inner">
                <ul class="copyright">
                    <li>&copy; Snippy Inc. All rights reserved.</li>

                    <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                </ul>
            </div>
        </section>

    	<div class="modal fade" id="modal-photo" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
	        	<div class="modal-dialog">
	        		<div class="modal-content">

	        			<div class="modal-header">
	        				<a data-dismiss="modal" class="boxclose" id="boxclose1"></a>
	        				<h3 class="modal-title" id="modal-register-label">Add a photo</h3>
	        				<p>Add a link for your photo</p>
	        			</div>

	        			<div class="modal-body">

		                    <form class="registration-form" enctype="multipart/form-data">
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-name">Link</label>
		                        	<input type="text" name="link" placeholder="Link..." class="form-first-name form-control" id="form-link">
		                        </div>
		                        <button type="button" onclick="picAjax();" class="btn">Add photo</button>
		                    </form>

	        			</div>

	        		</div>
	        	</div>
	        </div>


    </div>



<div class="modal fade" id="modal-editsnippet" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
	        	<div class="modal-dialog">
	        		<div class="modal-content">

	        			<div class="modal-header">
	        				<a data-dismiss="modal" class="boxclose" id="boxclose1"></a>
	        				<h3 class="modal-title" id="modal-register-label">Edit snippet</h3>
	        				<p>Make changes to the snippet</p>
	        			</div>

	        			<div class="modal-body">

		                    <form class="registration-form" enctype="multipart/form-data">
		                        <input id="form-sid" type="hidden" value="" name="snippet_id">
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-name">Edit Title</label>
		                        	<input type="text" name="title" placeholder="Enter title..." class="form-first-name form-control req" id="form-title">
		                        </div>
								<div class="form-group">
		                        	<label class="sr-only" for="form-description">Edit text</label>
		                        	<textarea name="text" placeholder="Enter text..." class="form-first-name form-control req" id="form-text"></textarea>
		                        </div>
		                        <div class="form-group">
		                        	<label class="sr-only" for="form-file">Snippet Image</label>
		                        	<input type="text" name="pic_link" placeholder="Enter image URL..." class="form-first-name form-control" id="form-pic" style="background-color:#333333; border:none;">
		                        </div>

		                        <div class="form-group">
									<input type="checkbox" id="form-private" name="private">
									<label for="demo-copy" id="labelchk" >Private</label>
								</div>
								<button onclick="editAJAX()" type="button" class="btn">Save changes</button>

		                    </form>

	        			</div>

	        		</div>
	        	</div>
	        </div>



    <!-- Scripts -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.backstretch.min.js"></script>
	<script src="assets/js/scripts.js"></script>

    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/util.js"></script>
    <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>

    <script type="text/javascript">
    	$('#labelchk').click(function(){
    		if($('#form-private').is(":checked")){
    			$('#form-private').prop('checked', false);
    		} else{
    			$('#form-private').prop('checked', true);
    		}
    	});

    	function editAJAX(){
    		var title = document.getElementById('form-title').value;
    		var text = document.getElementById('form-text').value;
    		var pic_link = document.getElementById('form-pic').value;
    		var snippet_id = document.getElementById('form-sid').value;
    		var priv = 0;
            var csrf = document.getElementById('csrf').value;


    		if($('#form-private').is(":checked")){
    			priv = 1;
    		}
    		$.ajax({
                type: 'POST',
                url: 'php/change_snippet.php',
                data: {csrf : csrf, snippet_id : snippet_id, title : title, pic_link : pic_link, text : text, priv : priv},
                success: function(data){
                    if(data!="OK")
                    {
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    else
                    {
                        window.location.reload();
                   	}
                }
            });
    	}

    	function picAjax(){
    		var link = document.getElementById('form-link').value;
    		var csrf = document.getElementById('csrf').value;
            $.ajax({
                type: 'POST',
                url: 'php/change_photo.php',
                data: {csrf : csrf, link : link},
                success: function(data){
                    if(data!="OK")
                    {
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    else
                    {
                        window.location.reload();
                   	}
                }
            });
    	}

    	function passwordAjax(){
            var csrf = document.getElementById('csrf').value;
    		var old_psswd = document.getElementById('old-psswd').value;
    		var new_psswd = document.getElementById('new-psswd').value;
    		$.ajax({
                type: 'POST',
                url: 'php/change_password.php',
                data: {csrf : csrf, old_psswd : old_psswd, new_psswd : new_psswd},
                success: function(data){
                    if(data!="OK")
                    {
                        document.getElementById('old-psswd').value = '';
                        document.getElementById('new-psswd').value = '';
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    else
                    {
                        document.getElementById('old-psswd').value = '';
                        document.getElementById('new-psswd').value = '';
                        swal({
                            title: "Success!",
                            text: 'Password successfully changed!',
                            type: "success",
                            confirmButtonText: "Ok"
                        });
                   	}
                }
            });
    	}

    	function usernameAjax(){
    		var username = document.getElementById('new-username').value;
    		var csrf = document.getElementById('csrf').value;
            $.ajax({
                type: 'POST',
                url: 'php/change_username.php',
                data: {csrf : csrf, username : username},
                success: function(data){
                    if(data!="OK")
                    {
                        swal({
                            title: "Error!",
                            text: data,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    else
                    {
                        window.location.reload();
                   	}
                }
            });
    	}

    	function go_to_snippet(id){
    		window.location.href = "home.php#snippet" + id;
    	}

    	function editSnippet(id, title, priv, pic_link){
    		$('#form-pic').val(pic_link);
    		$('#form-title').val(title);
    		if(priv == 1){
    			$('#form-private').attr('checked', true);
    		}
    		$('#form-text').val(document.getElementById('full'+id).value);
    		$('#form-sid').val(id);
    	}

    	function deleteSnippet(id){
    		var r = confirm("Are you sure you want to delete this snippet?");
			var csrf = document.getElementById('csrf').value;
            if (r == true) {
    			$.ajax({
                	type: 'POST',
                	url: 'php/delete_snippet.php',
                	data: {csrf : csrf, snippet_id : id},
                	success: function(data){
                    	if(data!="OK")
                    	{
                        	swal({
                            	title: "Error!",
                            	text: data,
                            	type: "error",
                            	confirmButtonText: "Ok"
                        	});
                    	}
                    	else
                    	{
                        	window.location.reload();
                    	}
                    }
            	});
    		}
    	}
    </script>

</body>

</html>
