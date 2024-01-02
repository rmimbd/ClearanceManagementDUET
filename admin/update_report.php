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
				if($report_data['report_status']<2){
					$_SESSION['ru_report_id']=$report_id;
		?>
	<form class="createReportForm"   method="POST" action="update_report_server.php">
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
				<label for="title">Report Title</label>
			</div>
			<div class="formElement">
				<input type="text" name="title" minlength="10" placeholder="Briefe introduction about the report" value="<?php echo $report_data['title'];?>" required>
			</div>
		</div>
		<div class="formEvenRow">
			<div class="formElementTitle">
				<label for="description">Report Description</label>
			</div>
			<div class="formElement">
				<textarea type="text" name="description" rows="10" placeholder="Describe the issue" required><?php echo $report_data['description'];?></textarea> 
			</div>
		</div>
		<div class="formOddRow">
			<button type="submit" class="button1" name="update_report">Update</button>
		</div>
	</form>
	<?php
			}
			else{
				echo "<br><br><center><p class=\"unsuccessMessage\">This report is not permitted for edit.</p></center><br><br>";
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
<center>
	<a href="?tab=browseReport"><button class="button2">
		<i class="fa fa-arrow-circle-left"></i> Go Back
	</button></a>
</center>
<div class="clearFix"></div>