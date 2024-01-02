<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<br>
<?php if(isset($_SESSION['rc_report_update_success'])){?>
	<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Report Updated</center>
	</div>
<?php
	unset($_SESSION['rc_report_update_success']);
}?>

<div class="singlebox">
		<?php
		if(isset($_GET['report_id'])){
			$report_id = input_filter($_GET['report_id']);
			if($DB->is_valid_report_id($report_id)){
				$report_data=$DB->get_report_data($report_id);
				if($DB->match_report_and_office_id($report_id, $DB->current_user->office_id) || $DB->match_student_and_advisor($report_data['student_id'],$DB->current_user->user_id)){?>
		<table class="reportView">
			<colgroup>
	    		<col span="1" style="width: 30%;">
	    		<col span="1" style="width: 70%;">
	    	</colgroup>
			<tr class="oddRow">
				<th>Report ID</th>
				<td><?php echo $report_data['report_id'];?></td>
			</tr>
			<tr class="evenRow">
				<th>Report Against</th>
				<td><?php echo $report_data['student_id'];?></td>
			</tr>
			<tr class="oddRow">
				<th>Issued From</th>
				<td><?php $office=$DB->get_office_data($report_data['issuer_office']);
				echo $office['office_name']."<br>".$office['office_loc'];?></td>
			</tr>
			
			<tr class="evenRow">
				<th>Issued By</th>
				<td><?php $issuer=$DB->get_admin_data($report_data['issuer']);
				echo $issuer['name']."<br>".$issuer['designation']."<br>".$office['office_name'];?></td>
			</tr>
			<tr class="oddRow">
				<th>Issue Date & Time</th>
				<td><?php echo $report_data['issue_date'];?></td>
			</tr>
			
			<tr class="evenRow">
				<th>Title</th>
				<td><?php echo $report_data['title'];?></td>
			</tr>
			<tr class="oddRow">
				<th>Description</th>
				<td><?php echo $report_data['description'];?></td>
			</tr>
			<tr class="evenRow">
				<th>Status</th>
				<td><?php switch($report_data['report_status']){
					case 1:
						echo "Active";
						break;
					case 2:
						echo "Resolved";
						break;
					case 3:
						echo "Deleted";
						break;
				}?></td>
			</tr>
			<?php if($DB->match_report_and_office_id($report_id, $DB->current_user->office_id)) {?>
			<tr class="oddRow">
				<th>Action</th>
				<td>
					<?php if($report_data['report_status']==1) {?>
						<a href="?tab=updateReport&report_id=<?php echo $report_data['report_id']; ?>"><button class="button2 darkBlueButton"><i class="fa fa-edit"></i> Update</button></a>
					<?php }
						if($report_data['report_status']<2) {?>
						<a href="?tab=resolveReport&report_id=<?php echo $report_data['report_id']; ?>"><button class="button2 greenButton"><i class="fa fa-check-square"></i> Resolve</button></a>
					<?php }
						if($report_data['report_status']<3) {?>
						<a href="?tab=deleteReport&report_id=<?php echo $report_data['report_id']; ?>"><button class="button2 redButton"><i class="fa fa-trash"></i> Delete</button></a>
					<?php }
					else{
						echo "No action to perform.";
					}?>

				</td>
			</tr>
			<?php } ?>
		</table>
		<?php }
			else
				echo "<br><br><center><p class=\"unsuccessMessage\">Invalid Access Request</p></center><br><br>";
		}
		else
			echo "<br><br><center><p class=\"unsuccessMessage\">Invalid Report ID</p></center><br><br>";
		}
		else
			header("Location: ../admin/");
		?>
</div>
<br>
<center>
	<a href="?tab=browseReport"><button class="button2">
		<i class="fa fa-arrow-circle-left"></i> Go Back
	</button></a>
</center>
