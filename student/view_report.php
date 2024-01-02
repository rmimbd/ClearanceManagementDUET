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
	<div class="main">
		<br><br>
		<center><h3>Report Details</h3></center>
		<div class="singlebox">
			<?php
			if(isset($_GET['report_id'])){
				$report_id = input_filter($_GET['report_id']);
				if($DB->is_valid_report_id($report_id)){
					if($DB->match_report_and_student_id($report_id, $DB->current_user->student_id)){
					$report_data=$DB->get_report_data($report_id);
					if($report_data['report_status']<3){
				?>
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 30%;">
		    		<col span="1" style="width: 70%;">
		    	</colgroup>
				<tr class="oddRow">
					<th>Report ID</th>
					<td><?php echo $report_data['report_id'];?></td>
				</tr>
				<tr class="oddRow">
					<th>Issued From</th>
					<td><?php $office=$DB->get_office_data($report_data['issuer_office']);
					echo $office['office_name']."<br>".$office['office_loc'];?></td>
				</tr>
				
				<tr class="evenRow">
					<th>Issued By</th>
					<td><?php $issuer=$DB->get_admin_data($report_data['issuer']);
					echo $issuer['name']."<br>".$issuer['designation']."<br>".$office['office_name'];?></td>
				</tr>
				<tr class="oddRow">
					<th>Issue Date & Time</th>
					<td><?php echo $report_data['issue_date'];?></td>
				</tr>
				
				<tr class="evenRow">
					<th>Title</th>
					<td><?php echo $report_data['title'];?></td>
				</tr>
				<tr class="oddRow">
					<th>Description</th>
					<td><?php echo $report_data['description'];?></td>
				</tr>
				<tr class="evenRow">
					<th>Status</th>
					<td><?php switch($report_data['report_status']){
						case 1:
							echo "Active";
							break;
						case 2:
							echo "Resolved";
							break;
						case 3:
							echo "Deleted";
							break;
					}?></td>
				</tr>
				
			</table>
			<?php 
			}
			else
				echo "<br><br><center><p class=\"unsuccessMessage\">Report unavailable</p></center><br><br>";
			}
				else
					echo "<br><br><center><p class=\"unsuccessMessage\">Invalid Access request</p></center><br><br>";
			}
			else
				echo "<br><br><center><p class=\"unsuccessMessage\">Invalid Report ID</p></center><br><br>";
			}
			else
				header("Location: ../admin/");
			?>
		</div>
		<br>
		<center>
			<a href="../student/"><button class="button2">
				<i class="fa fa-arrow-circle-left"></i> Go Back
			</button></a>
		</center>	
		<br>
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

