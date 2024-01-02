<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="tabBox">
	<form class="createReportForm"  style="background-color:#c1c1c1;"  method="POST" action="student_add_update_server.php">
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
		
		<div class="col-2">

			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="student_id">Student ID *</label>
				</div>
				<div class="formElement">
					<input type="text" name="student_id" minlength="6" maxlength="6" placeholder="Student ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['student_id']; ?>" required>
				</div>
				<?php if(isset($_SESSION['au_student_id_error'])) {?>
				<div class="formElementError">
					<label for="student_id"><?php echo $_SESSION['au_student_id_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="student_name">Name *</label>
				</div>
				<div class="formElement">
					<input type="text" name="student_name" minlength="6" placeholder="Name of the student" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['student_name']; ?>" required>
				</div>
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
					<label for="year_semester">Year/Semester *</label>
				</div>
				<div class="formElement">
					 <select name="year_semester" required>
					 	<option value="0">Select Year/Semester</option>
					 	<option value="12" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==12) echo "selected";?>>1st Year, 2nd Semester</option>
					 	<option value="21" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==21) echo "selected";?>>2nd Year, 1st Semester</option>
					 	<option value="22" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==22) echo "selected";?>>2nd Year, 2nd Semester</option>
					 	<option value="31" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==31) echo "selected";?>>3rd Year, 1st Semester</option>
					 	<option value="32" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==32) echo "selected";?>>3rd Year, 2nd Semester</option>
					 	<option value="41" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==41) echo "selected";?>>4th Year, 1st Semester</option>
					 	<option value="42" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==42) echo "selected";?>>4th Year, 2nd Semester</option>
					 	<option value="51" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==51) echo "selected";?>>5th Year, 1st Semester</option>
					 	<option value="52" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['year_semester']==52) echo "selected";?>>5th Year, 2nd Semester</option>
					 </select>
				</div>
				<?php if(isset($_SESSION['au_year_semester_error'])) {?>
				<div class="formElementError">
					<label for="year_semester"><?php echo $_SESSION['au_year_semester_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="session">Session</label>
				</div>
				<div class="formElement">
					<input type="text" name="session" minlength="9" maxlength="9" placeholder="Session" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['session']; ?>">
				</div>
				<?php if(isset($_SESSION['au_session_error'])) {?>
				<div class="formElementError">
					<label for="session"><?php echo $_SESSION['au_session_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			
			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="admission_year">Admission Year *</label>
				</div>
				<div class="formElement">
					<input type="text" name="admission_year" minlength="4" maxlength="4" placeholder="Admission Year" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['admission_year']; ?>" required>
				</div>
				<?php if(isset($_SESSION['au_admission_year_error'])) {?>
				<div class="formElementError">
					<label for="admission_year"><?php echo $_SESSION['au_admission_year_error']; ?></label>
				</div>
				<?php } ?>
			</div>

			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="advisor">Advisor</label>
				</div>
				<div class="formElement">
					<input type="text" name="advisor" minlength="5" maxlength="5" placeholder="Advisor User ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['advisor']; ?>" >
				</div>
				<?php if(isset($_SESSION['au_advisor_error'])) {?>
				<div class="formElementError">
					<label for="advisor"><?php echo $_SESSION['au_advisor_error']; ?></label>
				</div>
				<?php } ?>
			</div>

			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="thesis_supervisor">Thesis Supervisor</label>
				</div>
				<div class="formElement">
					<input type="text" name="thesis_supervisor" minlength="5" maxlength="5" placeholder="Thesis Supervisor User ID" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['thesis_supervisor']; ?>" >
				</div>
				<?php if(isset($_SESSION['au_thesis_supervisor_error'])) {?>
				<div class="formElementError">
					<label for="thesis_supervisor"><?php echo $_SESSION['au_thesis_supervisor_error']; ?></label>
				</div>
				<?php } ?>
			</div>

		</div>

		<div class="col-2">

			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="gender">Gender *</label>
				</div>
				<div class="formElement">
					 <select name="gender" required>
					 	<option value="0">Select Gender</option>
					 	<option value="1" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['gender']==1) echo "selected";?>>Male</option>
					 	<option value="2" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['gender']==2) echo "selected";?>>Female</option>
					 </select>
				</div>
				<?php if(isset($_SESSION['au_gender_error'])) {?>
				<div class="formElementError">
					<label for="gender"><?php echo $_SESSION['au_gender_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			
			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="hall_id">Hall</label>
				</div>
				<div class="formElement">
					 <select name="hall_id">
					 	<option value="0">Select Hall</option>
					 	<?php
					 	$halls=$DB->get_all_hall_data();
					 	while ($hall=mysqli_fetch_array($halls)) {?>
					 	<option value="<?php echo $hall['hall_id']; ?>" <?php if(isset($_SESSION['au_old_value'])) if ($_SESSION['au_old_value']['hall_id']==$hall['hall_id']) echo "selected";?>><?php echo $hall['name']; ?></option>
					 	<?php } ?>
					 </select>
				</div>
				<?php if(isset($_SESSION['au_hall_id_error'])) {?>
				<div class="formElementError">
					<label for="hall_id"><?php echo $_SESSION['au_hall_id_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="hall_room_no">Hall Room No</label>
				</div>
				<div class="formElement">
					<input type="text" name="hall_room_no" minlength="3" maxlength="5" placeholder="Hall Room Number" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['hall_room_no']; ?>" >
				</div>
				<?php if(isset($_SESSION['au_hall_room_no_error'])) {?>
				<div class="formElementError">
					<label for="hall_room_no"><?php echo $_SESSION['au_hall_room_no_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			

			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="student_email">Email</label>
				</div>
				<div class="formElement">
					<input type="email" name="student_email" minlength="8" placeholder="Email Address" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['student_email'];?>">
				</div>
				<?php if(isset($_SESSION['au_email_error'])) {?>
				<div class="formElementError">
					<label for="student_email"><?php echo $_SESSION['au_email_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="student_phone">Phone</label>
				</div>
				<div class="formElement">
					<input type="text" name="student_phone" minlength="11" placeholder="Phone Number" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['student_phone'];?>">
				</div>
				<?php if(isset($_SESSION['au_phone_error'])) {?>
				<div class="formElementError">
					<label for="student_phone"><?php echo $_SESSION['au_phone_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			
			<div class="formOddRow">
				<div class="formElementTitle">
					<label for="student_username">Username</label>
				</div>
				<div class="formElement">
					<input type="text" name="student_username" minlength="6" placeholder="Username" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['student_username'];?>">
				</div>
				<?php if(isset($_SESSION['au_username_error'])) {?>
				<div class="formElementError">
					<label for="student_username"><?php echo $_SESSION['au_username_error']; ?></label>
				</div>
				<?php } ?>
			</div>
			<div class="formEvenRow">
				<div class="formElementTitle">
					<label for="student_password">Default Password</label>
				</div>
				<div class="formElement">
					<input type="text" name="student_password" minlength="6" placeholder="Default Password" value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['student_password'];?>">
				</div>
			</div>

		</div>

		<div class="clearFix"></div>
		
		<div class="formOddRow">
			<button type="submit" class="button1" name="add_new_student">Add</button>
		</div>
		
		
	</form>
	<?php
		if(isset($_SESSION['au_old_value']))
			unset($_SESSION['au_old_value']);
		if(isset($_SESSION['au_student_id_error']))
			unset($_SESSION['au_student_id_error']);
		if(isset($_SESSION['au_department_id_error']))
			unset($_SESSION['au_department_id_error']);
		if(isset($_SESSION['au_year_semester_error']))
			unset($_SESSION['au_year_semester_error']);
		if(isset($_SESSION['au_session_error']))
			unset($_SESSION['au_session_error']);
		if(isset($_SESSION['au_admission_year_error']))
			unset($_SESSION['au_admission_year_error']);
		if(isset($_SESSION['au_advisor_error']))
			unset($_SESSION['au_advisor_error']);
		if(isset($_SESSION['au_thesis_supervisor_error']))
			unset($_SESSION['au_thesis_supervisor_error']);
		if(isset($_SESSION['au_gender_error']))
			unset($_SESSION['au_gender_error']);
		if(isset($_SESSION['au_hall_id_error']))
			unset($_SESSION['au_hall_id_error']);
		if(isset($_SESSION['au_hall_room_no_error']))
			unset($_SESSION['au_hall_room_no_error']);
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