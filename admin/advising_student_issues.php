<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>
<div class="tabBox2">
	
	<div class="searchSection">
		<form action="">
			<input type="text" name="key" placeholder="Search Here" required>
			<button type="submit" name="searchReport" class="button2"><i class="fa fa-search"></i> Search</button>
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