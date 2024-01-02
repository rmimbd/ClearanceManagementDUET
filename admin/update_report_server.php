<?php
	require ("../databaseserver.php");
	if(isset($_POST['update_report'])){
		$title = input_filter($_POST['title']);
		$description = input_filter($_POST['description']);
		$report_data=$DB->get_report_data($_SESSION['ru_report_id']);
		unset($_SESSION['ru_report_id']);
		$report_id = $report_data['report_id'];
		
		if($DB->update_report_data($report_id, $title, $description)){
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