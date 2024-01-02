<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<?php
	if(!isset($_SESSION['lab_filter'])){ 
		$_SESSION['lab_filter']=0;
	}

?>
<div class="tabBox2">
	<div class="filterSection">
		<form method="POST" action="lab_management_server.php">
			<button type="button" class="button2" id="user_filter_dropdown_activator">
			<?php
				if($_SESSION['lab_filter']==0) {
					echo "All Labs <i class=\"fa fa-filter\"></i>";
				}
				else{
					$depts=$DB->get_all_department_data();
					while($dept=mysqli_fetch_array($depts)){
						if($_SESSION['lab_filter']==$dept['department_id'])
							echo "Labs of ".$dept['department_name']." Department <i class=\"fa fa-filter\"></i>";
					}
				}
				
			?>
			</button>
			<ul class="filterList" id="user_filter_dropdown_list">
				<li><button <?php if($_SESSION['lab_filter']==0) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_labs">Show all Labs</button></li>
				<?php 
				$depts=$DB->get_all_department_data();
				while($dept=mysqli_fetch_array($depts)){?>
				<li><button <?php if($_SESSION['lab_filter']==$dept['department_id']) echo "style=\"background-color:#123834;\""; ?> type="submit" name="department" value="<?php echo $dept['department_id'];?>">Show Labs of <?php echo $dept['department_name'];?> Department</button></li>
				<?php } ?>
			</ul>
			<a href="?tab=labManagement&action=add">
				<button type="button" class="button2"><i class="fa fa-plus-square"></i> Add Lab</button>
			</a>
		</form>
	</div>

	<div class="searchSection">
		<input type="text" id="lab_search_key" name="key" placeholder="Search Here" required>
		<button type="button" name="searchReport" class="button2" id="lab_search_key_submit"><i class="fa fa-search"></i></button>
	</div>
	<div class="clearFix"></div>
	<?php
	if(isset($_SESSION['lab_info_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>Lab information updated</center>
		</div>
	<?php unset($_SESSION['lab_info_updated']); 
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
    		<col span="1" style="width: 6%;">
    		<col span="1" style="width: 25%;">
    		<col span="1" style="width: 11%;">
    		<col span="1" style="width: 17%;">
    		<col span="1" style="width: 17%;">
    		<col span="1" style="width: 18%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>Lab ID</th>
			<th>Name</th>
			<th>Department</th>
			<th>Lab Assistant</th>
			<th>Lab In Charge</th>
			<th>Actions</th>
		</tr>
		<?php
		$labs=NULL;
		if($_SESSION['lab_filter']==0)
			$labs = $DB->get_all_lab_information();
		else{
			$depts=$DB->get_all_department_data();
			while($dept=mysqli_fetch_array($depts)){
				if($_SESSION['lab_filter']==$dept['department_id']){
					$labs = $DB->get_all_lab_information_of_deartment($dept['department_id']);
					break;
				}
			}
		}
		if($labs==NULL)
			$labs = $DB->get_all_lab_information();
		
		$i=1;
		while($lab=mysqli_fetch_array($labs)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>" id="<?php echo "lab_row_".$i;?>">
			<td id="<?php echo "sl_".$i;?>"><?php echo $i; ?></td>
			<td  id="<?php echo "lab_id_".$i;?>"><?php echo $lab['lab_id']; ?></td>
			<td id="<?php echo "name_".$i;?>"><?php echo $lab['name']; ?></td>
			<td id="<?php echo "department_".$i;?>"><?php echo $DB->get_department_name($lab['department']); ?></td>
			<td id="<?php echo "assistant_".$i;?>"><?php if($lab['assistant']!='') echo $DB->get_name_of_teacher($lab['assistant']);?></td>
			<td id="<?php echo "incharge_".$i;?>"><?php if($lab['officer']!='') echo $DB->get_name_of_teacher($lab['officer']);?></td>
			
			<td>
				<a href="?tab=labManagement&action=edit&lab_id=<?php echo $lab['lab_id']; ?>">
					<button type="button" class="button2 greenButton">
						<i class="fa fa-edit"></i> Update
					</button>
				</a>
				<a href="?tab=labManagement&action=delete&lab_id=<?php echo $lab['lab_id']; ?>">
					<button type="button" class="button2 redButton">
						<i class="fa  fa-trash"></i> Delete
					</button>
				</a>
				
			</td>
		</tr>
		<?php $i++;}

		if($i==1){?>
		<tr>
			<td colspan="7"><center><b>No Lab to show</b></center></td>
		</tr>
		<?php } ?>
		<script type="text/javascript"><?php echo "var total_row=".$i.";"?></script>
	</table>
</div>
<div class="clearFix"></div>