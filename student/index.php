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
	<title><?php echo $SM->strings['site_title'];?></title>
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
		<br><br><br><br><br><br>
		<div class="singlebox" style="border: 0px solid #ffffff;">
		<div class="col-2">
			<div class="box"  id="">
				<div class="boxTitle">
					<h3>Issued Reports</h3>
				</div>
				<div class="boxContent student_report_list">
					<?php
						$index=1;
						$reports = $DB->get_report_ids_against_student($DB->current_user->student_id);
						if(mysqli_num_rows($reports)>0){
							while($report=mysqli_fetch_array($reports)){
								echo $index.". ".$report['title']." [<a href=\"view_report.php?report_id=".$report['report_id']."\">"."View Report"."</a>]"."<br>";
								$index++;
							}
						}
						else{
							echo "<br>No issue reported against you.";
						}
					?>
				</div>
			</div>
		</div>
		
		<div class="col-2">
			<div class="box"  id="">
				<div class="boxTitle">
					<h3>Clearance Application Status</h3>
				</div>
				<div class="boxContent">
					<?php
					if(!$DB->is_clearance_application_submitted($DB->current_user->student_id)){
						echo "<br>You did not submit any clearance application.";
					}
					else{
						$application_data=mysqli_fetch_array($DB->get_application_data_of_student($DB->current_user->student_id));
						if($application_data['final_status']==1)
							echo "<br>Your application is <a href=\"clearance_application_detail.php\" style=\"color:#06574f\"><b>Approved</b></a>.";
						else if($application_data['final_status']==2)
							echo "<br>Your application is <b>Declined</b>.";
						
						else{
							echo "<br>Your application is now on the desk of: <a href=\"clearance_application_detail.php\" style=\"color:#06574f\"><b>".$DB->get_approver_type($application_data['approved_level']+1)."</b></a>";
						}
					}
					?>
				</div>
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