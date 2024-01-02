<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<table class="tableOne">
	<colgroup>
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 70%;">
	</colgroup>
	<tr class="oddRow">
		<th>Name</th>
		<td><?php echo $DB->current_user->name; ?></td>
	</tr>
	<tr class="evenRow">
		<th>User ID</th>
		<td><?php echo $DB->current_user->user_id; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Designation</th>
		<td><?php echo $DB->current_user->designation;?></td>
	</tr>
	<tr class="evenRow">
		<th>Office</th>
		<td><?php echo $DB->get_office_data($DB->current_user->office_id)['office_name']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Phone</th>
		<td><?php echo $DB->current_user->phone ?></td>
	</tr>
	<tr class="evenRow">
		<th>Email</th>
		<td><?php echo $DB->current_user->email; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Username</th>
		<td><?php echo $DB->current_user->username;?></td>
	</tr>

</table>