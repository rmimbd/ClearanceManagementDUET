<?php
	require ("../databaseserver.php");
	if(isset($_POST['add_department'])){
		$department_id = input_filter($_POST['department_id']);
		$department_name = input_filter($_POST['department_name']);



		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['department_id']=$department_id;
		$_SESSION['au_old_value']['department_name']=$department_name;


		$error_found=false;

		if($department_id==''){
			$_SESSION['au_department_id_error']="Enter Approver ID";
			$error_found=true;
		}
		else{
			if(!is_numeric($department_id)){
				$_SESSION['au_department_id_error']="Approver ID Should be numeric value";
				$error_found=true;
			}
			else if($department_id<1 || $department_id>19){
				$_SESSION['au_department_id_error']="Department ID Should be between 1 to 19";
				$error_found=true;
			}
			else if($DB->is_valid_department_id($department_id)){
				$_SESSION['au_department_id_error']="Duplicate Department ID";
				$error_found=true;
			}
			
		}

		if($department_name==''){
			$_SESSION['au_department_name_error']="Enter Department Name";
			$error_found=true;
		}
		else{
			if(strlen($department_name)<=1 || strlen($department_name)>20){
				$_SESSION['au_department_name_error']="Length of Department Name Should be between 1 to 20";
				$error_found=true;
			}
			else if($DB->is_valid_department_name($department_name)){
				$_SESSION['au_department_name_error']="Duplicate Department Name";
				$error_found=true;
			}
			
		}

		if($error_found){
			header("Location: ../admin-panel/?tab=departmentManagement&action=add");
			return;
		}
		
		if($DB->add_new_department($department_id, $department_name)){
			$_SESSION['au_success']="Department added Successfully";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=departmentManagement");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=departmentManagement");
			return;	
		}
	}

	else if(isset($_POST['update_department'])){
		$department_id = $_SESSION['updating_department_id'];
		$department_name = input_filter($_POST['department_name']);

		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['department_id']=$department_id;
		$_SESSION['au_old_value']['department_name']=$department_name;

		$error_found=false;

		if($department_name==''){
			$_SESSION['au_department_name_error']="Enter Department Name";
			$error_found=true;
		}
		else{
			if(strlen($department_name)<=1 || strlen($department_name)>20){
				$_SESSION['au_department_name_error']="Length of Department Name Should be between 1 to 20";
				$error_found=true;
			}
			else if($DB->is_valid_department_name($department_name)){
				$_SESSION['au_department_name_error']="Duplicate Department Name";
				$error_found=true;
			}
			
		}

		if($error_found){
			header("Location: ../admin-panel/?tab=departmentManagement&action=edit&department_id=".$department_id);
			return;
		}

		if($DB->update_department_information($department_id, $department_name)){
			unset($_SESSION['au_old_value']);
			$_SESSION['department_info_updated']="Information Updated";
			header("Location: ../admin-panel/?tab=departmentManagement");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			unset($_SESSION['au_old_value']);
			unset($_SESSION['updating_aprover_id']);
			header("Location: ../admin-panel/?tab=departmentManagement");
			return;	
		}


	}
	else if(isset($_POST['delete_department'])){
		$department_id=$_SESSION['deleting_department_id'];
		if($DB->delete_department($department_id)){
			$_SESSION['au_delete_success']="Department Deleted";
			unset($_SESSION['deleting_department_id']);	
			header("Location: ../admin-panel/?tab=departmentManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=departmentManagement");
			return;	
		}
	}
	
	else
		header("Location: ../");
?>