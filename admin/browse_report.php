<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<?php
	if(!isset($_SESSION['browse_report_filter']))
		$_SESSION['browse_report_filter']=1;
?>
<div class="tabBox2">
	<div class="filterSection" id="report_filter_dropdown">
		<form method="POST" action="browse_report_server.php">
			<button type="button" class="button2" id="report_filter_dropdown_activator">
			<?php
				if($_SESSION['browse_report_filter']==1) {
					echo "Only my created reports <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['browse_report_filter']==2){
					echo "All reports of the office <i class=\"fa fa-filter\"></i>";	
				}
				else{
					echo "Advising Student's Issues <i class=\"fa fa-filter\"></i>";	
				}

			?>
			</button>
			<ul class="filterList" id="report_filter_dropdown_list">
				<li><button <?php if($_SESSION['browse_report_filter']==1) echo "style=\"background-color:#123834;\""; ?> type="submit" name="only_user_created">Show only my created reports</button></li>
				<li><button <?php if($_SESSION['browse_report_filter']==2) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_of_office">Show all reports of the office</button></li>
				<?php if($DB->advising_student_available()){?>
				<li><button <?php if($_SESSION['browse_report_filter']==3) echo "style=\"background-color:#123834;\""; ?> type="submit" name="advising_student">Show Advising Student's Issues</button></li>
				<?php } ?>

			</ul>
		</form>
	</div>
	<div class="clearFix"></div>
	<table class="tableOne">
		<colgroup>
    		<col span="1" style="width: 8%;">
    		<col span="1" style="width: 12%;">
    		<col span="1" style="width: 10%;">
    		<col span="1" style="width: 35%;">
    		<col span="1" style="width: 35%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>Report ID</th>
			<th>Student ID</th>
			<th>Report Title</th>
			<th>Actions</th>
		</tr>
		<?php
		$reports=NULL;
		if($_SESSION['browse_report_filter']==1)
			$reports = $DB->get_all_reports_of_creator();
		else if($_SESSION['browse_report_filter']==2)
			$reports = $DB->get_all_reports_of_office();
		else
			$reports = $DB->get_advising_student_issues();
		$i=1;
		$num_of_reports = mysqli_num_rows($reports);
		while($report=mysqli_fetch_array($reports)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>">
			<td><?php echo $i; ?></td>
			<td><?php echo $report['report_id']; ?></td>
			<td><?php echo $report['student_id']; ?></td>
			<td><?php echo $report['title']; ?></td>
			<td>
				<a href="?tab=viewReport&report_id=<?php echo $report['report_id']; ?>"><button class="button2"><i class="fa fa-eye"></i> View</button></a>
				<?php if($DB->match_report_and_office_id($report['report_id'], $DB->current_user->office_id)){?>
				<a href="?tab=updateReport&report_id=<?php echo $report['report_id']; ?>"><button class="button2 darkBlueButton"><i class="fa fa-edit"></i> Update</button></a>
				<a href="?tab=resolveReport&report_id=<?php echo $report['report_id']; ?>"><button class="button2 greenButton"><i class="fa fa-check-square"></i> Resolve</button></a>
				<a href="?tab=deleteReport&report_id=<?php echo $report['report_id']; ?>"><button class="button2 redButton"><i class="fa fa-trash"></i> Delete</button></a>
				<?php } ?>
			</td>
		</tr>
		<?php $i++;}?>
		<?php
		if($num_of_reports==0){?>
		<tr>
			<td colspan="5"><center><b>No Report to show</b></center></td>
		</tr>
		<?php } ?>
	</table>
</div>
<div class="clearFix"></div>