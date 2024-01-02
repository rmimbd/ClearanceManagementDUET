<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="tabBox2">
	<div class="filterSection">
		<a href="?tab=hallManagement&action=add">
			<button type="button" class="button2"><i class="fa fa-plus-square"></i> Add Hall</button>
		</a>
	</div>

	<div class="clearFix"></div>
	<?php
	if(isset($_SESSION['hall_info_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Hall information updated</center>
		</div>
	<?php unset($_SESSION['hall_info_updated']); 
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
    		<col span="1" style="width: 18%;">
    		<col span="1" style="width: 12%;">
    		<col span="1" style="width: 16%;">
    		<col span="1" style="width: 15%;">
    		<col span="1" style="width: 15%;">
    		<col span="1" style="width: 18%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Hall ID</th>
			<th>Full Name</th>
			<th>Short Name</th>
			<th>Provost</th>
			<th>Assistant Provost</th>
			<th>Office Assistant</th>
			<th>Actions</th>
		</tr>
		<?php
		
		$halls = $DB->get_all_hall_info();
		$i=1;
		while($hall=mysqli_fetch_array($halls)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>">
			<td><?php echo $hall['hall_id']; ?></td>
			<td><?php echo $hall['name']; ?></td>
			<td><?php echo $hall['short_name']; ?></td>
			<td><?php if($hall['provost']) echo $DB->get_name_of_teacher($hall['provost']); ?></td>
			<td>
				<?php if($hall['a_provost1']) echo $DB->get_name_of_teacher($hall['a_provost1']).'<br>'; ?>
				<?php if($hall['a_provost2']) echo $DB->get_name_of_teacher($hall['a_provost2']).'<br>'; ?>
				<?php if($hall['a_provost3']) echo $DB->get_name_of_teacher($hall['a_provost3']).'<br>'; ?>
				<?php if($hall['a_provost4']) echo $DB->get_name_of_teacher($hall['a_provost4']).'<br>'; ?>
			</td>
			<td><?php if($hall['a_section_officer']) echo $DB->get_name_of_teacher($hall['a_section_officer']); ?></td>
			<td>
				<a href="?tab=hallManagement&action=edit&hall_id=<?php echo $hall['hall_id']; ?>">
					<button type="button" class="button2 greenButton">
						<i class="fa fa-edit"></i> Update
					</button>
				</a>
				<a href="?tab=hallManagement&action=delete&hall_id=<?php echo $hall['hall_id']; ?>">
					<button type="button" class="button2 redButton">
						<i class="fa  fa-trash"></i> Delete
					</button>
				</a>
				
			</td>
		</tr>
		<?php $i++;}

		if($i==1){?>
		<tr>
			<td colspan="6"><center><b>No Hall to show</b></center></td>
		</tr>
		<?php } ?>


	</table>
</div>
<div class="clearFix"></div>