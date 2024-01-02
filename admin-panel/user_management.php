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

?>
<div class="tabBox2">
	<div class="filterSection">
		<form method="POST" action="user_management_server.php">
			<button type="button" class="button2" id="user_filter_dropdown_activator">
			<?php
				if($_SESSION['user_filter']==1) {
					echo "All User <i class=\"fa fa-filter\"></i>";	
				}
				else if($_SESSION['user_filter']==2){
					echo "Teachers <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['user_filter']==3){
					echo "Officers <i class=\"fa fa-filter\"></i>";
				}
				else if($_SESSION['user_filter']==4){
					echo "Restricted Users <i class=\"fa fa-filter\"></i>";
				}
				
			?>
			</button>
			<ul class="filterList" id="user_filter_dropdown_list">
				<li><button <?php if($_SESSION['user_filter']==1) echo "style=\"background-color:#123834;\""; ?> type="submit" name="all_users">Show all Users</button></li>
				
				<li><button <?php if($_SESSION['user_filter']==2) echo "style=\"background-color:#123834;\""; ?> type="submit" name="only_teacher">Show Teachers Only</button></li>
				
				<li><button <?php if($_SESSION['user_filter']==3) echo "style=\"background-color:#123834;\""; ?> type="submit" name="only_officer"> Show Officers Only</button></li>
				
				<li><button <?php if($_SESSION['user_filter']==4) echo "style=\"background-color:#123834;\""; ?> type="submit" name="only_restricted"> Show Restricted Users Only</button></li>
				

			</ul>
			<a href="?tab=userManagement&action=addUser">
				<button type="button" class="button2"><i class="fa fa-user-plus"></i> Add User</button>
			</a>
		</form>
	</div>

	<div class="searchSection">
		<input type="text" id="user_search_key" name="key" placeholder="Search Here" required>
		<button type="button" name="searchReport" class="button2" id="user_search_key_submit"><i class="fa fa-search"></i></button>
	</div>
	<div class="clearFix"></div>
	<?php
	if(isset($_SESSION['user_info_updated'])){?>
		<div class="closable_popup" id="popup">
		<i class="fa fa-plus-circle close_button" id="popup_close_button"></i>
		<center>User information updated</center>
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
    		<col span="1" style="width: 6%;">
    		<col span="1" style="width: 8%;">
    		<col span="1" style="width: 18%;">
    		<col span="1" style="width: 18%;">
    		<col span="1" style="width: 22%;">
    		<col span="1" style="width: 28%;">
    	</colgroup>
		<tr class="tableOneHeader">
			<th>Serial</th>
			<th>User ID</th>
			<th>Name</th>
			<th>Designation</th>
			<th>Office</th>
			<th>Actions</th>
		</tr>
		<?php
		if($_SESSION['user_filter']==1)
			$users = $DB->get_all_admin_user_information();
		
		else if($_SESSION['user_filter']==2)
			$users = $DB->get_all_teachers_information();
		
		else if($_SESSION['user_filter']==3)
			$users = $DB->get_all_officers_information();
		
		else if($_SESSION['user_filter']==4)
			$users = $DB->get_all_restricted_users_information();

		$i=1;
		while($user=mysqli_fetch_array($users)){?>
		<tr class="<?php echo $i%2==0?"evenRow":"oddRow";?>" id="<?php echo "user_row_".$i;?>">
			<td id="<?php echo "sl_".$i;?>"><?php echo $i; ?></td>
			<td  id="<?php echo "user_id_".$i;?>"><?php echo $user['user_id']; ?></td>
			<td id="<?php echo "name_".$i;?>"><?php echo $user['name']; ?></td>
			<td><?php echo $user['designation']; ?></td>
			<td id="<?php echo "office_".$i;?>"><?php echo $DB->get_office_data($user['office_id'])['office_name']; ?></td>
			<td>
				<a href="?tab=userManagement&action=details&user_id=<?php echo $user['user_id']; ?>">
					<button type="button" class="button2 darkBlueButton">
						<i class="fa fa-list"></i> Details
					</button>
				</a>
				
				<a href="?tab=userManagement&action=edit&user_id=<?php echo $user['user_id']; ?>">
					<button type="button" class="button2 greenButton">
						<i class="fa fa-edit"></i> Update
					</button>
				</a>
				<?php if($_SESSION['user_filter']!=4) {?>
				<a href="?tab=userManagement&action=delete&user_id=<?php echo $user['user_id']; ?>">
					<button type="button" class="button2 redButton">
						<i class="fa  fa-ban"></i> Restrict
					</button>
				</a>
				<?php } ?>
				<?php if($_SESSION['user_filter']==4) {?>
				<a href="?tab=userManagement&action=unrestrict&user_id=<?php echo $user['user_id']; ?>">
					<button type="button" class="button2">
						<i class="fa  fa-circle"></i> Unrestrict
					</button>
				</a>
				<?php } ?>
				
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