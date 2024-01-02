<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="tabBox">
	<form class="createReportForm"   method="POST" action="office_add_update_server.php">
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
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="office_id">Office ID *</label>
			</div>
			<div class="formElement">
				<input type="text" name="office_id" minlength="1" maxlength="4" placeholder="Office ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['office_id']; ?>" required>
			</div>
			<?php if(isset($_SESSION['au_office_id_error'])) {?>
			<div class="formElementError">
				<label for="office_id"><?php echo $_SESSION['au_office_id_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="office_name">Name *</label>
			</div>
			<div class="formElement">
				<input type="text" name="office_name" minlength="6" placeholder="Name of the office" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['office_name']; ?>" required>
			</div>
		</div>
		

		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="admin_head">Administrative Head</label>
			</div>
			<div class="formElement">
				<input type="text" name="admin_head" minlength="5" maxlength="5" placeholder="Administrative Head ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['admin_head']; ?>" >
			</div>
			<?php if(isset($_SESSION['au_admin_head_error'])) {?>
			<div class="formElementError">
				<label for="admin_head"><?php echo $_SESSION['au_admin_head_error']; ?></label>
			</div>
			<?php } ?>
		</div>

		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="head_officer">Head Officer</label>
			</div>
			<div class="formElement">
				<input type="text" name="head_officer" minlength="5" maxlength="5" placeholder="Head Officer ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['head_officer']; ?>" >
			</div>
			<?php if(isset($_SESSION['au_head_officer_error'])) {?>
			<div class="formElementError">
				<label for="head_officer"><?php echo $_SESSION['au_head_officer_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="office_loc">Office Location</label>
			</div>
			<div class="formElement">
				<textarea name="office_loc" minlength="3" maxlength="50" rows="3" placeholder="Office Location"><?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['office_loc']; ?></textarea>
			</div>
			
		</div>
		

	
		
		<div class="formOddRow">
			<button type="submit" class="button1" name="add_new_office">Add</button>
		</div>
		
		
	</form>
	<?php
		if(isset($_SESSION['au_old_value']))
			unset($_SESSION['au_old_value']);
		
		if(isset($_SESSION['au_office_id_error']))
			unset($_SESSION['au_office_id_error']);
		if(isset($_SESSION['au_admin_head_error']))
			unset($_SESSION['au_admin_head_error']);
		if(isset($_SESSION['au_head_officer_error']))
			unset($_SESSION['au_head_officer_error']);
		
		if(isset($_SESSION['au_success']))
			unset($_SESSION['au_success']);
		if(isset($_SESSION['au_error']))
			unset($_SESSION['au_error']);
		
		
	?>
	
</div>
<div class="clearFix"></div>