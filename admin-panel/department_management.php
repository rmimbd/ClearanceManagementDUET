<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_SESSION['updating_department_id']) && !isset($_SESSION['deleting_department_id'])){
		unset($_SESSION['au_old_value']);
	}
?>

<div class="tabBox2">
	<?php
	if(isset($_SESSION['department_info_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Department information updated</center>
		</div>
	<?php unset($_SESSION['department_info_updated']); 
	}?>

	<?php
	if(isset($_SESSION['au_success'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center><?php echo $_SESSION['au_success'];unset($_SESSION['au_success']); ?></center>
		</div>
	<?php } ?>
	
	<?php
	if(isset($_SESSION['au_error'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center><?php echo $_SESSION['au_error'];unset($_SESSION['au_error']); ?></center>
		</div>
	<?php } ?>
	
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
    		<col span="1" style="width: 15%;">
    		<col span="1" style="width: 20%;">
    		<col span="1" style="width: 20%;">
    		<col span="1" style="width: 25%;">
    		<col span="1" style="width: 20%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Department ID</th>
			<th>Department Name</th>
			<th>Number of Students</th>
			<th>Number of Teachers & Staffs</th>
			<th>Actions</th>
		</tr>
		<?php
		
		$departments = $DB->get_all_department_data();
		$i=1;
		while($department=mysqli_fetch_array($departments)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>">
			<td><?php echo $department['department_id']; ?></td>
			<td><?php echo $department['department_name']; ?></td>
			<td><?php $number_of_student=$DB->get_number_of_students_of_department($department['department_id']); echo $number_of_student;?></td>
			<td><?php $number_of_admin=$DB->get_number_of_admin_of_department($department['department_id']); echo $number_of_admin;?></td>
			<td>
				<a href="?tab=departmentManagement&action=edit&department_id=<?php echo $department['department_id']; ?>">
					<button type="button" class="button2 greenButton">
						<i class="fa fa-edit"></i> Update
					</button>
				</a>
				<?php if($number_of_student==0 && $number_of_admin==0) {?>
				<a href="?tab=departmentManagement&action=delete&department_id=<?php echo $department['department_id']; ?>">
					<button type="button" class="button2 redButton">
						<i class="fa  fa-trash"></i> Delete
					</button>
				</a>
				<?php } ?>
				
			</td>
		</tr>
		<?php $i++;}

		if($i==1){?>
		<tr>
			<td colspan="6"><center><b>No Department to show</b></center></td>
		</tr>
		<?php } ?>

	</table>
</div>
<br>
<?php if(!isset($_GET['action'])) {?>
<center><a href="?tab=departmentManagement&action=add">
	<button type="button" class="button2"><i class="fa fa-plus-square"></i> Add Department</button></a>
</center>
<?php unset($_SESSION['au_old_value']); ?>
<?php } else if($_GET['action']=='add'){?>

<div class="col-2" style="float:none; display: block;">
	<div class="box">
		<div class="boxTitle">
			<h3 style="text-align:center;">Add New Department</h3>
		</div>
		<div class="boxContent">
			<form class="createReportForm" method="POST" action="department_management_server.php">
				<input type="text" name="department_id" minlength="1" maxlength="2" placeholder="Enter Department ID" 
				value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['department_id']; ?>" required>
				<?php if(isset($_SESSION['au_department_id_error'])) {?>
				<label style="color:maroon;font-weight: bold;"><?php echo '**'.$_SESSION['au_department_id_error']; ?></label>
				<?php unset($_SESSION['au_department_id_error']);} ?>
				<input type="text" name="department_name" minlength="2" maxlength="20" placeholder="Enter Department Name" 
				value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['department_name']; ?>" required>
				<?php if(isset($_SESSION['au_department_name_error'])) {?>
				<label style="color:maroon;font-weight: bold;"><?php echo '**'.$_SESSION['au_department_name_error']; ?></label>
				<?php unset($_SESSION['au_department_name_error']);} ?>
				<center><button type="submit" class="button2" name="add_department">Add</button></center>
			</form>
		</div>
	</div>
</div>

<?php } else if($_GET['action']=='edit' && isset($_GET['department_id'])){?>
<?php
$department_id=input_filter($_GET['department_id']);
$_SESSION['updating_department_id']=$department_id;
if($DB->is_valid_department_id($department_id)){
	$department_name=$DB->get_department_name($department_id);
?>
<div class="col-2" style="float:none; display: block;">
	<div class="box">
		<div class="boxTitle">
			<h3 style="text-align:center;">Update Department</h3>
		</div>
		<div class="boxContent">
			<form class="createReportForm" method="POST" action="department_management_server.php">
				<input type="text" minlength="0" maxlength="0" placeholder="<?php echo $department_id; ?>" disabled>
				<input type="text" name="department_name" minlength="2" maxlength="20" placeholder="Enter Department Name" 
				value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['department_name']; else echo $department_name; ?>" required>
				<?php if(isset($_SESSION['au_department_name_error'])) {?>
				<label style="color:maroon;font-weight: bold;"><?php echo '**'.$_SESSION['au_department_name_error']; ?></label>
				<?php unset($_SESSION['au_department_name_error']);} ?>
				<center><button type="submit" class="button2" name="update_department">Update</button></center>
			</form>
		</div>
	</div>
</div>

<?php }
else
	echo "<center><h3>Invalid Department ID</h3></center>";
}
else if($_GET['action']=='delete' && isset($_GET['department_id'])){?>
<?php
$department_id=input_filter($_GET['department_id']);
if($DB->is_valid_department_id($department_id)){ 
	$number_of_student=$DB->get_number_of_students_of_department($department_id);
	$number_of_admin=$DB->get_number_of_admin_of_department($department_id);
	if($number_of_student==0 && $number_of_admin==0){
		$_SESSION['deleting_department_id']=$department_id;?>
<div class="col-2" style="float:none; display: block;">
	<div class="box">
		<div class="boxTitle">
			<h3 style="text-align:center;">Delete Department</h3>
		</div>
		<div class="boxContent">
			<b>Are You sure to delete this Department?<br><br>
			Department ID : <?php echo $department_id; ?><br>
			Department Name : <?php echo $DB->get_department_name($department_id); ?><br><br>
			</b>
			<form class="createReportForm" method="POST" action="department_management_server.php">
				<center>
				<a href="?tab=departmentManagement">
				<button type="button" class="button2 greenButton">
					<i class="fa  fa-times"></i> Cancel
				</button>
				</a>
				<button type="submit" class="button2 redButton" name="delete_department">
					<i class="fa fa-ban"></i> Yes, Delete
				</button>
				</center>
			</form>
		</div>
	</div>
</div>

<?php }
else
	echo "<center><h3>Can't Delete this Department</h3></center>";
}
else
	echo "<center><h3>Invalid Department ID</h3></center>";
}
?>

<div class="clearFix"></div>