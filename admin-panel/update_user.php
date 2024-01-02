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
	$_SESSION['updating_user_id']=$user_id;
?>

<div class="tabBox">
	<form class="createReportForm" style="background-color:#c1c1c1;" method="POST" action="user_add_update_server.php">
		<div class="col-2">
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="user_name">Name *</label>
				</div>
				<div class="formElement">
					<input type="text" name="user_name" minlength="6" placeholder="Name of the user" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['user_name']; else echo $user_data['name']; ?>" required>
				</div>
			</div>
			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="user_designation">Designation</label>
				</div>
				<div class="formElement">
					<input type="text" name="user_designation" minlength="3" placeholder="Enter the designation" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['user_designation']; else echo $user_data['designation'];?>">
				</div>
			</div>
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="office_id">Office *</label>
				</div>
				<div class="formElement">
					 <select name="office_id" required>
					 	<option value="-100">Select office</option>
					 	<?php
					 	$offices=$DB->get_all_office_data();
					 	while ($office=mysqli_fetch_array($offices)) {?>
					 	<option value="<?php echo $office['office_id']; ?>" <?php if(isset($_SESSION['au_old_value'])){ if ($_SESSION['au_old_value']['office_id']==$office['office_id']) echo "selected"; } else if ($user_data['office_id']==$office['office_id']) echo "selected";;?>><?php echo $office['office_name']; ?></option>
					 	<?php } ?>
					 </select>
				</div>
				<?php if(isset($_SESSION['au_office_id_error'])) {?>
				<div class="formElementError">
					<label for="office_id"><?php echo $_SESSION['au_office_id_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			
			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="user_email">Email</label>
				</div>
				<div class="formElement">
					<input type="email" name="user_email" minlength="6" placeholder="Email Address" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['user_email'];else echo $user_data['email'];?>">
				</div>
				<?php if(isset($_SESSION['au_email_error'])) {?>
				<div class="formElementError">
					<label for="user_email"><?php echo $_SESSION['au_email_error']; ?></label>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="col-2">
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="user_phone">Phone</label>
				</div>
				<div class="formElement">
					<input type="text" name="user_phone" minlength="6" placeholder="Phone" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['user_phone']; else echo $user_data['phone'];?>">
				</div>
				<?php if(isset($_SESSION['au_phone_error'])) {?>
				<div class="formElementError">
					<label for="user_phone"><?php echo $_SESSION['au_phone_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			
			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="user_username">Username</label>
				</div>
				<div class="formElement">
					<input type="text" name="user_username" minlength="6" placeholder="Username" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['user_username'];else echo $user_data['username'];?>">
				</div>
				<?php if(isset($_SESSION['au_username_error'])) {?>
				<div class="formElementError">
					<label for="user_username"><?php echo $_SESSION['au_username_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="user_password">Reset Password</label>
				</div>
				<div class="formElement">
					<input type="text" name="user_password" minlength="6" placeholder="New Password" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['user_password'];?>">
				</div>
			</div>
		</div>
		<div class="clearFix"></div>
		<div class="formOddRow">
			<button type="submit" class="button1" name="update_user_data">Update</button>
		</div>
		<?php if(isset($_SESSION['au_success'])) {?>
		<div class="formEvenRow">
			<div class="closable_popup" id="popup">
			<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
			<center><?php echo $_SESSION['au_success'];?></center>
			</div>
		</div>
		<?php }
		else if(isset($_SESSION['au_error'])) {?>
		<div class="formEvenRow">
			<div class="closable_popup" id="popup">
			<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
			<center><?php echo $_SESSION['au_error'];?></center>
			</div>
		</div>
		<?php } ?>
		
	</form>
	<?php
		if(isset($_SESSION['au_old_value']))
			unset($_SESSION['au_old_value']);
		if(isset($_SESSION['au_office_id_error']))
			unset($_SESSION['au_office_id_error']);
		if(isset($_SESSION['au_username_error']))
			unset($_SESSION['au_username_error']);
		if(isset($_SESSION['au_email_error']))
			unset($_SESSION['au_email_error']);
		if(isset($_SESSION['au_phone_error']))
			unset($_SESSION['au_phone_error']);
		if(isset($_SESSION['au_success']))
			unset($_SESSION['au_success']);
		if(isset($_SESSION['au_error']))
			unset($_SESSION['au_error']);
		
	?>

</div>
<div class="clearFix"></div>