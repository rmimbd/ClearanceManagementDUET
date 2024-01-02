<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<?php
	if(!isset($_SESSION['user_filter'])){ 
		$_SESSION['user_filter']=1;
	}
	else if($_SESSION['user_filter']!=1)
		$_SESSION['user_filter']=1;	

?>
<div class="tabBox2">
	<div class="filterSection">
		<form method="POST" action="student_management_server.php">
			<button type="button" class="button2" id="user_filter_dropdown_activator">
			<?php
				if($_SESSION['user_filter']==1) {
					echo "All Student <i class=\"fa fa-filter\"></i>";	
				}
				
			?>
			</button>
			<ul class="filterList" id="user_filter_dropdown_list">
				<li><button <?php if($_SESSION['user_filter']==1) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_students">Show all Student</button></li>

			</ul>
			<a href="?tab=studentManagement&action=add">
				<button type="button" class="button2"><i class="fa fa-user-plus"></i> Add Student</button>
			</a>
		</form>
	</div>

	<div class="searchSection">
		<input type="text" id="student_search_key" name="key" placeholder="Search Here" required>
		<button type="button" name="searchReport" class="button2" id="student_search_key_submit"><i class="fa fa-search"></i></button>
	</div>
	<div class="clearFix"></div>
	<?php
	if(isset($_SESSION['user_info_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Student information updated</center>
		</div>
	<?php unset($_SESSION['user_info_updated']); 
	}?>

	<?php
	if(isset($_SESSION['au_delete_success'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center><?php echo $_SESSION['au_delete_success'];unset($_SESSION['au_delete_success']); ?></center>
		</div>
	<?php } ?>
	
	<?php
	if(isset($_SESSION['au_delete_error'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center><?php echo $_SESSION['au_delete_error'];unset($_SESSION['au_delete_error']); ?></center>
		</div>
	<?php } ?>
	

	<table class="tableOne">
		<colgroup>
    		<col span="1" style="width: 8%;">
    		<col span="1" style="width: 12%;">
    		<col span="1" style="width: 24%;">
    		<col span="1" style="width: 18%;">
    		<col span="1" style="width: 10%;">
    		<col span="1" style="width: 28%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>Student ID</th>
			<th>Name</th>
			<th>Department</th>
			<th>Year/Semester</th>
			<th>Actions</th>
		</tr>
		<?php
		if($_SESSION['user_filter']==1)
			$students = $DB->get_all_student_user_information();
		$i=1;
		while($student=mysqli_fetch_array($students)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>" id="<?php echo "user_row_".$i;?>">
			<td id="<?php echo "sl_".$i;?>"><?php echo $i; ?></td>
			<td  id="<?php echo "student_id_".$i;?>"><?php echo $student['student_id']; ?></td>
			<td id="<?php echo "name_".$i;?>"><?php echo $student['name']; ?></td>
			<td id="<?php echo "department_".$i;?>"><?php echo $DB->get_department_name($student['department_id']); ?></td>
			<td id="<?php echo "year_sem_".$i;?>"><?php echo $student['current_year'].'/'.$student['current_semester'];?></td>
			<td>
				<a href="?tab=studentManagement&action=details&student_id=<?php echo $student['student_id']; ?>">
					<button type="button" class="button2 darkBlueButton">
						<i class="fa fa-list"></i> Details
					</button>
				</a>
				
				<a href="?tab=studentManagement&action=edit&student_id=<?php echo $student['student_id']; ?>">
					<button type="button" class="button2 greenButton">
						<i class="fa fa-edit"></i> Update
					</button>
				</a>
				<a href="?tab=studentManagement&action=delete&student_id=<?php echo $student['student_id']; ?>">
					<button type="button" class="button2 redButton">
						<i class="fa  fa-trash"></i> Delete
					</button>
				</a>
				
			</td>
		</tr>
		<?php $i++;}

		if($i==1){?>
		<tr>
			<td colspan="6"><center><b>No user to show</b></center></td>
		</tr>
		<?php } ?>
		<script type="text/javascript"><?php echo "var total_row=".$i.";"?></script>
	</table>
</div>
<div class="clearFix"></div>