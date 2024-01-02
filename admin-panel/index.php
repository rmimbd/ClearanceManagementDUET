<?php
	require ("../databaseserver.php");
	
	if(!isset($_SESSION['DCMS_user'])){
		require('../include/error.php');
		return;
	}
	else{
		if($DB->current_user->user_type!="superAdmin"){
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
					<a href="../admin-panel/">
						<?php if(!isset($_GET['tab'])){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php } ?>
							<i class="fa fa-home" style="font-size:25px;"></i> <?php echo $SM->strings['nav_dashboard'];?>
						</li>
					</a>
					<a href="?tab=userManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="userManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-user-secret" style="font-size:22px;"></i> User Management
						</li>
					</a>

					<a href="?tab=studentManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="studentManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-user" style="font-size:22px;"></i> Student Management
						</li>
					</a>

					<a href="?tab=officeManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="officeManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-simplybuilt" style="font-size:20px;"></i> Office Management
						</li>
					</a>

					<a href="?tab=departmentManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="departmentManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-puzzle-piece" style="font-size:22px;"></i> Department Management
						</li>
					</a>

					<a href="?tab=hallManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="hallManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-institution" style="font-size:22px;"></i> Hall Management
						</li>
					</a>


					<a href="?tab=labManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="labManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-flask" style="font-size:22px;"></i> Lab Management
						</li>
					</a>

					<a href="?tab=specialApproverManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="specialApproverManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-check-square" style="font-size:22px;"></i> Approver Management
						</li>
					</a>

					<!-- <a href="?tab=applicationManagement">
						<?php if(isset($_GET['tab'])){ if($_GET['tab']=="applicationManagement"){?>
						<li style="background-color: #022C28;border-left: 5px solid #000;">
						<?php } else {?>
						<li>
						<?php }} else{?>
						<li>
						<?php } ?>
							<i class="fa fa-wpforms" style="font-size:22px;"></i> Application Management
						</li>
					</a>
					 -->
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
					if($_GET['tab']=="userManagement"){
						if(isset($_GET['action'])){
							if($_GET['action']=="addUser")
								echo "<i class=\"fa fa-user-plus\" style=\"font-size:25px;\"></i> "."Add User";
							else if($_GET['action']=="edit")
								echo "<i class=\"fa fa-edit\" style=\"font-size:25px;\"></i> "."Update User Information";
							else if($_GET['action']=="details")
								echo "<i class=\"fa fa-user\" style=\"font-size:25px;\"></i> "."User Details";
							else if($_GET['action']=="delete")
								echo "<i class=\"fa fa-user-times\" style=\"font-size:25px;\"></i> "."Restrict User";
							else if($_GET['action']=="unrestrict")
								echo "<i class=\"fa fa-user\" style=\"font-size:25px;\"></i> "."Unrestrict User";
							
						}
						else
							echo "<i class=\"fa fa-user-secret\" style=\"font-size:25px;\"></i> "."User Management";
					}
					else if($_GET['tab']=="studentManagement"){
						if(isset($_GET['action'])){
							if($_GET['action']=="add")
								echo "<i class=\"fa fa-user-plus\" style=\"font-size:25px;\"></i> "."Add Student";
							else if($_GET['action']=="edit")
								echo "<i class=\"fa fa-edit\" style=\"font-size:25px;\"></i> "."Update Student Information";
							else if($_GET['action']=="details")
								echo "<i class=\"fa fa-user\" style=\"font-size:25px;\"></i> "."Student Details";
							else if($_GET['action']=="delete")
								echo "<i class=\"fa fa-user-times\" style=\"font-size:25px;\"></i> "."Delete Student";
							
						}
						else
							echo "<i class=\"fa fa-user\" style=\"font-size:25px;\"></i> "."Student Management";
					}
					else if($_GET['tab']=="officeManagement"){
						if(isset($_GET['action'])){
							if($_GET['action']=="add")
								echo "<i class=\"fa fa-plus-square\" style=\"font-size:25px;\"></i> "."Add Office";
							else if($_GET['action']=="edit")
								echo "<i class=\"fa fa-edit\" style=\"font-size:25px;\"></i> "."Update Office Information";
							else if($_GET['action']=="delete")
								echo "<i class=\"fa fa-trash\" style=\"font-size:25px;\"></i> "."Delete Office";
							
						}
						else
							echo "<i class=\"fa fa-simplybuilt\" style=\"font-size:25px;\"></i> "."Office Management";
					}
					else if($_GET['tab']=="hallManagement"){
						if(isset($_GET['action'])){
							if($_GET['action']=="add")
								echo "<i class=\"fa fa-plus-square\" style=\"font-size:25px;\"></i> "."Add Hall";
							else if($_GET['action']=="edit")
								echo "<i class=\"fa fa-edit\" style=\"font-size:25px;\"></i> "."Update Hall Information";
							else if($_GET['action']=="delete")
								echo "<i class=\"fa fa-trash\" style=\"font-size:25px;\"></i> "."Delete Hall";
							
						}
						else
							echo "<i class=\"fa fa-institution\" style=\"font-size:25px;\"></i> "."Hall Management";
					}
					else if($_GET['tab']=="specialApproverManagement"){
						if(isset($_GET['action'])){
							if($_GET['action']=="add")
								echo "<i class=\"fa fa-user-plus\" style=\"font-size:25px;\"></i> "."Add Special Approver";
							else if($_GET['action']=="edit")
								echo "<i class=\"fa fa-edit\" style=\"font-size:25px;\"></i> "."Update Special Approver Information";
							else if($_GET['action']=="delete")
								echo "<i class=\"fa fa-trash\" style=\"font-size:25px;\"></i> "."Delete Special Approver";
							
						}
						else
							echo "<i class=\"fa fa-check-square\" style=\"font-size:25px;\"></i> "."Special Approver Management";
					}
					else if($_GET['tab']=="departmentManagement"){
						if(isset($_GET['action'])){
							if($_GET['action']=="add")
								echo "<i class=\"fa fa-puzzle-piece\" style=\"font-size:25px;\"></i> "."Add Department";
							else if($_GET['action']=="edit")
								echo "<i class=\"fa fa-edit\" style=\"font-size:25px;\"></i> "."Update Department Information";
							else if($_GET['action']=="delete")
								echo "<i class=\"fa fa-trash\" style=\"font-size:25px;\"></i> "."Delete Department";
							
						}
						else
							echo "<i class=\"fa fa-puzzle-piece\" style=\"font-size:25px;\"></i> "."Department Management";
					}
					else if($_GET['tab']=="labManagement"){
						if(isset($_GET['action'])){
							if($_GET['action']=="add")
								echo "<i class=\"fa fa-plus-square\" style=\"font-size:25px;\"></i> "."Add Lab";
							else if($_GET['action']=="edit")
								echo "<i class=\"fa fa-edit\" style=\"font-size:25px;\"></i> "."Update Lab Information";
							else if($_GET['action']=="delete")
								echo "<i class=\"fa fa-trash\" style=\"font-size:25px;\"></i> "."Delete Lab";
							
						}
						else
							echo "<i class=\"fa fa-flask\" style=\"font-size:25px;\"></i> "."Lab Management";
					}
					else{
						header("Location:../");
						return;
					}
				?>
				</div>
				<div class="tabContent" id="adminTabContent">
					<?php
						if($_GET['tab']=="userManagement"){
							if(isset($_GET['action'])){
								if($_GET['action']=="addUser")
									include('add_user.php');
								else if($_GET['action']=="edit")
									include('update_user.php');
								else if($_GET['action']=="details")
									include('user_details.php');
								else if($_GET['action']=="delete")
									include('user_delete_confirmation.php');	
								else if($_GET['action']=="unrestrict")
									include('user_unrestrict_confirmation.php');	
								
							}
							else
								include('user_management.php');
						}
						else if($_GET['tab']=="studentManagement"){
							if(isset($_GET['action'])){
								if($_GET['action']=="add")
									include('add_student.php');
								else if($_GET['action']=="edit")
									include('update_student.php');
								else if($_GET['action']=="details")
									include('student_details.php');
								else if($_GET['action']=="delete")
									include('student_delete_confirmation.php');
							}
							else
								include('student_management.php');
						}
						else if($_GET['tab']=="officeManagement"){
							if(isset($_GET['action'])){
								if($_GET['action']=="add")
									include('add_office.php');
								else if($_GET['action']=="edit")
									include('update_office.php');
								else if($_GET['action']=="delete")
									include('office_delete_confirmation.php');
							}
							else
								include('office_management.php');
						}
						else if($_GET['tab']=="hallManagement"){
							if(isset($_GET['action'])){
								if($_GET['action']=="add")
									include('add_hall.php');
								else if($_GET['action']=="edit")
									include('update_hall.php');
								else if($_GET['action']=="delete")
									include('hall_delete_confirmation.php');
							}
							else
								include('hall_management.php');
						}
						else if($_GET['tab']=="labManagement"){
							if(isset($_GET['action'])){
								if($_GET['action']=="add")
									include('add_lab.php');
								else if($_GET['action']=="edit")
									include('update_lab.php');
								else if($_GET['action']=="delete")
									include('lab_delete_confirmation.php');
							}
							else
								include('lab_management.php');
						}
						else if($_GET['tab']=="departmentManagement"){
							include('department_management.php');
						}
						else if($_GET['tab']=="specialApproverManagement"){
							include('special_approver_management.php');
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
		require ("../include/footer_alter.php");
	?>
	<!-- Footer Section End -->
	<script src="../js/jquery-2.x-git.min.js"></script>
	<script src="../js/function.js"></script>

</body>
</html>