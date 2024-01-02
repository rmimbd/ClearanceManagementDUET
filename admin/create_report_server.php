<?php
	require ("../databaseserver.php");
	if(isset($_POST['create_report'])){
		$student_id = input_filter($_POST['student_id']);
		$title = input_filter($_POST['title']);
		$description = input_filter($_POST['description']);
		$date_time=NULL;
		if($DB->is_valid_student_id($student_id)){
			$report_id = $DB->current_user->office_id;
			while($report_id==$DB->current_user->office_id){
				$timestamp = time();
				$date_time=date("Y-m-d h:i:sa", $timestamp);
				$temp_id = $report_id.date("ymdHis", $timestamp);
				if(!$DB->does_report_id_exists($temp_id))
					$report_id = $temp_id;
			}
			if($DB->issue_new_report($report_id, $student_id, $title, $description, $date_time)){
				$_SESSION['rc_report_id']=$report_id;
				header("Location: ../admin/?tab=createReport");	
			}
			else{
				$_SESSION['rc_unsuccessful']="Error Occurred";
				header("Location: ../admin/?tab=createReport");		
			}

		}
		else{
			$_SESSION['rc_student_id_error']="*Invalid Student ID";
			$_SESSION['rc_old_value']=[$student_id,$title,$description];
			header("Location: ../admin/?tab=createReport");
		}

	}
	else
		header("Location: ../");
?>