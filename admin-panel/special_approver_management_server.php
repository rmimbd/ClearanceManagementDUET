<?php
	require ("../databaseserver.php");
	if(isset($_POST['add_approver'])){
		$approver_id = input_filter($_POST['approver_id']);
		$approver_type = input_filter($_POST['approver_type']);



		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['approver_id']=$approver_id;
		$_SESSION['au_old_value']['approver_type']=$approver_type;


		$error_found=false;

		if($approver_id==''){
			$_SESSION['au_approver_id_error']="Enter Approver ID";
			$error_found=true;
		}
		else{
			if(!is_numeric($approver_id)){
				$_SESSION['au_approver_id_error']="Approver ID Should be numeric value";
				$error_found=true;
			}
			else if(strlen($approver_id)!=5){
				$_SESSION['au_approver_id_error']="Length of Approver ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($approver_id)){
				$_SESSION['au_approver_id_error']="Invalid Approver ID";
				$error_found=true;
			}
			else if($DB->is_duplicate_approver($approver_id)){
				$_SESSION['au_approver_id_error']="Approver ID Already Available.";
				$error_found=true;
			}
			
		}
		if($approver_type!=1 && $approver_type!=11){
			$_SESSION['au_approver_type_error']="Invalid Approver Type Selected";
			$error_found=true;
		}

		if($error_found){
			header("Location: ../admin-panel/?tab=specialApproverManagement&action=add");
			return;
		}
		
		if($DB->add_new_special_approver($approver_id, $approver_type)){
			$_SESSION['au_success']="Approver added Successfully";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=specialApproverManagement");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=specialApproverManagement");
			return;	
		}
	}

	else if(isset($_POST['update_approver'])){
		$approver_id = $_SESSION['updating_approver_id'];
		$approver_type = input_filter($_POST['approver_type']);

		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['approver_id']=$approver_id;
		$_SESSION['au_old_value']['approver_type']=$approver_type;

		$error_found=false;

		$old_type=$DB->get_approver_level($approver_id);

		if($approver_type!=1 && $approver_type!=11){
			$_SESSION['au_approver_type_error']="Invalid Approver Type Selected";
			$error_found=true;
		}

		if($error_found){
			header("Location: ../admin-panel/?tab=specialApproverManagement&action=edit&approver_id=".$approver_id);
			return;
		}
		if($DB->update_approver_information($approver_id, $approver_type)){
			unset($_SESSION['au_old_value']);
			$_SESSION['approver_info_updated']="Information Updated";
			header("Location: ../admin-panel/?tab=specialApproverManagement");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			unset($_SESSION['au_old_value']);
			unset($_SESSION['updating_aprover_id']);
			header("Location: ../admin-panel/?tab=specialApproverManagement");
			return;	
		}


	}
	else if(isset($_POST['delete_approver'])){
		$approver_id=$_SESSION['deleting_approver_id'];

		if($DB->delete_approver($approver_id)){
			$_SESSION['au_delete_success']="Approver Deleted";
			unset($_SESSION['deleting_approver_id']);	
			header("Location: ../admin-panel/?tab=specialApproverManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=specialApproverManagement");
			return;	
		}
	}
	
	else
		header("Location: ../");
?>