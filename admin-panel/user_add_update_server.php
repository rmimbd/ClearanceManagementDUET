<?php
	require ("../databaseserver.php");
	if(isset($_POST['add_new_user'])){
		$user_name = input_filter($_POST['user_name']);
		$designation = input_filter($_POST['user_designation']);
		$office_id = input_filter($_POST['office_id']);
		$user_email = input_filter($_POST['user_email']);
		$user_phone = input_filter($_POST['user_phone']);
		$user_username = input_filter($_POST['user_username']);
		$user_password = input_filter($_POST['user_password']);
		


		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['user_name']=$user_name;
		$_SESSION['au_old_value']['user_designation']=$designation;
		$_SESSION['au_old_value']['office_id']=$office_id;
		$_SESSION['au_old_value']['user_email']=$user_email;
		$_SESSION['au_old_value']['user_phone']=$user_phone;
		$_SESSION['au_old_value']['user_username']=$user_username;
		$_SESSION['au_old_value']['user_password']=$user_password;


		$error_found=false;

		if(!$DB->is_valid_office_id($office_id)){
			$_SESSION['au_office_id_error']="Invalid Office ID";
			$error_found=true;	
		}
		if($user_email!=''){
			if($DB->is_duplicate_user_email($user_email)){
				$_SESSION['au_email_error']="Duplicate entry of email";
				$error_found=true;		
			}
		}
		if($user_phone!=''){
			if($DB->is_duplicate_user_phone($user_phone)){
				$_SESSION['au_phone_error']="Duplicate entry of phone";
				$error_found=true;		
			}
		}
		if($user_username!=''){
			if($DB->is_valid_username($user_username)){
				$_SESSION['au_username_error']="Username Already Assigned";
				$error_found=true;		
			}
		}
		if($error_found){
			header("Location: ../admin-panel/?tab=userManagement&action=addUser");
			return;
		}
		
		$user_id = $DB->get_new_user_id_of_office($office_id);

		if($DB->add_new_admin_user($user_id, $user_name, $designation, $office_id, $user_username, $user_password, $user_email, $user_phone)){
			$_SESSION['au_success']="User added Successfully.<br>User ID is: ".$user_id;
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=userManagement&action=addUser");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=userManagement&action=addUser");
			return;	
		}
	}

	else if(isset($_POST['update_user_data'])){
		$user_name = input_filter($_POST['user_name']);
		$designation = input_filter($_POST['user_designation']);
		$office_id = input_filter($_POST['office_id']);
		$user_email = input_filter($_POST['user_email']);
		$user_phone = input_filter($_POST['user_phone']);
		$user_username = input_filter($_POST['user_username']);
		$user_password = input_filter($_POST['user_password']);
		
		$user_id=$_SESSION['updating_user_id'];
		$user_data=$DB->get_all_information_of_admin($user_id);
		

		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['user_name']=$user_name;
		$_SESSION['au_old_value']['user_designation']=$designation;
		$_SESSION['au_old_value']['office_id']=$office_id;
		$_SESSION['au_old_value']['user_email']=$user_email;
		$_SESSION['au_old_value']['user_phone']=$user_phone;
		$_SESSION['au_old_value']['user_username']=$user_username;
		$_SESSION['au_old_value']['user_password']=$user_password;


		$error_found=false;

		if(!$DB->is_valid_office_id($office_id)){
			$_SESSION['au_office_id_error']="Invalid Office ID";
			$error_found=true;
		}
		if($user_email!=$user_data['email']){
			if($DB->is_duplicate_user_email($user_email)  && $user_email!=''){
				$_SESSION['au_email_error']="Duplicate entry of email";
				$error_found=true;		
			}
		}
		if($user_email=='')
			$user_email=NULL;
		if($user_phone!=$user_data['phone']){
			if($DB->is_duplicate_user_phone($user_phone) && $user_phone!=''){
				$_SESSION['au_phone_error']="Duplicate entry of phone";
				$error_found=true;		
			}
			
		}
		if($user_phone=='')
			$user_phone=NULL;
		if($user_username!=$user_data['username']){
			if($DB->is_valid_username($user_username) && $user_username!=''){
				$_SESSION['au_username_error']="Username Already Assigned";
				$error_found=true;		
			}
		}
		if($error_found){
			header("Location: ../admin-panel/?tab=userManagement&action=edit&user_id=".$user_id);
			return;
		}
		
		if($DB->update_admin_user($user_id, $user_name, $designation, $office_id, $user_username, $user_password, $user_email, $user_phone)){
			unset($_SESSION['au_old_value']);
			$_SESSION['au_success']="Information Updated";
			header("Location: ../admin-panel/?tab=userManagement&action=details&user_id=".$user_id);
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=userManagement&action=edit&user_id=".$user_id);
			return;	
		}
	}
	else if(isset($_POST['delete_user'])){
		$user_id=$_SESSION['deleting_user_id'];
		

		if($DB->delete_admin_user($user_id)){
			$_SESSION['au_delete_success']="User Restricted";
			unset($_SESSION['deleting_user_id']);	
			header("Location: ../admin-panel/?tab=userManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=userManagement");
			return;	
		}
	}
	else if(isset($_POST['unrestrict_user'])){
		$user_id=$_SESSION['unrestricting_user_id'];
		

		if($DB->unrestrict_admin_user($user_id)){
			$_SESSION['au_delete_success']="User Unrestricted";
			unset($_SESSION['unrestricting_user_id']);	
			header("Location: ../admin-panel/?tab=userManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=userManagement");
			return;	
		}
	}
	else
		header("Location: ../");
?>