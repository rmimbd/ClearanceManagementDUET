<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="tabBox">
	<form class="createReportForm"   method="POST" action="lab_add_update_server.php">
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
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="lab_name">Lab Name *</label>
			</div>
			<div class="formElement">
				<input type="text" name="lab_name" minlength="6" placeholder="Name of the Lab" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['lab_name']; ?>" required>
			</div>
			<?php if(isset($_SESSION['au_lab_name_error'])) {?>
			<div class="formElementError">
				<label for="lab_name"><?php echo $_SESSION['au_lab_name_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="department_id">Department *</label>
			</div>
			<div class="formElement">
				 <select name="department_id" required>
				 	<option value="0">Select Department</option>
				 	<?php
				 	$departments=$DB->get_all_department_data();
				 	while ($department=mysqli_fetch_array($departments)) {?>
				 	<option value="<?php echo $department['department_id']; ?>" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['department_id']==$department['department_id']) echo "selected";?>><?php echo $department['department_name']; ?></option>
				 	<?php } ?>
				 </select>
			</div>
			<?php if(isset($_SESSION['au_department_id_error'])) {?>
			<div class="formElementError">
				<label for="department_id"><?php echo $_SESSION['au_department_id_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="lab_assistant">Lab Assistant</label>
			</div>
			<div class="formElement">
				<input type="text" name="lab_assistant" minlength="5" maxlength="5" placeholder="Lab Assistant User ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['lab_assistant']; ?>" >
			</div>
			<?php if(isset($_SESSION['au_lab_assistant_error'])) {?>
			<div class="formElementError">
				<label for="lab_assistant"><?php echo $_SESSION['au_lab_assistant_error']; ?></label>
			</div>
			<?php } ?>
		</div>

		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="lab_incharge">Lab In Charge</label>
			</div>
			<div class="formElement">
				<input type="text" name="lab_incharge" minlength="5" maxlength="5" placeholder="Lab In Charge User ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['lab_incharge']; ?>" >
			</div>
			<?php if(isset($_SESSION['au_lab_incharge_error'])) {?>
			<div class="formElementError">
				<label for="lab_incharge"><?php echo $_SESSION['au_lab_incharge_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		
		<div class="formOddRow">
			<button type="submit" class="button1" name="add_new_lab">Add</button>
		</div>
		
		
	</form>
	<?php
		if(isset($_SESSION['au_old_value']))
			unset($_SESSION['au_old_value']);
		
		if(isset($_SESSION['au_lab_name_error']))
			unset($_SESSION['au_lab_name_error']);
		
		if(isset($_SESSION['au_department_id_error']))
			unset($_SESSION['au_department_id_error']);
		
		if(isset($_SESSION['au_lab_assistant_error']))
			unset($_SESSION['au_lab_assistant_error']);
		if(isset($_SESSION['au_lab_incharge_error']))
			unset($_SESSION['au_lab_incharge_error']);
		
		if(isset($_SESSION['au_success']))
			unset($_SESSION['au_success']);
		if(isset($_SESSION['au_error']))
			unset($_SESSION['au_error']);
		
		
	?>
	
</div>
<div class="clearFix"></div>