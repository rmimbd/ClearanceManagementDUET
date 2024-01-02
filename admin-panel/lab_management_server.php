<?php
	require ("../databaseserver.php");
	if(isset($_POST['all_labs'])){
		$_SESSION['lab_filter']=0;
		header("Location: ../admin-panel/?tab=labManagement");
		return;
	}
	else if(isset($_POST['department'])){
		$department_id=input_filter($_POST['department']);
		if($DB->is_valid_department_id($department_id))
			$_SESSION['lab_filter']=$department_id;	
		else
			$_SESSION['lab_filter']=0;
		header("Location: ../admin-panel/?tab=labManagement");
		return;
	}
	
	include('../include/error.php');
?>