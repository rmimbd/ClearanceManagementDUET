<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_SESSION['updating_approver_id']) && !isset($_SESSION['deleting_approver_id'])){
		unset($_SESSION['au_old_value']);
	}
?>

<div class="tabBox2">
	<?php
	if(isset($_SESSION['approver_info_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Approver information updated</center>
		</div>
	<?php unset($_SESSION['approver_info_updated']); 
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
    		<col span="1" style="width: 10%;">
    		<col span="1" style="width: 15%;">
    		<col span="1" style="width: 25%;">
    		<col span="1" style="width: 25%;">
    		<col span="1" style="width: 25%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>Approver ID</th>
			<th>Approver Name</th>
			<th>Approver Type</th>
			<th>Actions</th>
		</tr>
		<?php
		
		$approvers = $DB->get_all_special_approver();
		$i=1;
		while($approver=mysqli_fetch_array($approvers)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>">
			<td><?php echo $i; ?></td>
			<td><?php echo $approver['approver_id']; ?></td>
			<td><?php echo $DB->get_name_of_teacher($approver['approver_id']); ?></td>
			<td><?php echo $approver['level']==1?'Initial Approver':'Final Approver'; ?></td>
			<td>
				<a href="?tab=specialApproverManagement&action=edit&approver_id=<?php echo $approver['approver_id']; ?>">
					<button type="button" class="button2 greenButton">
						<i class="fa fa-edit"></i> Update
					</button>
				</a>
				<a href="?tab=specialApproverManagement&action=delete&approver_id=<?php echo $approver['approver_id']; ?>">
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
<br>
<?php if(!isset($_GET['action'])) {?>
<center><a href="?tab=specialApproverManagement&action=add">
	<button type="button" class="button2"><i class="fa fa-plus-square"></i> Add Special Approver</button></a>
</center>
<?php unset($_SESSION['au_old_value']); ?>
<?php } else if($_GET['action']=='add'){?>

<div class="col-2" style="float:none; display: block;">
	<div class="box">
		<div class="boxTitle">
			<h3 style="text-align:center;">Add New Approver</h3>
		</div>
		<div class="boxContent">
			<form class="createReportForm" method="POST" action="special_approver_management_server.php">
				<input type="text" name="approver_id" minlength="5" maxlength="5" placeholder="Enter Approver ID" 
				value="<?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['approver_id']; ?>" required>
				<?php if(isset($_SESSION['au_approver_id_error'])) {?>
				<label style="color:maroon;font-weight: bold;"><?php echo '**'.$_SESSION['au_approver_id_error']; ?></label>
				<?php unset($_SESSION['au_approver_id_error']);} ?>
				<select name="approver_type" required>
					<option value="1">Initial Approver</option>
					<option value="11" <?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['approver_type']==11?'selected':''; ?>>Final Approver</option>
				</select>
				<?php if(isset($_SESSION['au_approver_type_error'])) {?>
				<label style="color:maroon;font-weight: bold;"><?php echo '**'.$_SESSION['au_approver_type_error']; ?></label>
				<?php unset($_SESSION['au_approver_type_error']);} ?>
				<center><button type="submit" class="button2" name="add_approver">Add</button></center>
			</form>
		</div>
	</div>
</div>

<?php } else if($_GET['action']=='edit' && isset($_GET['approver_id'])){?>
<?php
$approver_id=input_filter($_GET['approver_id']);
$_SESSION['updating_approver_id']=$approver_id;
if($DB->is_duplicate_approver($approver_id)){
	$approved_type=$DB->get_approver_level($approver_id);
?>
<div class="col-2" style="float:none; display: block;">
	<div class="box">
		<div class="boxTitle">
			<h3 style="text-align:center;">Update Approver</h3>
		</div>
		<div class="boxContent">
			<form class="createReportForm" method="POST" action="special_approver_management_server.php">
				<input type="text" minlength="0" maxlength="0" placeholder="<?php echo $approver_id; ?>" disabled>
				<select name="approver_type" required>
					<option value="1">Initial Approver</option>
					<option value="11" <?php if(isset($_SESSION['au_old_value'])) echo $_SESSION['au_old_value']['approver_type']==11?'selected':''; else if($approved_type==11) echo "selected"; ?>>Final Approver</option>
				</select>
				<?php if(isset($_SESSION['au_approver_type_error'])) {?>
				<label style="color:maroon;font-weight: bold;"><?php echo '**'.$_SESSION['au_approver_type_error']; ?></label>
				<?php unset($_SESSION['au_approver_type_error']);} ?>
				<center><button type="submit" class="button2" name="update_approver">Update</button></center>
			</form>
		</div>
	</div>
</div>

<?php }
else
	echo "<center><h3>Invalid Approver ID</h3></center>";
}
else if($_GET['action']=='delete' && isset($_GET['approver_id'])){?>
<?php
$approver_id=input_filter($_GET['approver_id']);
$_SESSION['deleting_approver_id']=$approver_id;
if($DB->is_duplicate_approver($approver_id)){?>
<div class="col-2" style="float:none; display: block;">
	<div class="box">
		<div class="boxTitle">
			<h3 style="text-align:center;">Delete Approver</h3>
		</div>
		<div class="boxContent">
			<b>Are You sure to delete this Approver?<br><br>
			Approver ID : <?php echo $approver_id; ?><br>
			Approver Name : <?php echo $DB->get_name_of_teacher($approver_id); ?><br><br>
			</b>
			<form class="createReportForm" method="POST" action="special_approver_management_server.php">
				<center>
				<a href="?tab=specialApproverManagement">
				<button type="button" class="button2 greenButton">
					<i class="fa  fa-times"></i> Cancel
				</button>
				</a>
				<button type="submit" class="button2 redButton" name="delete_approver">
					<i class="fa fa-ban"></i> Yes, Delete
				</button>
				</center>
			</form>
		</div>
	</div>
</div>

<?php }
else
	echo "<center><h3>Invalid Approver ID</h3></center>";
}
?>

<div class="clearFix"></div>