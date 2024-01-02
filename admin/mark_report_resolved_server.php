<?php
	require ("../databaseserver.php");
	if(isset($_POST['mark_resolve_report'])){
		$report_id=$_SESSION['ru_report_id'];
		unset($_SESSION['ru_report_id']);
		
		if($DB->mark_report_solved($report_id)){
			$_SESSION['rc_report_update_success']=true;
			header("Location: ../admin/?tab=viewReport&report_id=".$report_id);	
		}
		else{
			$_SESSION['rc_unsuccessful']="Error Occurred";
			header("Location: ../admin/?tab=updateReport&report_id=".$report_id);		
		}
	}
	else
		header("Location: ../");
?>