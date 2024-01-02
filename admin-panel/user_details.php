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
<?php if(isset($_SESSION['au_success'])) {?>
<br>
<div>
	<div class="closable_popup" id="popup">
	<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
	<center><?php echo $_SESSION['au_success'];?></center>
	</div>
</div>
<?php unset($_SESSION['au_success']);}?>
<br>
<center>
	<a href="?tab=userManagement&action=edit&user_id=<?php echo $user_data['user_id']; ?>">
		<button type="button" class="button2 greenButton">
			<i class="fa fa-edit"></i> Update
		</button>
	</a>
	<?php if($user_data['active']==1) {?>
	<a href="?tab=userManagement&action=delete&user_id=<?php echo $user_data['user_id']; ?>">
		<button type="button" class="button2 redButton">
			<i class="fa fa-ban"></i> Restrict
		</button>
	</a>
	<?php } ?>
	<?php if($user_data['active']==0) {?>
	<a href="?tab=userManagement&action=unrestrict&user_id=<?php echo $user_data['user_id']; ?>">
		<button type="button" class="button2 redButton">
			<i class="fa fa-circle"></i> Unrestrict
		</button>
	</a>
	<?php } ?>
	
</center>