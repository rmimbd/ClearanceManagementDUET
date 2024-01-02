<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="tabBox2">
	<div class="filterSection">
		<a href="?tab=officeManagement&action=add">
			<button type="button" class="button2"><i class="fa fa-plus-square"></i> Add Office</button>
		</a>
	</div>

	<div class="searchSection">
		<input type="text" id="office_search_key" name="key" placeholder="Search Here" required>
		<button type="button" name="searchOffice" class="button2" id="office_search_key_submit"><i class="fa fa-search"></i></button>
	</div>
	<div class="clearFix"></div>
	<?php
	if(isset($_SESSION['office_info_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Office information updated</center>
		</div>
	<?php unset($_SESSION['office_info_updated']); 
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
    		<col span="1" style="width: 6%;">
    		<col span="1" style="width: 8%;">
    		<col span="1" style="width: 18%;">
    		<col span="1" style="width: 16%;">
    		<col span="1" style="width: 16%;">
    		<col span="1" style="width: 18%;">
    		<col span="1" style="width: 18%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>Office ID</th>
			<th>Office Name</th>
			<th>Administrative Head</th>
			<th>Head Officer</th>
			<th>Location</th>
			<th>Actions</th>
		</tr>
		<?php
		
		$offices = $DB->get_all_office_data();
		$i=1;
		while($office=mysqli_fetch_array($offices)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>" id="<?php echo "office_row_".$i;?>">
			<td id="<?php echo "sl_".$i;?>"><?php echo $i; ?></td>
			<td id="<?php echo "office_id_".$i;?>"><?php echo $office['office_id']; ?></td>
			<td id="<?php echo "name_".$i;?>"><?php echo $office['office_name']; ?></td>
			<td id="<?php echo "admin_head_".$i;?>"><?php if($office['administrative_head']) echo $DB->get_name_of_teacher($office['administrative_head']); ?></td>
			<td id="<?php echo "head_officer_".$i;?>"><?php if($office['head_officer']) echo $DB->get_name_of_teacher($office['head_officer']); ?></td>
			<td><?php echo $office['office_loc']; ?></td>
			<td>
				<a href="?tab=officeManagement&action=edit&office_id=<?php echo $office['office_id']; ?>">
					<button type="button" class="button2 greenButton">
						<i class="fa fa-edit"></i> Update
					</button>
				</a>
				<a href="?tab=officeManagement&action=delete&office_id=<?php echo $office['office_id']; ?>">
					<button type="button" class="button2 redButton">
						<i class="fa  fa-trash"></i> Delete
					</button>
				</a>
				
			</td>
		</tr>
		<?php $i++;}

		if($i==1){?>
		<tr>
			<td colspan="6"><center><b>No office to show</b></center></td>
		</tr>
		<?php } ?>

		<script type="text/javascript"><?php echo "var total_row=".$i.";"?></script>
	</table>
</div>
<div class="clearFix"></div>