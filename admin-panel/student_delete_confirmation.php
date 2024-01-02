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
	$student_data=$DB->get_all_information_of_student($student_id);
	$_SESSION['deleting_student_id']=$student_id;
?>

<table class="tableOne">
	<colgroup>
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 70%;">
	</colgroup>
	<tr class="oddRow">
		<th>Student ID</th>
		<td><?php echo $student_id; ?></td>
	</tr>
	<tr class="evenRow">
		<th>Name</th>
		<td><?php echo $student_data['name']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Department</th>
		<td><?php echo $DB->get_department_name($student_data['department_id']); ?></td>
	</tr>
	<tr class="evenRow">
		<th>Year/Semester</th>
		<td><?php echo $student_data['current_year'].'/'.$student_data['current_semester']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Phone</th>
		<td><?php echo $student_data['phone']; ?></td>
	</tr>
	<tr class="evenRow">
		<th>Email</th>
		<td><?php echo $student_data['email']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Username</th>
		<td><?php echo $student_data['username'];?></td>
	</tr>

</table>
<br>
<center>
	<h3>Are you sure to delete this Student?</h3>
	<form method="POST" action="student_add_update_server.php">
		<a href="?tab=studentManagement">
		<button type="button" class="button2 greenButton">
			<i class="fa  fa-times"></i> Cancel
		</button>
		</a>
		<button type="submit" class="button2 redButton" name="delete_student">
			<i class="fa fa-ban"></i> Yes, Delete
		</button>
	</form>
</center>