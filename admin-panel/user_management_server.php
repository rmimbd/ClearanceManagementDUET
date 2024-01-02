<?php
	require ("../databaseserver.php");
	if(isset($_POST['all_users'])){
		$_SESSION['user_filter']=1;
		header("Location: ../admin-panel/?tab=userManagement");
		return;
	}
	else if(isset($_POST['only_teacher'])){
		$_SESSION['user_filter']=2;
		header("Location: ../admin-panel/?tab=userManagement");
		return;
	}
	else if(isset($_POST['only_officer'])){
		$_SESSION['user_filter']=3;
		header("Location: ../admin-panel/?tab=userManagement");
		return;
	}
	
	else if(isset($_POST['only_restricted'])){
		$_SESSION['user_filter']=4;
		header("Location: ../admin-panel/?tab=userManagement");
		return;
	}
	
	include('../include/error.php');
?>