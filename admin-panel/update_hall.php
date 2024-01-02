<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_GET['hall_id'])){
		require('../include/error_alter.php');
		return;
	}
	$hall_id=input_filter($_GET['hall_id']);
	if(!$DB->is_valid_hall_id($hall_id)){
		require('../include/error_alter.php');
		return;
	}
	$hall_data=$DB->get_hall_info($hall_id);
	$_SESSION['updating_hall_id']=$hall_id;
?>

<div class="tabBox">
	<form class="createReportForm"   method="POST" action="hall_add_update_server.php">
		<?php if(isset($_SESSION['au_error'])) {?>
		<div class="formEvenRow">
			<div class="closable_popup" id="popup">
			<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
			<center><?php echo $_SESSION['au_error'];?></center>
			</div>
		</div>
		<?php } ?>
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="hall_id">Hall ID *</label>
			</div>
			<div class="formElement">
				<input type="text" minlength="0" maxlength="0" placeholder="<?php echo $hall_id;?>" disabled>
			</div>
		</div>
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="hall_name">Name *</label>
			</div>
			<div class="formElement">
				<input type="text" name="hall_name" minlength="6" placeholder="Name of the Hall" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['hall_name']; else echo $hall_data['name'];?>" required>
			</div>
			<?php if(isset($_SESSION['au_hall_name_error'])) {?>
			<div class="formElementError">
				<label for="hall_name"><?php echo $_SESSION['au_hall_name_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="hall_short_name">Short Name *</label>
			</div>
			<div class="formElement">
				<input type="text" name="hall_short_name" minlength="6" placeholder="Name of the Hall" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['hall_short_name'];  else echo $hall_data['short_name']; ?>" required>
			</div>
			<?php if(isset($_SESSION['au_hall_short_name_error'])) {?>
			<div class="formElementError">
				<label for="hall_name"><?php echo $_SESSION['au_hall_short_name_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		

		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="provost">Provost</label>
			</div>
			<div class="formElement">
				<input type="text" name="provost" minlength="5" maxlength="5" placeholder="Provost ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['provost']; else echo $hall_data['provost']; ?>" >
			</div>
			<?php if(isset($_SESSION['au_provost_error'])) {?>
			<div class="formElementError">
				<label for="provost"><?php echo $_SESSION['au_provost_error']; ?></label>
			</div>
			<?php } ?>
		</div>

		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="a_provost_1">Assistant Provost 1</label>
			</div>
			<div class="formElement">
				<input type="text" name="a_provost_1" minlength="5" maxlength="5" placeholder="Assistant Provost 1 ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['a_provost_1']; else echo $hall_data['a_provost1']; ?>" >
			</div>
			<?php if(isset($_SESSION['au_a_provost_1_error'])) {?>
			<div class="formElementError">
				<label for="a_provost_1"><?php echo $_SESSION['au_a_provost_1_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="a_provost_2">Assistant Provost 2</label>
			</div>
			<div class="formElement">
				<input type="text" name="a_provost_2" minlength="5" maxlength="5" placeholder="Assistant Provost 2 ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['a_provost_2']; else echo $hall_data['a_provost2'];?>" >
			</div>
			<?php if(isset($_SESSION['au_a_provost_2_error'])) {?>
			<div class="formElementError">
				<label for="a_provost_2"><?php echo $_SESSION['au_a_provost_2_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="a_provost_3">Assistant Provost 3</label>
			</div>
			<div class="formElement">
				<input type="text" name="a_provost_3" minlength="5" maxlength="5" placeholder="Assistant Provost 3 ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['a_provost_3'];  else echo $hall_data['a_provost3'];?>" >
			</div>
			<?php if(isset($_SESSION['au_a_provost_3_error'])) {?>
			<div class="formElementError">
				<label for="a_provost_3"><?php echo $_SESSION['au_a_provost_3_error']; ?></label>
			</div>
			<?php } ?>
		</div>

	
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="a_provost_4">Assistant Provost 4</label>
			</div>
			<div class="formElement">
				<input type="text" name="a_provost_4" minlength="5" maxlength="5" placeholder="Assistant Provost 4 ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['a_provost_4'];  else echo $hall_data['a_provost4'];?>" >
			</div>
			<?php if(isset($_SESSION['au_a_provost_4_error'])) {?>
			<div class="formElementError">
				<label for="a_provost_4"><?php echo $_SESSION['au_a_provost_4_error']; ?></label>
			</div>
			<?php } ?>
		</div>

	
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="hall_assistant">Hall Assistant</label>
			</div>
			<div class="formElement">
				<input type="text" name="hall_assistant" minlength="5" maxlength="5" placeholder="Hall Assistant ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['hall_assistant'];  else echo $hall_data['a_section_officer'];?>" >
			</div>
			<?php if(isset($_SESSION['au_hall_assistant_error'])) {?>
			<div class="formElementError">
				<label for="hall_assistant"><?php echo $_SESSION['au_hall_assistant_error']; ?></label>
			</div>
			<?php } ?>
		</div>

	
		
		<div class="formOddRow">
			<button type="submit" class="button1" name="update_hall_data">Update</button>
		</div>
		
		
	</form>
	<?php
		if(isset($_SESSION['au_old_value']))
			unset($_SESSION['au_old_value']);
		if(isset($_SESSION['au_hall_name_error']))
			unset($_SESSION['au_hall_name_error']);
		if(isset($_SESSION['au_hall_short_name_error']))
			unset($_SESSION['au_hall_short_name_error']);
		if(isset($_SESSION['au_provost_error']))
			unset($_SESSION['au_provost_error']);
		if(isset($_SESSION['au_a_provost_1_error']))
			unset($_SESSION['au_a_provost_1_error']);
		if(isset($_SESSION['au_a_provost_2_error']))
			unset($_SESSION['au_a_provost_2_error']);
		if(isset($_SESSION['au_a_provost_3_error']))
			unset($_SESSION['au_a_provost_3_error']);
		if(isset($_SESSION['au_a_provost_4_error']))
			unset($_SESSION['au_a_provost_4_error']);
		if(isset($_SESSION['au_hall_assistant_error']))
			unset($_SESSION['au_hall_assistant_error']);
		if(isset($_SESSION['au_success']))
			unset($_SESSION['au_success']);
		if(isset($_SESSION['au_error']))
			unset($_SESSION['au_error']);
	?>
	
</div>
<div class="clearFix"></div>