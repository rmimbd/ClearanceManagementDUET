<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<?php
	if(!isset($_SESSION['application_filter'])){
		if($DB->is_so_exam_controller()) 
			$_SESSION['application_filter']=1;
		else if($DB->supervising_student_available()) 
			$_SESSION['application_filter']=2;
		else if($DB->is_hall_admin())
			$_SESSION['application_filter']=3;
		else if($DB->is_lab_admin())
			$_SESSION['application_filter']=4;
		else if ($DB->is_department_admin())
			$_SESSION['application_filter']=5;
		else if($DB->is_administrative_office_admin_of_office(21))
			$_SESSION['application_filter']=6;
		else if($DB->is_administrative_office_admin_of_office(22))
			$_SESSION['application_filter']=7;
		else if($DB->is_administrative_office_admin_of_office(23))
			$_SESSION['application_filter']=8;
		else if($DB->is_administrative_office_admin_of_office(24))
			$_SESSION['application_filter']=9;
		else if($DB->is_administrative_office_admin_of_office(25))
			$_SESSION['application_filter']=10;
		else if($DB->is_administrative_office_admin_of_office(26))
			$_SESSION['application_filter']=11;
		else if($DB->is_administrative_office_admin_of_office(26))
			$_SESSION['application_filter']=12;	
		else if($DB->is_deputy_exam_controller())
			$_SESSION['application_filter']=13;	
		
	}

	if(!isset($_SESSION['type_filter'])){
		$_SESSION['type_filter']=1;
	}
	
?>
<div class="tabBox2">
	<div class="filterSection">
		<form method="POST" action="clearance_applications_server.php">
			<button type="button" class="button2" id="clearance_filter_dropdown_activator">
			<?php
				if($_SESSION['application_filter']==1) {
					echo "All Application <i class=\"fa fa-filter\"></i>";	
				}
				else if($_SESSION['application_filter']==2){
					echo "Supervising Student's Application <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==3){
					echo "Application of Students from Hall <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==4){
					echo "Application of Lab <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==5){
					echo "Application of Department <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==6){
					echo "Applications of Exam Controller Office <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==7){
					echo "Applications of Comptroller Office <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==8){
					echo "Applications of Medical center <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==9){
					echo "Applications of Computer Center <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==10){
					echo "Applications of Physical Education Center <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==11){
					echo "Applications of Central Library <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['application_filter']==12){
					echo "Applications of DSW Office <i class=\"fa fa-filter\"></i>";
				}

				else if($_SESSION['application_filter']==13){
					echo "Final Applications <i class=\"fa fa-filter\"></i>";
				}

			?>
			</button>
			<ul class="filterList" id="clearance_filter_dropdown_list">
				<?php if($DB->is_so_exam_controller()) {?>
				<li><button <?php if($_SESSION['application_filter']==1) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_application">Show all application</button></li>
				
				<?php } if($DB->supervising_student_available()) {?>
				<li><button <?php if($_SESSION['application_filter']==2) echo "style=\"background-color:#123834;\""; ?> type="submit" name="only_supervising_students">Show supervising student's application</button></li>
				
				<?php } if($DB->is_hall_admin()){?>
				<li><button <?php if($_SESSION['application_filter']==3) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_hall"> Show Application of Students from Hall</button></li>
				
				<?php } if($DB->is_lab_admin()){?>
				<li><button <?php if($_SESSION['application_filter']==4) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_labs"> Show Application of Lab</button></li>
				
				<?php } if($DB->is_department_admin()){?>
				<li><button <?php if($_SESSION['application_filter']==5) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_department"> Show Application of Department</button></li>

				<?php } if($DB->is_administrative_office_admin_of_office(21)){?>
				<li><button <?php if($_SESSION['application_filter']==6) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_exam_controller"> Show Applications of Exam Controller Office</button></li>

				<?php } if($DB->is_administrative_office_admin_of_office(22)){?>
				<li><button <?php if($_SESSION['application_filter']==7) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_comptroller_office"> Show Applications of Comptroller Office</button></li>
				
				<?php } if($DB->is_administrative_office_admin_of_office(23)){?>
				<li><button <?php if($_SESSION['application_filter']==8) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_medical_center"> Show Applications of Medical Center</button></li>
				
				<?php } if($DB->is_administrative_office_admin_of_office(24)){?>
				<li><button <?php if($_SESSION['application_filter']==9) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_computer_center"> Show Applications of Computer Center</button></li>
				
				<?php } if($DB->is_administrative_office_admin_of_office(25)){?>
				<li><button <?php if($_SESSION['application_filter']==10) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_physical_education_center"> Show Applications of Physical Education Center</button></li>
				
				<?php } if($DB->is_administrative_office_admin_of_office(26)){?>
				<li><button <?php if($_SESSION['application_filter']==11) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_central_library"> Show Applications of Central Library</button></li>
				
				<?php } if($DB->is_administrative_office_admin_of_office(27)){?>
				<li><button <?php if($_SESSION['application_filter']==12) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_dsw_office"> Show Applications of DSW Office</button></li>
				
				<?php } if($DB->is_deputy_exam_controller()){?>
				<li><button <?php if($_SESSION['application_filter']==13) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_final"> Show Final Applications</button></li>
				
				<?php }?>

			</ul>
		</form>
	</div>

	<div class="typeFilterSection">
		<form method="POST" action="clearance_applications_server.php">
			<button type="button" class="button2" id="type_filter_dropdown_activator">
			<?php
				if($_SESSION['type_filter']==1) {
					echo "Pending Applications <i class=\"fa fa-filter\"></i>";	
				}
				else if($_SESSION['type_filter']==2){
					echo "Approved Applications <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['type_filter']==3){
					echo "Declined Applications <i class=\"fa fa-filter\"></i>";
				}
			?>
			</button>
			<ul class="filterList" id="type_filter_dropdown_list">
				<li><button <?php if($_SESSION['type_filter']==1) echo "style=\"background-color:#123834;\""; ?> type="submit" name="type_pending"> Show Pending Applications</button></li>
				<li><button <?php if($_SESSION['type_filter']==2) echo "style=\"background-color:#123834;\""; ?> type="submit" name="type_approved"> Show Approved Applications</button></li>
				<?php if($DB->is_deputy_exam_controller() && $_SESSION['application_filter']==13){?>
				<li><button <?php if($_SESSION['type_filter']==3) echo "style=\"background-color:#123834;\""; ?> type="submit" name="type_declined"> Show Declined Applications</button></li>
				
				<?php }?>

			</ul>
		</form>
	</div>

	<div class="searchSection">
		<input type="text" id="search_key" name="key" placeholder="Search Here" required>
		<button type="button" name="searchReport" class="button2" id="search_key_submit"><i class="fa fa-search"></i></button>
	</div>
	<div class="clearFix"></div>
	<?php
	if(isset($_SESSION['application_status_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Application Updated</center>
		</div>
	<?php unset($_SESSION['application_status_updated']); 
	}?>
	<table class="tableOne">
		<?php if($_SESSION['application_filter']!=4) {?>
		<colgroup>
    		<col span="1" style="width: 8%;">
    		<col span="1" style="width: 14%;">
    		<col span="1" style="width: 14%;">
    		<col span="1" style="width: 14%;">
    		<?php if($_SESSION['type_filter']==1) {?>
    		<col span="1" style="width: 18%;">
    		<?php } ?>
    		<col span="1" style="width: 32%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>Application ID</th>
			<th>Student ID</th>
			<th>Department</th>
			<?php if($_SESSION['type_filter']==1) {?>
			<th>Recommendation</th>
			<?php } ?>
			<th>Actions</th>
		</tr>
		<?php } else {?>
		<colgroup>
    		<col span="1" style="width: 6%;">
    		<col span="1" style="width: 14%;">
    		<col span="1" style="width: 12%;">
    		<col span="1" style="width: 12%;">
    		<col span="1" style="width: 22%;">
    		<?php if($_SESSION['type_filter']==1) {?>
    		<col span="1" style="width: 14%;">
    		<?php } ?>
    		<col span="1" style="width: 20%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>Application ID</th>
			<th>Student ID</th>
			<th>Department</th>
			<th>Lab</th>
			<?php if($_SESSION['type_filter']==1) {?>
			<th>Recommendation</th>
			<?php } ?>
			<th>Actions</th>
		</tr>
		<?php
		}
		if($_SESSION['application_filter']==1)
			$applications = $DB->get_all_student_application();
		
		else if($_SESSION['application_filter']==2)
			$applications = $DB->get_supervising_student_application();
		
		else if($_SESSION['application_filter']==3)
			$applications = $DB->get_hall_student_application();

		else if($_SESSION['application_filter']==4)
			$applications = $DB->get_lab_application();
		
		else if($_SESSION['application_filter']==5)
			$applications = $DB->get_department_application();

		else if($_SESSION['application_filter']==6)
			$applications = $DB->main_exam_controller_application();

		else if($_SESSION['application_filter']==7)
			$applications = $DB->comptroller_application();

		else if($_SESSION['application_filter']==8)
			$applications = $DB->medical_center_application();

		else if($_SESSION['application_filter']==9)
			$applications = $DB->computer_center_application();

		else if($_SESSION['application_filter']==10)
			$applications = $DB->physical_education_center_application();

		else if($_SESSION['application_filter']==11)
			$applications = $DB->central_library_application();
		
		else if($_SESSION['application_filter']==12)
			$applications = $DB->dsw_office_application();
		
		else if($_SESSION['application_filter']==13)
			$applications = $DB->get_last_stage_application();
		
		
		$i=0;
		$num_of_applications = mysqli_num_rows($applications);
		while($application=mysqli_fetch_array($applications)){
		$pproved_row=false;
		$declined_row=false;
		$hide_row=false;
		if($_SESSION['application_filter']==4 && $application['approved_level']>=3){
			if($DB->is_lab_officer()){
				if($application['officer_approved']==1)
					$hide_row=true;
			}
			else{
				if($application['assistant_approved']==1)
					$hide_row=true;
			}
		}
		$department_id=$DB->get_student_department($application['student_id']); 
		if($_SESSION['application_filter']==1 && $application['approved_level']>0)
			$pproved_row=true;
		else if($_SESSION['application_filter']==2 && $application['approved_level']>5)
			$pproved_row=true;
		else if($_SESSION['application_filter']==3 && $DB->is_provost() && $application['approved_level']>2)
			$pproved_row=true;
		else if($_SESSION['application_filter']==3 && !$DB->is_provost() && $application['approved_level']>1)
			$pproved_row=true;
		else if($_SESSION['application_filter']==4 && $application['approved_level']>3)
			$pproved_row=true;
		else if($_SESSION['application_filter']==4 && $application['approved_level']>=3 && $hide_row)
			$pproved_row=true;
		else if($_SESSION['application_filter']==5 && $application['approved_level']>=7 && $DB->is_department_head($department_id))
			$pproved_row=true;
		else if($_SESSION['application_filter']==5 && $application['approved_level']>=5 && $DB->is_aso_department($department_id))
			$pproved_row=true;
		else if($_SESSION['application_filter']==6 && $application['exam_controller']>=1 && $DB->is_assistant_head_of_office(21))
			$pproved_row=true;
		else if($_SESSION['application_filter']==6 && $application['exam_controller']>=2 && $DB->is_administrative_head_of_office(21))
			$pproved_row=true;
		else if($_SESSION['application_filter']==7 && $application['comptroller']>=1 && $DB->is_assistant_head_of_office(22))
			$pproved_row=true;
		else if($_SESSION['application_filter']==7 && $application['comptroller']>=2 && $DB->is_administrative_head_of_office(22))
			$pproved_row=true;
		else if($_SESSION['application_filter']==8 && $application['medical_center']>=1 && $DB->is_assistant_head_of_office(23))
			$pproved_row=true;
		else if($_SESSION['application_filter']==8 && $application['medical_center']>=2 && $DB->is_administrative_head_of_office(23))
			$pproved_row=true;
		else if($_SESSION['application_filter']==9 && $application['computer_center']>=1 && $DB->is_assistant_head_of_office(24))
			$pproved_row=true;
		else if($_SESSION['application_filter']==9 && $application['computer_center']>=2 && $DB->is_administrative_head_of_office(24))
			$pproved_row=true;
		else if($_SESSION['application_filter']==10 && $application['physical_edu_center']>=1 && $DB->is_assistant_head_of_office(25))
			$pproved_row=true;
		else if($_SESSION['application_filter']==10 && $application['physical_edu_center']>=2 && $DB->is_administrative_head_of_office(25))
			$pproved_row=true;
		else if($_SESSION['application_filter']==11 && $application['central_library']>=1 && $DB->is_assistant_head_of_office(26))
			$pproved_row=true;
		else if($_SESSION['application_filter']==11 && $application['central_library']>=2 && $DB->is_administrative_head_of_office(26))
			$pproved_row=true;
		else if($_SESSION['application_filter']==12 && $application['assistant_dsw']==1 && $DB->is_assistant_head_of_office(27))
			$pproved_row=true;
		else if($_SESSION['application_filter']==12 && $application['dsw']==1 && $DB->is_administrative_head_of_office(27))
			$pproved_row=true;
		else if($_SESSION['application_filter']==13 && $application['final_status']==1 && $DB->is_deputy_exam_controller())
			$pproved_row=true;
		else if($_SESSION['application_filter']==13 && $application['final_status']==2 && $DB->is_deputy_exam_controller())
			$declined_row=true;
		
		if(($_SESSION['type_filter']==1 && !($pproved_row || $declined_row)) || ($_SESSION['type_filter']==2 && $pproved_row) || ($_SESSION['type_filter']==3 && $declined_row)){
			$i++;?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>" id="<?php echo "application_row_".$i;?>">
			<td><?php echo $i; ?></td>
			<td  id="<?php echo "application_id_".$i;?>"><?php echo $application['clearance_id']; ?></td>
			<td id="<?php echo "student_id_".$i;?>"><?php echo $application['student_id']; ?></td>
			<td id="<?php echo "department_name_id_".$i;?>">
			<?php echo $DB->get_department_name($department_id); ?>
			</td>
			<?php if($_SESSION['application_filter']==4) {?>
			<td id="<?php echo "lab_name_id_".$i;?>"><?php echo $application['lab_name'];?></td>
			<?php } ?>
			<?php if($_SESSION['type_filter']==1) {?>
			<td><?php if($DB->get_number_of_reports_from_office_against_student($DB->current_user->office_id,$application['student_id'])>0) echo "Don't Approve"; else echo "Approve"; ?></td>
			<?php } ?>
			<td>
				<form method="POST" action="clearance_applications_server.php">
					<a href="?tab=applicationDetails&application_id=<?php echo $application['clearance_id']; ?>"><button type="button" class="button2 darkBlueButton"><i class="fa fa-wpforms"></i> Details</button></a>
					<?php if($_SESSION['type_filter']==1 || $_SESSION['type_filter']==3) {?>
					<button type="submit" name="<?php echo $_SESSION['type_filter']==1?"approve_application":"approve_declined_application"; ?>" value="<?php echo $_SESSION['application_filter']==4?$application['lab_id'].$application['clearance_id'] : $application['clearance_id'];?>" class="button2 <?php if($DB->get_number_of_reports_from_office_against_student($DB->current_user->office_id,$application['student_id'])>0) echo 'redButton'; else echo 'greenButton'; ?>"><i class="fa fa-check-square"></i> Approve</button>
					<?php } ?>
				<?php if($DB->current_user->approver_level==11 and $_SESSION['application_filter']==13 and $_SESSION['type_filter']==1) {?>
					<button type="submit" name="decline_application" value="<?php echo $application['clearance_id'];?>" class="button2 <?php if($DB->get_number_of_reports_from_office_against_student($DB->current_user->office_id,$application['student_id'])>0) echo 'greenButton'; else echo 'redButton'; ?>"><i class="fa fa-trash"></i> Decline</button>
				<?php } ?>
				</form>
			</td>
		</tr>
		<?php }
		}

		if($i==0){?>
		<tr>
			<td colspan="<?php echo $_SESSION['application_filter']==4?7:7; ?>"><center><b>No Application to show</b></center></td>
		</tr>
		<?php } ?>
		<script type="text/javascript"><?php echo "var total_row=".$i."; var lab_approval_active=".($_SESSION['application_filter']==4?1:0).";"; ?></script>
	</table>
</div>
<div class="clearFix"></div>