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
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=0.9">
	<title><?php echo $DB->current_user->name." - ".$SM->strings['site_title'];?></title>
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
	<div class="main">
		<br><br><br>
		<div class="singlebox" style="border: 0px solid #ffffff;">
		<div class="box"  id="">
			<div class="boxTitle" style="line-height: 40px;">
				<h3 style="text-align: center;">Profile</h3>
			</div>
			<div class="boxContent" style="padding:0px">
				<table class="tableOne">
				<colgroup>
		    		<col span="1" style="width: 30%;">
		    		<col span="1" style="width: 70%;">
		    	</colgroup>
				<tr class="oddRow">
					<th>Name</th>
					<td><?php echo $DB->current_user->name; ?></td>
				</tr>
				<tr class="evenRow">
					<th>Student ID</th>
					<td><?php echo $DB->current_user->student_id; ?></td>
				</tr>
				<tr class="oddRow">
					<th>Department</th>
					<td><?php echo $DB->current_user->department ?></td>
				</tr>
				<tr class="evenRow">
					<th>Year/Semester</th>
					<td><?php echo $DB->current_user->year."/".$DB->current_user->semester; ?></td>
				</tr>
				<tr class="oddRow">
					<th>Phone</th>
					<td><?php echo $DB->current_user->phone ?></td>
				</tr>
				<tr class="evenRow">
					<th>Email</th>
					<td><?php echo $DB->current_user->email; ?></td>
				</tr>
				<tr class="oddRow">
					<th>Username</th>
					<td><?php echo $DB->current_user->username;?></td>
				</tr>
				
				</table>
			</div>
		</div>
		
		<div class="clearFix"></div>
		</div>
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
