<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_GET['office_id'])){
		require('../include/error_alter.php');
		return;
	}
	$office_id=input_filter($_GET['office_id']);
	if(!$DB->is_valid_office_id($office_id)){
		require('../include/error_alter.php');
		return;
	}
	$office_data=$DB->get_office_data($office_id);
	$_SESSION['deleting_office_id']=$office_id;
?>

<table class="tableOne">
	<colgroup>
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 70%;">
	</colgroup>
	<tr class="oddRow">
		<th>Office ID</th>
		<td><?php echo $office_id; ?></td>
	</tr>
	<tr class="evenRow">
		<th> Office Name</th>
		<td><?php echo $office_data['office_name']; ?></td>
	</tr>

</table>
<br>
<center>
	<h3>Are you sure to delete this Office?</h3>
	<form method="POST" action="office_add_update_server.php">
		<a href="?tab=officeManagement">
		<button type="button" class="button2 greenButton">
			<i class="fa  fa-times"></i> Cancel
		</button>
		</a>
		<button type="submit" class="button2 redButton" name="delete_office">
			<i class="fa fa-ban"></i> Yes, Delete
		</button>
	</form>
</center>