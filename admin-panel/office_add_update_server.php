<?php
	require ("../databaseserver.php");
	if(isset($_POST['add_new_office'])){
		$office_id = input_filter($_POST['office_id']);
		$office_name = input_filter($_POST['office_name']);
		$admin_head = input_filter($_POST['admin_head']);
		$head_officer = input_filter($_POST['head_officer']);
		$office_loc = input_filter($_POST['office_loc']);
		


		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['office_id']=$office_id;
		$_SESSION['au_old_value']['office_name']=$office_name;
		$_SESSION['au_old_value']['admin_head']=$admin_head;
		$_SESSION['au_old_value']['head_officer']=$head_officer;
		$_SESSION['au_old_value']['office_loc']=$office_loc;


		$error_found=false;

		if(!is_numeric($office_id)){
			$_SESSION['au_office_id_error']="Invalid Office ID. Only numeric value is valid.";
			$error_found=true;
		}
		else if($office_id<0 || $office_id>9999){
			$_SESSION['au_office_id_error']="Invalid Office ID";
			$error_found=true;
		}
		else if($DB->is_valid_office_id($office_id)){
			$_SESSION['au_office_id_error']="Duplicate Office ID";
			$error_found=true;
		}

		

		if($admin_head!=''){
			if(!is_numeric($admin_head)){
				$_SESSION['au_admin_head_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($admin_head)!=5){
				$_SESSION['au_admin_head_error']="Length of Admin Head ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($admin_head)){
				$_SESSION['au_admin_head_error']="Invalid Admin Head ID";
				$error_found=true;
			}
			
		}

		if($head_officer!=''){
			if(!is_numeric($head_officer)){
				$_SESSION['au_head_officer_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($head_officer)!=5){
				$_SESSION['au_head_officer_error']="Length of Head Officer ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($head_officer)){
				$_SESSION['au_head_officer_error']="Invalid Head Officer ID";
				$error_found=true;
			}
			
		}


		if($error_found){
			header("Location: ../admin-panel/?tab=officeManagement&action=add");
			return;
		}
		
		if($DB->add_new_office($office_id, $office_name, $admin_head, $head_officer, $office_loc)){
			$_SESSION['au_success']="Office added Successfully";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=officeManagement&action=add");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=officeManagement&action=add");
			return;	
		}
	}

	else if(isset($_POST['update_office_data'])){
		$office_id = $_SESSION['updating_office_id'];
		$office_name = input_filter($_POST['office_name']);
		$admin_head = input_filter($_POST['admin_head']);
		$head_officer = input_filter($_POST['head_officer']);
		$office_loc = input_filter($_POST['office_loc']);
		


		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['office_id']=$office_id;
		$_SESSION['au_old_value']['office_name']=$office_name;
		$_SESSION['au_old_value']['admin_head']=$admin_head;
		$_SESSION['au_old_value']['head_officer']=$head_officer;
		$_SESSION['au_old_value']['office_loc']=$office_loc;

		$old_info=$DB->get_office_data($office_id);
		$error_found=false;

		

		if($admin_head!=''){
			if(!is_numeric($admin_head)){
				$_SESSION['au_admin_head_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($admin_head)!=5){
				$_SESSION['au_admin_head_error']="Length of Admin Head ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($admin_head)){
				$_SESSION['au_admin_head_error']="Invalid Admin Head ID";
				$error_found=true;
			}
		}

		if($head_officer!=''){
			if(!is_numeric($head_officer)){
				$_SESSION['au_head_officer_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($head_officer)!=5){
				$_SESSION['au_head_officer_error']="Length of Head Officer ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($head_officer)){
				$_SESSION['au_head_officer_error']="Invalid Head Officer ID";
				$error_found=true;
			}
			
		}

		if($error_found){
			header("Location:../admin-panel/?tab=officeManagement&action=edit&office_id=".$office_id);
			return;
		}

		if($DB->update_office_information($office_id, $office_name, $admin_head, $head_officer, $office_loc)){
			unset($_SESSION['au_old_value']);
			$_SESSION['office_info_updated']="Information Updated";
			header("Location: ../admin-panel/?tab=officeManagement");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=officeManagement&action=edit&office_id=".$office_id);
			return;	
		}


	}
	else if(isset($_POST['delete_office'])){
		$office_id=$_SESSION['deleting_office_id'];

		if($DB->delete_office($office_id)){
			$_SESSION['au_delete_success']="Office Deleted";
			unset($_SESSION['deleting_office_id']);	
			header("Location: ../admin-panel/?tab=officeManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=officeManagement");
			return;	
		}
	}
	
	else
		header("Location: ../");
?>