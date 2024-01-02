<?php
	require ("../databaseserver.php");
	
	if(!isset($_SESSION['DCMS_user'])){
		require('../include/error.php');
		return;
	}
	else{
		if($DB->current_user->user_type!="admin"){
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
	<link rel="icon" href="../images/icon/duet_icon.ico">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../fonts/font-awesome.min.css">
</head>
<body>
	<!-- Main Section Start -->
	<!-- Header Start -->
	<?php
		require ("../include/header.php");
	?>
	<br>
	<!-- Header End -->
	<div class="main">
		<br><br>
		<div class="adminInterface" id="adminWindow">
			<div class="leftNavigation" id="leftNavigation">
				<ul>
					<a href="../admin/">
						<?php if(!isset($_GET['tab'])){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php } ?>
							<i class="fa fa-home" style="font-size:25px;"></i> <?php echo $SM->strings['nav_dashboard'];?>
						</li>
					</a>
					<?php if($DB->current_user->account_status) {?>
					<?php if(($DB->current_user->approver_level>0 && $DB->current_user->approver_level<12) || 
							$DB->is_hall_admin() || 
							$DB->is_lab_admin() || 
							$DB->is_department_admin() ||
							$DB->is_administrative_office_admin()
							) {?>
					<a href="?tab=clearanceApplications">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="clearanceApplications" || $_GET['tab']=="applicationDetails"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-wpforms" style="font-size:22px;"></i> <?php echo $SM->strings['nav_clearance_applications'];?>
						</li>
					</a>
					<?php } ?>

					<?php if($DB->current_user->approver_level==12) {?>
					<a href="?tab=clearanceValidation">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="clearanceValidation"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-check-square" style="font-size:22px;"></i> Application Validation
						</li>
					</a>
					<?php } ?>

					
					<a href="?tab=createReport">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="createReport"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-clipboard" style="font-size:22px;"></i> <?php echo $SM->strings['nav_create_report'];?>
						</li>
					</a>
					<a href="?tab=browseReport">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="browseReport" || $_GET['tab']=="viewReport"|| $_GET['tab']=="updateReport" || $_GET['tab']=="resolveReport" || $_GET['tab']=="deleteReport"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-list" style="font-size:20px;"></i> <?php echo $SM->strings['nav_browse_report'];?>
						</li>
					</a>
					
					<a href="?tab=profile">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="profile"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-user-o" style="font-size:20px;"></i> Profile
						</li>
					</a>
					<?php } ?>
					<a href="/index.php?logout=true">
						<li><i class="fa fa-sign-out" style="font-size:20px;"></i> <?php echo $SM->strings['text_log_out'];?></li>
					</a>
					
				</ul>
			</div>
			<div class="content" id="adminInterfaceContent">
				<?php
				if(!isset($_GET['tab'])){?>
				<div class="tabTitle" id="adminTabTitle"><i class="fa fa-home" style="font-size:30px;"></i> <?php echo $SM->strings['nav_dashboard'];?></div>
				<div class="tabContent" id="adminTabContent">
					<?php include('dashboard.php');?>
				</div>
				<?php
				}
				else{?>
				<div class="tabTitle" id="adminTabTitle">
				<?php
					if($_GET['tab']=="createReport")
						echo "<i class=\"fa fa-clipboard\" style=\"font-size:25px;\"></i> ".$SM->strings['nav_create_report'];
					else if($_GET['tab']=="browseReport")
						echo "<i class=\"fa fa-list\" style=\"font-size:22px;\"></i> ".$SM->strings['nav_browse_report'];
					else if($_GET['tab']=="viewReport")
						echo "<i class=\"fa fa-eye\" style=\"font-size:22px;\"></i> ".$SM->strings['text_view_report'];
					else if($_GET['tab']=="updateReport")
						echo "<i class=\"fa fa-edit\" style=\"font-size:22px;\"></i> ".$SM->strings['text_update_report'];
					else if($_GET['tab']=="resolveReport")
						echo "<i class=\"fa fa-check-square\" style=\"font-size:22px;\"></i> ".$SM->strings['text_resolve_report'];
					else if($_GET['tab']=="deleteReport")
						echo "<i class=\"fa fa-trash\" style=\"font-size:22px;\"></i> ".$SM->strings['text_delete_report'];
					else if($_GET['tab']=="profile")
						echo "<i class=\"fa fa-user-o\" style=\"font-size:22px;\"></i> Profile";
					else if($_GET['tab']=="clearanceApplications")
						echo "<i class=\"fa fa-wpforms\" style=\"font-size:24px;\"></i> Clearance Applications";
					else if($_GET['tab']=="clearanceValidation")
						echo "<i class=\"fa fa-check-square\" style=\"font-size:24px;\"></i> Clearance Application Validation";
					else if($_GET['tab']=="applicationDetails")
						echo "<i class=\"fa fa-wpforms\" style=\"font-size:24px;\"></i> Clearance Application Details";
					else
						header("Location:../");
				?>
				</div>
				<div class="tabContent" id="adminTabContent">
					<?php
						if($_GET['tab']=="createReport")
							include('create_report.php');
						else if($_GET['tab']=="browseReport")
							include('browse_report.php');
						else if($_GET['tab']=="viewReport")
							include('view_report.php');
						else if($_GET['tab']=="updateReport")
							include('update_report.php');
						else if($_GET['tab']=="resolveReport")
							include('mark_report_resolved.php');
						else if($_GET['tab']=="deleteReport")
							include('mark_report_deleted.php');
						else if($_GET['tab']=="profile")
							include('profile.php');
						else if($_GET['tab']=="clearanceApplications"){
							if(($DB->current_user->approver_level>0 && $DB->current_user->approver_level<12) || 
							$DB->is_hall_admin() || 
							$DB->is_lab_admin() || 
							$DB->is_department_admin() ||
							$DB->is_administrative_office_admin()
							)
								include('clearance_applications.php');
							else
								header("Location:../");
						}
						else if($_GET['tab']=="applicationDetails"){
							if(($DB->current_user->approver_level>0 && $DB->current_user->approver_level<=12) || 
							$DB->is_hall_admin() || 
							$DB->is_lab_admin() || 
							$DB->is_department_admin() ||
							$DB->is_administrative_office_admin()
							)
								include('clearance_application_detail.php');
							else
								header("Location:../");
						}
						else if($_GET['tab']=="clearanceValidation"){
							if($DB->current_user->approver_level==12)
								include('clearance_application_validation.php');
							else
								header("Location:../");
						}
						

					?>
				<div class="clearFix"></div>
				</div>

				<?php } ?>
			</div>
			<div class="clearFix"></div>
			<br>
		</div>
		<div class="clearFix"></div>
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