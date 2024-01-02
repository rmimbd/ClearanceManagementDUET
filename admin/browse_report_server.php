<?php
	session_start();
	if(isset($_POST['only_user_created'])){
		$_SESSION['browse_report_filter']=1;
	}
	else if(isset($_POST['all_of_office'])){
		$_SESSION['browse_report_filter']=2;
	}
	else if(isset($_POST['advising_student'])){
		$_SESSION['browse_report_filter']=3;
	}
	elseif(!isset($_SESSION['browse_report_filter']))
		$_SESSION['browse_report_filter']=1;	

	header("Location: ../admin/?tab=browseReport");
?>