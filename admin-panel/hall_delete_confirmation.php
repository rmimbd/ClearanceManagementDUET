<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
	if(!isset($_GET['hall_id'])){
		require('../include/error_alter.php');
		return;
	}
	$hall_id=input_filter($_GET['hall_id']);
	if(!$DB->is_valid_hall_id($hall_id)){
		require('../include/error_alter.php');
		return;
	}
	if($DB->get_number_of_student_of_hall($hall_id)>0){
		echo "<center><h2>Error!</h2><h3>Can't Delete This Hall</h3><h4>**This Hall has active student.</h4></center>";
		return;
	}
	$hall_data=$DB->get_hall_info($hall_id);
	$_SESSION['deleting_hall_id']=$hall_id;
?>

<table class="tableOne">
	<colgroup>
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 70%;">
	</colgroup>
	<tr class="oddRow">
		<th>Hall ID</th>
		<td><?php echo $hall_id; ?></td>
	</tr>
	<tr class="evenRow">
		<th>Name</th>
		<td><?php echo $hall_data['name']; ?></td>
	</tr>
	<tr class="oddRow">
		<th>Short Name</th>
		<td><?php echo $hall_data['short_name']; ?></td>
	</tr>
	
</table>
<br>
<center>
	<h3>Are you sure to delete this Hall?</h3>
	<form method="POST" action="hall_add_update_server.php">
		<a href="?tab=hallManagement">
		<button type="button" class="button2 greenButton">
			<i class="fa  fa-times"></i> Cancel
		</button>
		</a>
		<button type="submit" class="button2 redButton" name="delete_hall">
			<i class="fa fa-ban"></i> Yes, Delete
		</button>
	</form>
</center>