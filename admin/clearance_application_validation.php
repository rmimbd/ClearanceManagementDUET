<?php
$application_id=NULL;
	if(!isset($_SESSION['DCMS_user'])){
		require('../include/error_alter.php');
		return;
	}
	else{
		if($DB->current_user->user_type!="admin"){
			require('../include/error_alter.php');
			return;
		}
	}
	if(isset($_POST['clearance_id_for_validation'])){
		$_SESSION['clearance_id_for_validation']=input_filter($_POST['clearance_id_for_validation']);
		header("Location: ?tab=clearanceValidation");
		return;
	}
	if(!isset($_SESSION['clearance_id_for_validation']))
		$_SESSION['clearance_id_for_validation']=NULL;

?>

<div class="singlebox">
	<br>
	<center>
		<h4>Enter Clearance Application ID</h4>
		<form class="" method="POST" action="">
			<input type="number" name="clearance_id_for_validation" id="application_validation_text_input" placeholder="Enter Application ID" value="<?php echo $_SESSION['clearance_id_for_validation']?$_SESSION['clearance_id_for_validation']:"";?>"><br><br>
			<button type="submit" class="button2">Validate</button>
		</form>
	<?php if(isset($_SESSION['clearance_id_for_validation']) && $_SESSION['clearance_id_for_validation']!=NULL) {
		if($DB->is_valid_application_id($_SESSION['clearance_id_for_validation'])){?>
			<h4 class="green_text">Application ID is valid</h4>
			<?php
			$application_data=mysqli_fetch_array($DB->get_application_data($_SESSION['clearance_id_for_validation']));
			?>
			<p>
				Applicant Name: <b><?php echo $DB->get_student_name($application_data['student_id']); ?></b><br>
				Application Status: <b><?php
											switch ($application_data['final_status']){
												case 0:
													echo "Pending";
													break;
												case 1:
													echo "Approved";
													break;
												case 2:
													echo "Declined";
													break;
											}
										?></b>
			</p>
			<a href="?tab=applicationDetails&application_id=<?php echo $_SESSION['clearance_id_for_validation']; ?>"><button type="button" class="button2 darkBlueButton"><i class="fa fa-wpforms"></i> View Details</button></a>
		<?php }
		else{?>
			<h4 class="red_text">Application ID is invalid</h4>

		<?php }} ?>
		</center>
	<br>
</div>