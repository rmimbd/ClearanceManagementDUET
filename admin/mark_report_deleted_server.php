<?php
	require ("../databaseserver.php");
	if(isset($_POST['mark_delete_report'])){
		$report_id=$_SESSION['ru_report_id'];
		unset($_SESSION['ru_report_id']);
		
		if($DB->mark_report_deleted($report_id)){
			header("Location: ../admin/?tab=browseReport");	
		}
		else{
			$_SESSION['rc_unsuccessful']="Error Occurred";
			header("Location: ../admin/?tab=updateReport&report_id=".$report_id);		
		}
	}
	else
		header("Location: ../");
?>