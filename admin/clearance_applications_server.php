<?php
	require ("../databaseserver.php");
	if(isset($_POST['only_supervising_students'])){
		$_SESSION['application_filter']=2;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_application'])){
		$_SESSION['application_filter']=1;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_hall'])){
		$_SESSION['application_filter']=3;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_labs'])){
		$_SESSION['application_filter']=4;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_department'])){
		$_SESSION['application_filter']=5;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_exam_controller'])){
		$_SESSION['application_filter']=6;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_comptroller_office'])){
		$_SESSION['application_filter']=7;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_medical_center'])){
		$_SESSION['application_filter']=8;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_computer_center'])){
		$_SESSION['application_filter']=9;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_physical_education_center'])){
		$_SESSION['application_filter']=10;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_central_library'])){
		$_SESSION['application_filter']=11;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_of_dsw_office'])){
		$_SESSION['application_filter']=12;
		if($_SESSION['type_filter']=3)
			$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	else if(isset($_POST['all_final'])){
		$_SESSION['application_filter']=13;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}

	else if(isset($_POST['type_pending'])){
		$_SESSION['type_filter']=1;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	
	else if(isset($_POST['type_approved'])){
		$_SESSION['type_filter']=2;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}

	else if(isset($_POST['type_declined'])){
		$_SESSION['type_filter']=3;
		header("Location: ../admin/?tab=clearanceApplications");
		return;
	}
	
	

	if (isset($_POST['approve_application'])) {
		$application_id=input_filter($_POST['approve_application']);
		if($_SESSION['application_filter']==4){
			$lab_id=intdiv($application_id,10000000000);
			$application_id=$application_id%10000000000;
		}
		if(!$DB->is_valid_application_id($application_id)){
			include('../include/error.php');
			return;
		}
		$application_data=mysqli_fetch_array($DB->get_application_data($application_id));
		
		if($_SESSION['application_filter']==1){
			if($DB->is_so_exam_controller() && $application_data['final_status']==0 && $application_data['approved_level']==0 && $application_data['so_exam_controller']==0){
				$DB->approve_as_so_exam_controller($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}

		}
		
		else if($_SESSION['application_filter']==2){
			if($DB->match_student_and_supervisor($application_data['student_id'], $DB->current_user->user_id) && $application_data['final_status']==0 && $application_data['approved_level']==5 && $application_data['thesis_supervisor']==0){
				$DB->approve_as_thesis_supervisor($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}
		}

		else if($_SESSION['application_filter']==3){
			if($DB->match_student_hall_assistant($application_data['student_id']) && $application_data['final_status']==0 && $application_data['approved_level']==1 && $application_data['aso_hall']==0){
				$DB->approve_as_aso_hall($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else if($DB->match_student_hall_provost($application_data['student_id']) && $application_data['final_status']==0 && $application_data['approved_level']==2 && $application_data['aso_hall']==1 && $application_data['provost']==0){
				$DB->approve_as_hall_provost($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}

		}
		
		else if($_SESSION['application_filter']==4){
			if($application_data['final_status']!=0 || $application_data['approved_level']!=3 || $application_data['labs']==1){
				include('../include/error.php');
				return;
			}
			$updated=false;
			$lab_approval_datas = $DB->get_lab_approval_data($application_id);
			while($lab_approval_data=mysqli_fetch_array($lab_approval_datas)){
				if($DB->is_lab_officer_of_lab_id($lab_approval_data['lab_id']) && $lab_approval_data['officer_approved']==0 && $lab_approval_data['assistant_approved']==1 && $lab_approval_data['lab_id']==$lab_id){
					$DB->approve_as_lab_officer($application_id, $lab_approval_data['lab_id']);
					$_SESSION['application_status_updated']=true;
					header("Location: ../admin/?tab=clearanceApplications");
					$updated=true;
					return;
				}
				else if($DB->is_lab_assistant_of_lab_id($lab_approval_data['lab_id']) && $lab_approval_data['officer_approved']==0 && $lab_approval_data['assistant_approved']==0 && $lab_approval_data['lab_id']==$lab_id){
					$DB->approve_as_lab_assistant($application_id, $lab_approval_data['lab_id']);
					$_SESSION['application_status_updated']=true;
					header("Location: ../admin/?tab=clearanceApplications");
					$updated=true;
					return;
				}
			}
			if($updated==false){
				include('../include/error.php');
				return;
			}
		}
		
		else if($_SESSION['application_filter']==5){
			$department_id=$DB->get_student_department($application_data['student_id']);
			if($DB->is_aso_department($department_id) && $application_data['final_status']==0 && $application_data['approved_level']==4 && $application_data['aso_department']==0){
				$DB->approve_as_aso_department($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else if($DB->is_department_head($department_id) && $application_data['final_status']==0 && $application_data['approved_level']==6 && $application_data['head_department']==0){
				$DB->approve_as_department_head($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}
		}
		
		else if($_SESSION['application_filter']>=6 and $_SESSION['application_filter']<=11){
			$office_id=NULL;
			$office_type=NULL;
			switch ($_SESSION['application_filter']) {
				case 6:
					$office_id=21;
					$office_type='exam_controller';
					break;
				case 7:
					$office_id=22;
					$office_type='comptroller';
					break;
				case 8:
					$office_id=23;
					$office_type='medical_center';
					break;
				case 9:
					$office_id=24;
					$office_type='computer_center';
					break;
				case 10:
					$office_id=25;
					$office_type='physical_edu_center';
					break;
				case 11:
					$office_id=26;
					$office_type='central_library';
					break;
				
			}
			if($DB->is_assistant_head_of_office($office_id) && $application_data['final_status']==0 && $application_data['approved_level']==7 && $application_data[$office_type]==0){
				$DB->approve_as_assistant_head_of_office($application_id, $office_type);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else if($DB->is_administrative_head_of_office($office_id) && $application_data['final_status']==0 && $application_data['approved_level']==7 && $application_data[$office_type]==1){
				$DB->approve_as_administrative_head_of_office($application_id, $office_type);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}
		}

		else if($_SESSION['application_filter']==12){
			if($DB->is_assistant_head_of_office(27) && $application_data['final_status']==0 && $application_data['approved_level']==8 && $application_data['assistant_dsw']==0){
				$DB->approve_as_assistant_dsw($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else if($DB->is_administrative_head_of_office(27) && $application_data['final_status']==0 && $application_data['approved_level']==9 && $application_data['assistant_dsw']==1 && $application_data['dsw']==0){
				$DB->approve_as_dsw($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}
		}

		else if($_SESSION['application_filter']==13){
			if($DB->is_deputy_exam_controller() && $application_data['final_status']==0 && $application_data['approved_level']==10 && $application_data['deputy_exam_controller']==0){
				$DB->final_approve($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			
			else{
				include('../include/error.php');
				return;
			}
		}
	}
	else if(isset($_POST['decline_application'])){
		$application_id=input_filter($_POST['decline_application']);
		if(!$DB->is_valid_application_id($application_id)){
			include('../include/error.php');
			return;
		}
		$application_data=mysqli_fetch_array($DB->get_application_data($application_id));
		
		if($_SESSION['application_filter']==13){
			if($DB->is_deputy_exam_controller() && $application_data['final_status']==0 && $application_data['approved_level']==10 && $application_data['deputy_exam_controller']==0){
				$DB->decline_application($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}

		}
	}
	else if(isset($_POST['approve_declined_application'])){
		$application_id=input_filter($_POST['approve_declined_application']);
		if(!$DB->is_valid_application_id($application_id)){
			include('../include/error.php');
			return;
		}
		$application_data=mysqli_fetch_array($DB->get_application_data($application_id));
		
		if($_SESSION['application_filter']==13 && $_SESSION['type_filter']==3){
			if($DB->is_deputy_exam_controller() && $application_data['final_status']==2 && $application_data['approved_level']==10 && $application_data['deputy_exam_controller']==2){
				$DB->approve_declined_application($application_id);
				$_SESSION['application_status_updated']=true;
				header("Location: ../admin/?tab=clearanceApplications");
				return;
			}
			else{
				include('../include/error.php');
				return;
			}

		}
	}
	include('../include/error.php');
?>