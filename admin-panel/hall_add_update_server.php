<?php
	require ("../databaseserver.php");
	if(isset($_POST['add_new_hall'])){
		$hall_id = input_filter($_POST['hall_id']);
		$hall_name = input_filter($_POST['hall_name']);
		$hall_short_name = input_filter($_POST['hall_short_name']);
		$provost = input_filter($_POST['provost']);
		$apno=0;
		for($apno=0;$apno<4;$apno++)
			$a_provost[$apno] = input_filter($_POST['a_provost_'.($apno+1)]);
		$hall_assistant=input_filter($_POST['hall_assistant']);
		


		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['hall_id']=$hall_id;
		$_SESSION['au_old_value']['hall_name']=$hall_name;
		$_SESSION['au_old_value']['hall_short_name']=$hall_short_name;
		$_SESSION['au_old_value']['provost']=$provost;
		$_SESSION['au_old_value']['hall_assistant']=$hall_assistant;
		for($apno=0;$apno<4;$apno++)
			$_SESSION['au_old_value']['a_provost_'.($apno+1)]=$a_provost[$apno];

		$error_found=false;

		if(!is_numeric($hall_id)){
			$_SESSION['au_hall_id_error']="Invalid Hall ID. Only numeric value is valid.";
			$error_found=true;
		}
		else if($hall_id<0 || $hall_id>99){
			$_SESSION['au_hall_id_error']="Hall ID Should be within 99";
			$error_found=true;
		}
		else if($DB->is_valid_hall_id($hall_id)){
			$_SESSION['au_hall_id_error']="Duplicate Hall ID";
			$error_found=true;
		}

		if($hall_name==''){
			$_SESSION['au_hall_name_error']="Enter Hall Name";
			$error_found=true;
		}
		else{
			if($DB->is_valid_hall_name($hall_name)){
				$_SESSION['au_hall_name_error']="Duplicate Hall Name";
				$error_found=true;
			}
		}
		
		if($hall_short_name==''){
			$_SESSION['au_hall_short_name_error']="Enter Hall Short Name";
			$error_found=true;
		}
		else{
			if($DB->is_valid_hall_short_name($hall_short_name)){
				$_SESSION['au_hall_short_name_error']="Duplicate Hall Short Name";
				$error_found=true;
			}
		}
		

		if($provost!=''){
			if(!is_numeric($provost)){
				$_SESSION['au_provost_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($provost)!=5){
				$_SESSION['au_provost_error']="Length of Provost ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($provost)){
				$_SESSION['au_provost_error']="Invalid Provost ID";
				$error_found=true;
			}
			
		}

		for($apno=0;$apno<4;$apno++){
			if($a_provost[$apno]=='')
				continue;
			if(!is_numeric($a_provost[$apno])){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($a_provost[$apno])!=5){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Length of Assistant Provost ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($a_provost[$apno])){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Invalid Assistant Provost ID";
				$error_found=true;
			}
		}
		$temp_array=array();
		$temp_array[$provost]=$provost;
		for($apno=0;$apno<4;$apno++){
			if($a_provost[$apno]=='')
				continue;
			foreach($temp_array as $x => $x_value)
			if($a_provost[$apno] == $x_value){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Multiple Entry for different position";
				$error_found=true;
			}
			$temp_array[$a_provost[$apno]]=$a_provost[$apno];
		}

		

		if($hall_assistant!=''){
			if(!is_numeric($hall_assistant)){
				$_SESSION['au_hall_assistant_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($hall_assistant)!=5){
				$_SESSION['au_hall_assistant_error']="Length of Hall Assistant ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($hall_assistant)){
				$_SESSION['au_hall_assistant_error']="Invalid Hall Assistant ID";
				$error_found=true;
			}
			
		}
		
		foreach($temp_array as $x => $x_value)
			if($hall_assistant==$x_value){
				$_SESSION['au_hall_assistant_error']="Multiple Entry for different position";
				$error_found=true;	
			}


		if($error_found){
			header("Location: ../admin-panel/?tab=hallManagement&action=add");
			return;
		}
		
		if($DB->add_new_hall($hall_id, $hall_name, $hall_short_name, $provost, $a_provost, $hall_assistant)){
			$_SESSION['au_success']="Hall added Successfully";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=hallManagement&action=add");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=hallManagement&action=add");
			return;	
		}
	}

	else if(isset($_POST['update_hall_data'])){
		$hall_id = $_SESSION['updating_hall_id'];
		$hall_old_data = $DB->get_hall_info($hall_id);
		$hall_name = input_filter($_POST['hall_name']);
		$hall_short_name = input_filter($_POST['hall_short_name']);
		$provost = input_filter($_POST['provost']);
		$apno=0;
		for($apno=0;$apno<4;$apno++)
			$a_provost[$apno] = input_filter($_POST['a_provost_'.($apno+1)]);
		$hall_assistant=input_filter($_POST['hall_assistant']);
		
		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['hall_id']=$hall_id;
		$_SESSION['au_old_value']['hall_name']=$hall_name;
		$_SESSION['au_old_value']['hall_short_name']=$hall_short_name;
		$_SESSION['au_old_value']['provost']=$provost;
		$_SESSION['au_old_value']['hall_assistant']=$hall_assistant;
		for($apno=0;$apno<4;$apno++)
			$_SESSION['au_old_value']['a_provost_'.($apno+1)]=$a_provost[$apno];

		$error_found=false;


		if($hall_name==''){
			$_SESSION['au_hall_name_error']="Enter Hall Name";
			$error_found=true;
		}
		else{
			if($DB->is_valid_hall_name($hall_name) && $hall_name!=$hall_old_data['name']){
				$_SESSION['au_hall_name_error']="Duplicate Hall Name";
				$error_found=true;
			}
		}
		
		if($hall_short_name==''){
			$_SESSION['au_hall_short_name_error']="Enter Hall Short Name";
			$error_found=true;
		}
		else{
			if($DB->is_valid_hall_short_name($hall_short_name) && $hall_short_name!=$hall_old_data['short_name']){
				$_SESSION['au_hall_short_name_error']="Duplicate Hall Short Name";
				$error_found=true;
			}
		}
		

		if($provost!=''){
			if(!is_numeric($provost)){
				$_SESSION['au_provost_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($provost)!=5){
				$_SESSION['au_provost_error']="Length of Provost ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($provost)){
				$_SESSION['au_provost_error']="Invalid Provost ID";
				$error_found=true;
			}
			
		}

		for($apno=0;$apno<4;$apno++){
			if($a_provost[$apno]=='')
				continue;
			if(!is_numeric($a_provost[$apno])){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($a_provost[$apno])!=5){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Length of Assistant Provost ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($a_provost[$apno])){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Invalid Assistant Provost ID";
				$error_found=true;
			}
		}
		$temp_array=array();
		$temp_array[$provost]=$provost;
		for($apno=0;$apno<4;$apno++){
			if($a_provost[$apno]=='')
				continue;
			foreach($temp_array as $x => $x_value)
			if($a_provost[$apno] == $x_value){
				$_SESSION['au_a_provost_'.($apno+1).'_error']="Multiple Entry for different position";
				$error_found=true;
			}
			$temp_array[$a_provost[$apno]]=$a_provost[$apno];
		}

		

		if($hall_assistant!=''){
			if(!is_numeric($hall_assistant)){
				$_SESSION['au_hall_assistant_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($hall_assistant)!=5){
				$_SESSION['au_hall_assistant_error']="Length of Hall Assistant ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_admin_user($hall_assistant)){
				$_SESSION['au_hall_assistant_error']="Invalid Hall Assistant ID";
				$error_found=true;
			}
			
		}
		
		foreach($temp_array as $x => $x_value)
			if($hall_assistant==$x_value){
				$_SESSION['au_hall_assistant_error']="Multiple Entry for different position";
				$error_found=true;	
			}


		if($error_found){
			header("Location:../admin-panel/?tab=hallManagement&action=edit&hall_id=".$hall_id);
			return;
		}

		if($DB->update_hall_information($hall_id, $hall_name, $hall_short_name, $provost, $a_provost, $hall_assistant)){
			unset($_SESSION['au_old_value']);
			$_SESSION['hall_info_updated']="Hall Information Updated";
			header("Location: ../admin-panel/?tab=hallManagement");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=hallManagement&action=edit&hall_id=".$hall_id);
			return;	
		}


	}
	else if(isset($_POST['delete_hall'])){
		$hall_id=$_SESSION['deleting_hall_id'];

		if($DB->delete_hall($hall_id)){
			$_SESSION['au_delete_success']="Hall Deleted";
			unset($_SESSION['deleting_hall_id']);	
			header("Location: ../admin-panel/?tab=hallManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=hallManagement");
			return;	
		}
	}
	
	else
		header("Location: ../");
?>