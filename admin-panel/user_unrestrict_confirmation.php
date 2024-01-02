<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_GET['user_id'])){
		require('../include/error_alter.php');
		return;
	}
	$user_id=input_filter($_GET['user_id']);
	if(!$DB->is_valid_admin_user($user_id)){
		require('../include/error_alter.php');
		return;
	}
	$user_data=$DB->get_all_information_of_admin($user_id);
	$_SESSION['unrestricting_user_id']=$user_id;
	if($user_data['active']!=0){
		require('../include/error_alter.php');
		return;
	}
?>

<table class="tableOne">
	<colgroup>
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 70%;">
	</colgroup>
	<tr class="oddRow">
		<th>User ID</th>
		<td><?php echo $user_data['user_id']; ?></td>
	</tr>
	<tr class="evenRow">
		<th>Name</th>
		<td><?php echo $user_data['name']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Designation</th>
		<td><?php echo $user_data['designation'];?></td>
	</tr>
	<tr class="evenRow">
		<th>Office</th>
		<td><?php echo $DB->get_office_data($user_data['office_id'])['office_name']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Phone</th>
		<td><?php echo $user_data['phone']; ?></td>
	</tr>
	<tr class="evenRow">
		<th>Email</th>
		<td><?php echo $user_data['email']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Username</th>
		<td><?php echo $user_data['username'];?></td>
	</tr>

</table>
<br>
<center>
	<h3>Are you sure to Unrestrict this user?</h3>
	<form method="POST" action="user_add_update_server.php">
		<a href="?tab=userManagement">
		<button type="button" class="button2 greenButton">
			<i class="fa  fa-times"></i> Cancel
		</button>
		</a>
		<button type="submit" class="button2" name="unrestrict_user">
			<i class="fa fa-check"></i> Yes, Unrestrict
		</button>
	</form>
</center>