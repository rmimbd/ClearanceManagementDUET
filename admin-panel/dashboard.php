<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<center>
	<div class="squareCard">
		<h3><i class="fa fa-user-secret"></i> Total Admin User</h3>
		<br>
		<h2><?php echo $DB->get_total_number_of_admin(); ?></h2>
		<br>
		<center>
			<a href="?tab=userManagement"><button class="button2">Manage</button></a>
		</center>
	</div>
	<div class="squareCard">
		<h3><i class="fa fa-user"></i> Total Student</h3>
		<br>
		<h2><?php echo $DB->get_total_number_of_student();?></h2>
		<br>
		<center>
			<a href="?tab=studentManagement"><button class="button2">Manage</button></a>
		</center>
	</div>

	<div class="squareCard">
		<h3><i class="fa fa-simplybuilt"></i> Total Offices</h3>
		<br>
		<h2><?php echo $DB->get_total_number_of_offices();?></h2>
		<br>
		<center>
			<a href="?tab=officeManagement"><button class="button2">Manage</button></a>
		</center>
	</div>
	
	<div class="squareCard">
		<h3><i class="fa fa-puzzle-piece"></i> Total Departments</h3>
		<br>
		<h2><?php echo $DB->get_total_number_of_departments();?></h2>
		<br>
		<center>
			<a href="?tab=departmentManagement"><button class="button2">Manage</button></a>
		</center>
	</div>
	
	<div class="squareCard">
		<h3><i class="fa fa-university"></i> Total Halls</h3>
		<br>
		<h2><?php echo $DB->get_total_number_of_halls();?></h2>
		<br>
		<center>
			<a href="?tab=hallManagement"><button class="button2">Manage</button></a>
		</center>
	</div>
	
	<div class="squareCard">
		<h3><i class="fa fa-flask"></i> Total Labs</h3>
		<br>
		<h2><?php echo $DB->get_total_number_of_labs();?></h2>
		<br>
		<center>
			<a href="?tab=labManagement"><button class="button2">Manage</button></a>
		</center>
	</div>
	
	<div class="squareCard">
		<h3><i class="fa fa-check-square"></i> Special Approver</h3>
		<br>
		<h2><?php echo $DB->get_total_number_of_special_approver();?></h2>
		<br>
		<center>
			<a href="?tab=specialApproverManagement"><button class="button2">Manage</button></a>
		</center>
	</div>
	
	<div class="squareCard">
		<h3><i class="fa fa-graduation-cap"></i> Approved Application</h3>
		<br>
		<br>
		<h2><?php echo $DB->get_total_number_of_approved_application();?></h2>
	</div>
	
	<div class="squareCard">
		<h3><i class="fa  fa-circle-o-notch"></i> Pending Application</h3>
		<br>
		<br>
		<h2><?php echo $DB->get_total_number_of_pending_application();?></h2>
	</div>
	<div class="clearFix"></div>
	
</center>