<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="tabBox">
	<form class="createReportForm"   method="POST" action="create_report_server.php">
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="student_id">Student ID</label>
			</div>
			<div class="formElement">
				<input type="text" name="student_id" minlength="6" maxlength="6" placeholder="Student ID" value="<?php if(isset($_SESSION['rc_old_value'])) echo $_SESSION['rc_old_value'][0]; ?>" required>
			</div>
			<?php if(isset($_SESSION['rc_student_id_error'])) {?>
			<div class="formElementError">
				<label for="student_id"><?php echo $_SESSION['rc_student_id_error']; ?></label>
			</div>
			<?php } ?>
		</div>
		<div class="formOddRow">
			<div class="formElementTitle">
				<label for="title">Report Title</label>
			</div>
			<div class="formElement">
				<input type="text" name="title" minlength="10" placeholder="Briefe introduction about the report" value="<?php if(isset($_SESSION['rc_old_value'])) echo $_SESSION['rc_old_value'][1];?>" required>
			</div>
		</div>
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="description">Report Description</label>
			</div>
			<div class="formElement">
				<textarea type="text" name="description" rows="10" placeholder="Describe the issue" required><?php if(isset($_SESSION['rc_old_value'])) echo $_SESSION['rc_old_value'][2]; ?></textarea> 
			</div>
		</div>
		<div class="formOddRow">
			<button type="submit" class="button1" name="create_report">Submit</button>
		</div>
	</form>
	<?php
		if(isset($_SESSION['rc_old_value']))
			unset($_SESSION['rc_old_value']);
		if(isset($_SESSION['rc_student_id_error']))
			unset($_SESSION['rc_student_id_error']);
		
	?>
	<?php 
	if(isset($_SESSION['rc_report_id'])){?>
	<br>
	
	<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Report Created Successfully.<br> Report ID:<b><?php echo $_SESSION['rc_report_id'];?></b></center>
	</div>
	<br>
	<?php }
	else if(isset($_SESSION['rc_unsuccessful'])){?>
	<br>
	<div class="closable_popup error_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Error Occurred</center>
	</div>
	<br>
	<?php }
	if(isset($_SESSION['rc_report_id']))
		unset($_SESSION['rc_report_id']);
	if(isset($_SESSION['rc_unsuccessful']))
		unset($_SESSION['rc_unsuccessful']);
	
	?>
</div>
<div class="clearFix"></div>