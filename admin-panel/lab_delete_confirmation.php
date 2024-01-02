<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_GET['lab_id'])){
		require('../include/error_alter.php');
		return;
	}
	$lab_id=input_filter($_GET['lab_id']);
	if(!$DB->is_valid_lab_id($lab_id)){
		require('../include/error_alter.php');
		return;
	}
	$lab_data=$DB->get_all_information_of_lab($lab_id);
	$_SESSION['deleting_lab_id']=$lab_id;
?>

<table class="tableOne">
	<colgroup>
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 70%;">
	</colgroup>
	<tr class="oddRow">
		<th>Lab ID</th>
		<td><?php echo $lab_id; ?></td>
	</tr>
	<tr class="evenRow">
		<th>Name</th>
		<td><?php echo $lab_data['name']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Department</th>
		<td><?php echo $DB->get_department_name($lab_data['department']); ?></td>
	</tr>
</table>
<br>
<center>
	<h3>Are you sure to delete this Lab?</h3>
	<form method="POST" action="lab_add_update_server.php">
		<a href="?tab=labManagement">
		<button type="button" class="button2 greenButton">
			<i class="fa  fa-times"></i> Cancel
		</button>
		</a>
		<button type="submit" class="button2 redButton" name="delete_lab">
			<i class="fa fa-ban"></i> Yes, Delete
		</button>
	</form>
</center>