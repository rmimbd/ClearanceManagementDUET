<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="tabBox">
	<?php
	if(isset($_GET['report_id'])){
		$report_id = input_filter($_GET['report_id']);
		if($DB->is_valid_report_id($report_id)){
			$report_data=$DB->get_report_data($report_id);
			if($DB->match_report_and_office_id($report_id, $DB->current_user->office_id)){
				if($report_data['report_status']<3){
					$_SESSION['ru_report_id']=$report_id;
		?>
	<form class="createReportForm"  method="POST" action="mark_report_deleted_server.php">
		<div class="formOddRow">
			<div class="formElementTitle">
				<label>Report ID</label>
			</div>
			<div class="formElement" style="padding: 10px;">
				<?php echo $report_data['report_id'];?>
			</div>
		</div>
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label>Student ID</label>
			</div>
			<div class="formElement" style="padding: 10px;">
				<?php echo $report_data['student_id'];?>
			</div>
		</div>
		<div class="formOddRow">
			<div class="formElementTitle">
				<label>Issued From</label>
			</div>
			<div class="formElement" style="padding: 10px;">
				<?php $office=$DB->get_office_data($report_data['issuer_office']);
				echo $office['office_name']."<br>".$office['office_loc'];?>
			</div>
		</div>
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label>Issued By</label>
			</div>
			<div class="formElement" style="padding: 10px;">
				<?php $issuer=$DB->get_admin_data($report_data['issuer']);
				echo $issuer['name']."<br>".$issuer['designation']."<br>".$office['office_name'];?>
			</div>
		</div>
		<div class="formOddRow">
			<div class="formElementTitle">
				<label>Report Title</label>
			</div>
			<div class="formElement">
				<?php echo $report_data['title'];?>
			</div>
		</div>
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label>Report Description</label>
			</div>
			<div class="formElement">
				<?php echo $report_data['description'];?>
			</div>
		</div>
		<div class="formOddRow">
			<center>
			<strong><br>Are you sure to delete this report?<br></strong>
			<br>
			<button type="submit" class="button2 redButton" name="mark_delete_report">Delete</button> 
			<a href="../admin/?tab=browseReport"><button type="button" class="button2 greenButton">Cancel</button></a>
			</center>
		</div>
	</form>
	<?php
			}
			else{
				echo "<br><br><center><p class=\"unsuccessMessage\">This report is not available.</p></center><br><br>";
			}
		}
		else
			echo "<br><br><center><p class=\"unsuccessMessage\">Invalid Access Request</p></center><br><br>";
		}
		else
			echo "<br><br><center><p class=\"unsuccessMessage\">Invalid Report ID</p></center><br><br>";
		}
		else
			header("Location: ../admin/");
		?>
	<?php 
	if(isset($_SESSION['ru_unsuccessful'])){?>
	<br>
	<div class="unsuccessMessage">Error Occurred.</div>
	<br>
	<?php }
	if(isset($_SESSION['ru_unsuccessful']))
		unset($_SESSION['ru_unsuccessful']);
	
	?>
</div>
<br>
<div class="clearFix"></div>