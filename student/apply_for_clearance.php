<?php
	require ("../databaseserver.php");
	if(!isset($_SESSION['DCMS_user'])){
		require('../include/error.php');
		return;
	}
	else{
		if($DB->current_user->user_type!="student"){
			require('../include/error.php');
			return;
		}
	}

	if(isset($_POST['submit_application'])){
		$_SESSION['apply_for_clearance']=true;
	}

	if(isset($_POST['confirm_apply_clearance'])){
		$application_id = date("Y").$DB->current_user->student_id;
		$DB->submit_new_application($application_id,$DB->current_user->student_id);
		$_SESSION['new_application_submitted']=true;
	}
	else if(isset($_POST['cancel_apply_clearance'])){
		$_SESSION['cancel_apply_clearance']=true;
		header("Location:../student/apply_for_clearance.php");
		return;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $SM->strings['site_title'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=0.9">
	<link rel="icon" href="../images/icon/duet_icon.ico">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../fonts/font-awesome.min.css">
</head>
<body>
	<!-- Main Section Start -->
	<!-- Header Start -->
	<?php
		require ("../include/student_header.php");
	?>
	<br><br><br>
	<!-- Header End -->
	<div class="main" style="vertical-align:center">
		<br><br><br><br>
		<?php
		if((($DB->current_user->department!="ARCH" && $DB->current_user->year==4 && $DB->current_user->semester==2)||($DB->current_user->department=="ARCH" && $DB->current_user->year==5 && $DB->current_user->semester==2)) && !$DB->is_clearance_application_submitted($DB->current_user->student_id) && $DB->is_allowed_to_apply($DB->current_user->student_id)){?>
		<?php if(isset($_SESSION['cancel_apply_clearance'])){?>
		<div class="col-2" style="float:none; display: block;">
			<div class="box">
				<div class="boxTitle">
					<h3>Cancelled application</h3>
				</div>
				<div class="boxContent">
					Application process halted. Feel free to apply anytime.<br><br>
					<a href="../student/apply_for_clearance.php"><button class="button2 darkBlueButton" style="float:right;margin-left:10px">Close</button></a>
				</div>
			</div>
		</div>
		<?php
		}
		else if(!isset($_SESSION['apply_for_clearance'])){?>
		<div class="col-2" style="float:none; display: block;">
			<div class="box">
				<div class="boxTitle">
					<h3>Apply for clearance</h3>
				</div>
				<div class="boxContent">
					Click the apply button to submit the application.<br><br>
					<form method="POST">
						<input type="submit" class="button2" style="float:right" name="submit_application" value="Apply">
					</form>
				</div>
			</div>
		</div>
		<?php }else{?>
		<div class="col-2" style="float:none; display: block;">
			<div class="box">
				<div class="boxTitle">
					<h3>Confirm Submission</h3>
				</div>
				<div class="boxContent">
					Click the confirm button to submit the application.<br><br>
					<form method="POST">
						<input type="submit" class="button2 greenButton" style="float:right;margin-left:10px" name="confirm_apply_clearance" value="Confirm">
						<input type="submit" class="button2 redButton" style="float:right" name="cancel_apply_clearance" value="Cancel">
					</form>
				</div>
			</div>
		</div>

		<?php
		}
		unset($_SESSION['apply_for_clearance']);
		if(!isset($_POST['cancel_apply_clearance']))
			unset($_SESSION['cancel_apply_clearance']);
		}
		else{
			if(isset($_SESSION['new_application_submitted']))
				echo "<center><h3>Application Submitted Successfully.</h3>";
			else
				echo "<center><h3>You are not allowed for apply.</h3>";
			if(!(($DB->current_user->department!="ARCH" && $DB->current_user->year==4 && $DB->current_user->semester==2)||($DB->current_user->department=="ARCH" && $DB->current_user->year==5 && $DB->current_user->semester==2))){
				echo "<b>Clearance application is only open for final year students.</b>";
			}
			else if($DB->is_clearance_application_submitted($DB->current_user->student_id)){
				if(!isset($_SESSION['new_application_submitted'])){
					echo "<b>A clearance application is already submitted.</b><br><br>";
				}
				echo "<a href=\"clearance_application_detail.php\"><button class=\"button1\">View Application Status</button></a>";
			}
			else if(!$DB->is_allowed_to_apply($DB->current_user->student_id))
				echo "<b>Clearance application process is not started yet or the deadline is expired.</b>";
			echo "</center>";
		}
		if(isset($_SESSION['new_application_submitted']))
			unset($_SESSION['new_application_submitted']);
		?>
		
		<div class="clearFix"></div>
		<br><br><br>
		<!-- Mission and Vision Section End -->

		
		

	</div><!-- /.main -->
	<!-- Main Section End -->
	<!-- Footer Section Start -->
	<?php
		require ("../include/footer.php");
	?>
	<!-- Footer Section End -->
	<script src="../js/jquery-2.x-git.min.js"></script>
	<script src="../js/function.js"></script>

</body>
</html>