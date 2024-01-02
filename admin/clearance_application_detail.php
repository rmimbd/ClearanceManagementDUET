<?php
$application_id=NULL;
	if(!isset($_SESSION['DCMS_user'])){
		require('../include/error_alter.php');
		return;
	}
	else{
		if($DB->current_user->user_type!="admin"){
			require('../include/error_alter.php');
			return;
		}
		else if(!isset($_GET['application_id'])){
			require('../include/error_alter.php');
			return;
		}
		else{
			$application_id=input_filter($_GET['application_id']);
			if(!$DB->is_valid_application_id($application_id)){
				require('../include/error_alter.php');
				return;
			}
		}
	}

?>

<?php
$student_id=mysqli_fetch_array($DB->get_application_data($application_id))['student_id'];
$application_data=mysqli_fetch_array($DB->get_application_data_of_student($student_id));
?>
<div class="compactbox">
	<div class="box">
		<div class="boxTitle2">
			<h3><center>Clearance Application Information</center></h3>
		</div>
		<div class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 40%;">
		    		<col span="1" style="width: 60%;">
		    	</colgroup>
				<tr class="evenRow">
					<th>Application ID</th>
					<td><?php echo $application_data['clearance_id'];?></td>
				</tr>
				<tr class="oddRow">
					<th>Student ID</th>
					<td><?php echo $application_data['student_id'];?></td>
				</tr>
				<tr class="evenRow">
					<th>Department</th>
					<td><?php echo $DB->get_department_name($application_data['department_id']);?></td>
				</tr>
				<tr class="oddRow">
					<th>Student Name</th>
					<td><?php echo $application_data['name'];?></td>
				</tr>
				<tr class="evenRow">
					<th>Father's Name</th>
					<td><?php echo $application_data['name_of_father'];?></td>
				</tr>
				<tr class="oddRow">
					<th>Mother's Name</th>
					<td><?php echo $application_data['name_of_mother'];?></td>
				</tr>
				<tr class="evenRow">
					<th>Year/Semester</th>
					<td><?php echo $application_data['current_year'].'/'.$application_data['current_semester'];?></td>
				</tr>
				<tr class="oddRow">
					<th>Session</th>
					<td><?php echo $application_data['session'];?></td>
				</tr>
				<tr class="evenRow">
					<th>Admission Year</th>
					<td><?php echo $application_data['admission_year'];?></td>
				</tr>
				<tr class="oddRow">
					<th>Application Status</th>
					<td>
						<?php
						switch ($application_data['final_status']) {
							case 0:
								echo "<b>Pending</b>";
								break;
							case 1:
								echo "<b>Approved</b>";
								break;
							case 2:
								echo "<b>Declined</b>";
								break;
						}
						?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<br>
<?php
$approvers=array();
$approvers_list=$DB->get_approver_categories();
$index=1;
while($row=mysqli_fetch_array($approvers_list)){
	$approvers[$index]=$row['type'];
	$index++;
}
$lab_datas=$DB->get_lab_approval_log($application_data['clearance_id']);
$admin_offices=array();
$admin_offices_list=$DB->get_admin_office_list();
$index=0;
$admin_office_data=mysqli_fetch_array($DB->get_application_admin_office_data_of_student($student_id));
while($row=mysqli_fetch_array($admin_offices_list)){
	$admin_offices[$index]=$row['office_name'];
	$index++;
}
?>
<div class="compactbox">
	<div class="hidableBox">
		<div class="hidableBoxTitle" id="initialApprovalTitle">
			<h3><center>Initial Approval : <?php echo $application_data['approved_level']>=1?"Approved":"Pending"; ?></center></h3>
			<button id="initialApprovalViewer"><i class="fa fa-angle-down" style="font-size:30px;"></i></button>
		</div>
		<div id="initialApproval" class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 70%;">
		    		<col span="1" style="width: 30%;">
		    	</colgroup>
				<tr class="oddRow">
					<th>System</th>
					<td><?php echo "Approved";?></td>
				</tr>
				<tr class="evenRow">
					<th><?php echo $approvers[1]; ?></th>
					<td><?php echo $application_data['so_exam_controller']==1?"Approved":"Pending";?></td>
				</tr>
				
			</table>
		</div>
	</div>
</div>
<br>
<div class="compactbox">
	<div class="hidableBox">
		<div class="hidableBoxTitle" id="hallApprovalTitle">
			<h3><center>Hall Approval : <?php echo $application_data['approved_level']>=3?"Approved":"Pending"; ?></center></h3>
			<button id="hallApprovalViewer"><i class="fa fa-angle-down" style="font-size:30px;"></i></button>
		</div>
		<div id="hallApproval" class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 70%;">
		    		<col span="1" style="width: 30%;">
		    	</colgroup>
				<tr class="oddRow">
					<th>Resident Hall Name</th>
					<td><?php echo $DB->get_hall_name($application_data['hall']);?></td>
				</tr>
				<tr class="evenRow">
					<th>Hall Room Number</th>
					<td><?php echo $application_data['hall_room_number'];?></td>
				</tr>
				<tr class="oddRow">
					<th><?php echo $approvers[2]; ?></th>
					<td><?php echo $application_data['aso_hall']==1?"Approved":"Pending";?></td>
				</tr>
				
				<tr class="evenRow">
					<th><?php echo $approvers[3]; ?></th>
					<td><?php echo $application_data['provost']==1?"Approved":"Pending";?></td>
				</tr>
				
			</table>
		</div>
	</div>
</div>
<br>

<div class="compactbox">
	<div class="hidableBox">
		<div class="hidableBoxTitle" id="labApprovalTitle">
			<h3><center>Labs Approval : <?php echo $application_data['approved_level']>=4?"Approved":"Pending"; ?></center></h3>
			<button id="labApprovalViewer"><i class="fa fa-angle-down" style="font-size:30px;"></i></button>
		</div>
		<div id="labApproval" class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 40%;">
		    		<col span="1" style="width: 30%;">
		    		<col span="1" style="width: 30%;">
		    	</colgroup>
				<tr class="tableOneHeader2">
					<th>Name of the Lab</th>
					<th>Lab Assistant</th>
					<th>Lab In Charge</th>
				</tr>
				<?php
				$count=0;
				while($lab_data=mysqli_fetch_array($lab_datas)) {?>
				<tr class="<?php echo $count%2==0?"oddRow":"evenRow";?>">
					<th><?php echo $lab_data['name']; ?></th>
					<td><?php echo $lab_data['assistant_approved']?"Approved":"Pending"; ?></td>
					<td><?php echo $lab_data['officer_approved']?"Approved":"Pending"; ?></td>
				</tr>
				<?php $count++;} ?>
			</table>
		</div>
	</div>
</div>
<br>
<div class="compactbox">
	<div class="hidableBox">
		<div class="hidableBoxTitle" id="departmentApprovalTitle">
			<h3><center>Approval of Department : <?php echo $application_data['approved_level']>=7?"Approved":"Pending"; ?></center></h3>
			<button id="departmentApprovalViewer"><i class="fa fa-angle-down" style="font-size:30px;"></i></button>
		</div>
		<div id="departmentApproval" class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 70%;">
		    		<col span="1" style="width: 30%;">
		    	</colgroup>
				<tr class="oddRow">
					<th><?php echo $approvers[5]; ?></th>
					<td><?php echo $application_data['aso_department']==1?"Approved":"Pending";?></td>
				</tr>
				<tr class="evenRow">
					<th><?php echo $approvers[6]; ?></th>
					<td><?php echo $application_data['thesis_supervisor']==1?"Approved":"Pending";?></td>
				</tr>
				<tr class="oddRow">
					<th><?php echo $approvers[7]; ?></th>
					<td><?php echo $application_data['head_department']==1?"Approved":"Pending";?></td>
				</tr>
				
			</table>
		</div>
	</div>
</div>
<br>
<div class="compactbox">
	<div class="hidableBox">
		<div class="hidableBoxTitle" id="adminOfficeApprovalTitle">
			<h3><center>Approval of Administrative Offices : <?php echo $application_data['approved_level']>=8?"Approved":"Pending"; ?></center></h3>
			<button id="adminOfficeApprovalViewer"><i class="fa fa-angle-down" style="font-size:30px;"></i></button>
		</div>
		<div id="adminOfficeApproval" class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 40%;">
		    		<col span="1" style="width: 30%;">
		    		<col span="1" style="width: 30%;">
		    	</colgroup>
				<tr class="tableOneHeader2">
					<th>Name of the Office</th>
					<th>Officer</th>
					<th>Administrative Head</th>
				</tr>
				<?php
				$count=0;
				while($count<=5) {?>
				<tr class="<?php echo $count%2==0?"oddRow":"evenRow";?>">
					<th><?php echo $admin_offices[$count]; ?></th>
					<td><?php echo $admin_office_data['s'.$count]==0?"Pending":"Approved"; ?></td>
					<td><?php echo $admin_office_data['s'.$count]==2?"Approved":"Pending"; ?></td>
				</tr>
				<?php $count++;} ?>
			</table>
		</div>
	</div>
</div>
<br>
<div class="compactbox">
	<div class="hidableBox">
		<div class="hidableBoxTitle" id="dswApprovalTitle">
			<h3><center>Approval of DSW Office : <?php echo $application_data['approved_level']>=10?"Approved":"Pending"; ?></center></h3>
			<button id="dswApprovalViewer"><i class="fa fa-angle-down" style="font-size:30px;"></i></button>
		</div>
		<div id="dswApproval" class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 70%;">
		    		<col span="1" style="width: 30%;">
		    	</colgroup>
				<tr class="oddRow">
					<th><?php echo $approvers[9]; ?></th>
					<td><?php echo $application_data['assistant_dsw']==1?"Approved":"Pending";?></td>
				</tr>
				<tr class="evenRow">
					<th><?php echo $approvers[10]; ?></th>
					<td><?php echo $application_data['dsw']==1?"Approved":"Pending";?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<br>
<div class="compactbox">
	<div class="hidableBox">
		<div class="hidableBoxTitle" id="finalApprovalTitle">
			<h3><center>Final Approval : <?php
										if($application_data['final_status']==0)
											echo"Pending";
										else if($application_data['final_status']==1)
											echo"Approved";
										else if($application_data['final_status']==2)
											echo"Declined";
										?></center></h3>
			<button id="finalApprovalViewer"><i class="fa fa-angle-down" style="font-size:30px;"></i></button>
		</div>
		<div id="finalApproval" class="hidableBoxContent application_details">
			<table class="reportView">
				<colgroup>
		    		<col span="1" style="width: 70%;">
		    		<col span="1" style="width: 30%;">
		    	</colgroup>
				<tr class="oddRow">
					<th><?php echo $approvers[11]; ?></th>
					<td><?php if($application_data['deputy_exam_controller']==0)
							echo "Pending";
						else if($application_data['deputy_exam_controller']==1)
							echo "Approved";
						else if($application_data['deputy_exam_controller']==2)
							echo "Declined";
					?></td>
				</tr>
				<tr class="evenRow">
					<th>Final Status</th>
					<td><?php if($application_data['final_status']==0)
							echo "<b>Pending</b>";
						else if($application_data['final_status']==1)
							echo "<b>Approved</b>";
						else if($application_data['final_status']==2)
							echo "<b>Declined</b>";
					?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<br>