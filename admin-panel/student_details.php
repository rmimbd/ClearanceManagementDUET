<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_GET['student_id'])){
		require('../include/error_alter.php');
		return;
	}
	$student_id=input_filter($_GET['student_id']);
	if(!$DB->is_valid_student_id($student_id)){
		require('../include/error_alter.php');
		return;
	}
	$student_data=$DB->get_information_of_student($student_id);
?>
<?php if(isset($_SESSION['au_success'])) {?>
<div>
	<div class="closable_popup" id="popup">
	<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
	<center><?php echo $_SESSION['au_success'];?></center>
	</div>
</div>
<?php unset($_SESSION['au_success']);}?>

<table class="tableOne" style="width:90%; float: left;">
	<colgroup>
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 70%;">
	</colgroup>
	<tr class="oddRow">
		<th>Student ID</th>
		<td><?php echo $student_data['student_id']; ?></td>
	</tr>
	<tr class="evenRow">
		<th>Name</th>
		<td><?php echo $student_data['name']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Father's Name</th>
		<td><?php echo $student_data['name_of_father'];?></td>
	</tr>
	<tr class="evenRow">
		<th>Gender</th>
		<td><?php echo $student_data['gender']==1?'Male':'Female';?></td>
	</tr>
	<tr class="oddRow">
		<th>Department</th>
		<td><?php echo $DB->get_department_name($student_data['department_id']);?></td>
	</tr>
	<tr class="evenRow">
		<th>Year/Semester</th>
		<td><?php echo $student_data['current_year'].'/'.$student_data['current_semester'];?></td>
	</tr>
	<tr class="oddRow">
		<th>Session</th>
		<td><?php echo $student_data['session'];?></td>
	</tr>
	<tr class="evenRow">
		<th>Admission Year</th>
		<td><?php echo $student_data['admission_year'];?></td>
	</tr>
	<tr class="oddRow">
		<th>Advisor</th>
		<td><?php if($student_data['advisor']!='') echo $DB->get_name_of_teacher($student_data['advisor']);?></td>
	</tr>
	<tr class="evenRow">
		<th>Thesis Supervisor</th>
		<td><?php if($student_data['thesis_supervisor']!='')echo $DB->get_name_of_teacher($student_data['thesis_supervisor']);?></td>
	</tr>
	<tr class="oddRow">
		<th>Hall (#Room)</th>
		<td><?php echo $DB->get_hall_name($student_data['hall']).' (#'.$student_data['hall_room_number'].')';?></td>
	</tr>
	<?php  $student_data_add=$DB->get_login_information_of_user($student_id);?>
	<tr class="evenRow">
		<th>Email</th>
		<td><?php echo $student_data_add['email'];?></td>
	</tr>
	<tr class="oddRow">
		<th>Phone</th>
		<td><?php echo $student_data_add['phone'];?></td>
	</tr>
	<tr class="evenRow">
		<th>Username</th>
		<td><?php echo $student_data_add['username'];?></td>
	</tr>
</table>

<br>
<center>
	<a href="?tab=studentManagement&action=edit&student_id=<?php echo $student_data['student_id']; ?>">
		<button type="button" class="button2 greenButton">
			<i class="fa fa-edit"></i> Update
		</button>
	</a>
	<br>
	<br>
	<a href="?tab=studentManagement&action=delete&student_id=<?php echo $student_data['student_id']; ?>">
		<button type="button" class="button2 redButton">
			<i class="fa fa-ban"></i> Delete
		</button>
	</a>
	
</center>