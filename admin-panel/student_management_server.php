<?php
	require ("../databaseserver.php");
	if(isset($_POST['all_students'])){
		$_SESSION['user_filter']=1;
		header("Location: ../admin-panel/?tab=studentManagement");
		return;
	}
	include('../include/error.php');
?>