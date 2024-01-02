<?php
	require ("databaseserver.php");
	$Error_Message=NULL;
	if(isset($_POST['login'])){
		$loginFormUserID = input_filter($_POST['userID']); 
		$loginFormPassword = input_filter($_POST['userPassword']);
		if($DB->validate_login($loginFormUserID, $loginFormPassword)){
			$DB->initialize_user($loginFormUserID);
		}
		else{
			$Error_Message=$SM->strings['invalid_id_or_password'];
		}
	}
	if(isset($_GET['logout'])){
		session_destroy();
		header("Location:/");
		return;
	}
	if(isset($_SESSION['DCMS_user'])){
		if($_SESSION['DCMS_user']->user_type=="student")
			header("Location:student/");
		else if($_SESSION['DCMS_user']->user_type=="admin")
			header("Location:admin/");
		else if($_SESSION['DCMS_user']->user_type=="superAdmin")
			header("Location:admin-panel/");
		
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=0.9">
	<title><?php echo $SM->strings['site_title'];?></title>
	<link rel="icon" href="images/icon/duet_icon.ico">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="fonts/font-awesome.min.css">
</head>
<body>
	<!-- Main Section Start -->
	<!-- Header Start -->
	<div class="header">
		<div class="mainmenu">
			<center><div class="siteTitle"><a href="/"><img src="images/icon/duet_icon.ico" height="25"> <?php echo $SM->strings['site_title'];?></a></div></center>
			
		</div>
	</div><!-- /.header -->
	<?php if(!isset($_SESSION['DCMS_user'])) {?>	
	<div class="landing_page">
		<!-- Header End -->
		<div class="logInForm">
			<br>
			<center><img src="images/icon/duet_icon.ico" height="80px"></center>
			<h3><?php echo $SM->strings['login_form_title'];?></h3>
			<form method="POST" action="">
				<i class="fa fa-user" style="font-size:22px;"></i> <input type="text" name="userID" value="" placeholder="<?php echo $SM->strings['login_form_username_placeholder'];?>" minlength="3" autofocus required />
				<div class="clearFix"></div>
				<i class="fa fa-shield" style="font-size:20px;"></i> <input type="password" name="userPassword" value="" placeholder="<?php echo $SM->strings['login_form_password_placeholder'];?>" minlength="6" required />
				<br><br>
				<button type="submit" name="login"><i class="fa fa-sign-in" style="font-size:20px;"></i> <?php echo $SM->strings['login_form_submit_button'];?></button>
			</form>
			<br>
			<center>
				<?php
					if($Error_Message != NULL)
						echo "<center><b>".$Error_Message."</b></center>";
				?>
				<a href="user_information.pdf" style="font-size:12px"><h3>Sample User Information</h3></a>
				
			</center>

		</div>
		<div class="clearFix"></div>
		<br>
		<br><br>
		<!-- Mission and Vision Section End -->
	</div><!-- /.main -->
	<!-- Main Section End -->
	<?php }
	else{ ?> 
	<div class="main">
		<center><h3>.......</h3></center>
	</div>
	<?php }
	
	?>
	<!-- Footer Section Start -->
	<?php 
		require ("include/footer.php");
	?>
	<!-- Footer Section End -->
	<script src="js/jquery-2.x-git.min.js"></script>
	<script src="js/function.js"></script>

</body>
</html>