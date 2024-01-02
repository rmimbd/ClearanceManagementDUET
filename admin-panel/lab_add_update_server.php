<?php
	require ("../databaseserver.php");
	if(isset($_POST['add_new_lab'])){
		$lab_name = input_filter($_POST['lab_name']);
		$department = input_filter($_POST['department_id']);
		$lab_assistant = input_filter($_POST['lab_assistant']);
		$lab_incharge = input_filter($_POST['lab_incharge']);


		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['lab_name']=$lab_name;
		$_SESSION['au_old_value']['department_id']=$department;
		$_SESSION['au_old_value']['lab_assistant']=$lab_assistant;
		$_SESSION['au_old_value']['lab_incharge']=$lab_incharge;


		$error_found=false;

		if($lab_name==''){
			$_SESSION['au_lab_name_error']="Please Enter Lab Name";
			$error_found=true;
		}
		else if($DB->is_duplicate_lab_name($lab_name, $department)){
			$_SESSION['au_lab_name_error']="Duplicate Lab Name";
			$error_found=true;
		}

		if($department==0){
			$_SESSION['au_department_id_error']="Please Select Department";
			$error_found=true;
		}
		else if(!$DB->is_valid_department_id($department)){
			$_SESSION['au_department_id_error']="Invalid Department";
			$error_found=true;
		}

		if($lab_assistant!=''){
			if(!is_numeric($lab_assistant)){
				$_SESSION['au_lab_assistant_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($lab_assistant)!=5){
				$_SESSION['au_lab_assistant_error']="Length of Lab Assistant ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($lab_assistant)){
				$_SESSION['au_lab_assistant_error']="Invalid Lab Assistant ID";
				$error_found=true;
			}
			
		}

		if($lab_incharge!=''){
			if(!is_numeric($lab_incharge)){
				$_SESSION['au_lab_incharge_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($lab_incharge)!=5){
				$_SESSION['au_lab_incharge_error']="Length of Lab In Charge ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($lab_incharge)){
				$_SESSION['au_lab_incharge_error']="Invalid Lab In Charge ID";
				$error_found=true;
			}
			
		}

		$lab_id=$DB->get_new_lab_id_of_department($department);

		
		if($error_found){
			header("Location: ../admin-panel/?tab=labManagement&action=add");
			return;
		}
		
		if($DB->add_new_lab($lab_id, $lab_name, $department, $lab_assistant, $lab_incharge)){
			$_SESSION['au_success']="Lab added Successfully";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=labManagement&action=add");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=labManagement&action=add");
			return;	
		}
	}

	else if(isset($_POST['update_lab_data'])){
		$lab_id = $_SESSION['updating_lab_id'];
		$lab_name = input_filter($_POST['lab_name']);
		$department = input_filter($_POST['department_id']);
		$lab_assistant = input_filter($_POST['lab_assistant']);
		$lab_incharge = input_filter($_POST['lab_incharge']);


		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['lab_name']=$lab_name;
		$_SESSION['au_old_value']['department_id']=$department;
		$_SESSION['au_old_value']['lab_assistant']=$lab_assistant;
		$_SESSION['au_old_value']['lab_incharge']=$lab_incharge;


		$error_found=false;
		$lab_old_data = $DB->get_all_information_of_lab($lab_id);
		if($lab_name==''){
			$_SESSION['au_lab_name_error']="Please Enter Lab Name";
			$error_found=true;
		}
		else if($DB->is_duplicate_lab_name($lab_name, $department) && $lab_name!=$lab_old_data['name']){
			$_SESSION['au_lab_name_error']="Duplicate Lab Name";
			$error_found=true;
		}

		if($department==0){
			$_SESSION['au_department_id_error']="Please Select Department";
			$error_found=true;
		}
		else if(!$DB->is_valid_department_id($department)){
			$_SESSION['au_department_id_error']="Invalid Department";
			$error_found=true;
		}

		if($lab_assistant!=''){
			if(!is_numeric($lab_assistant)){
				$_SESSION['au_lab_assistant_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($lab_assistant)!=5){
				$_SESSION['au_lab_assistant_error']="Length of Lab Assistant ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($lab_assistant)){
				$_SESSION['au_lab_assistant_error']="Invalid Lab Assistant ID";
				$error_found=true;
			}
			
		}

		if($lab_incharge!=''){
			if(!is_numeric($lab_incharge)){
				$_SESSION['au_lab_incharge_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($lab_incharge)!=5){
				$_SESSION['au_lab_incharge_error']="Length of Lab In Charge ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($lab_incharge)){
				$_SESSION['au_lab_incharge_error']="Invalid Lab In Charge ID";
				$error_found=true;
			}
			
		}
		if($error_found){
			header("Location: ../admin-panel/?tab=labManagement&action=edit&lab_id=".$lab_id);
			return;
		}

		if($DB->update_lab_information($lab_id, $lab_name, $department, $lab_assistant, $lab_incharge)){
			unset($_SESSION['au_old_value']);
			$_SESSION['lab_info_updated']="Information Updated";
			header("Location: ../admin-panel/?tab=labManagement");
			return;
		}
		else{
			unset($_SESSION['au_old_value']);
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=labManagement&action=edit&lab_id=".$lab_id);
			return;	
		}


	}
	else if(isset($_POST['delete_lab'])){
		$lab_id=$_SESSION['deleting_lab_id'];

		if($DB->delete_lab($lab_id)){
			$_SESSION['au_delete_success']="Lab Deleted";
			unset($_SESSION['deleting_lab_id']);	
			header("Location: ../admin-panel/?tab=labManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=labManagement");
			return;	
		}
	}
	
	else
		header("Location: ../");
?>