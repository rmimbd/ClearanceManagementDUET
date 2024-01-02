<?php
	require ("../databaseserver.php");
	if(isset($_POST['add_new_student'])){
		$student_id = input_filter($_POST['student_id']);
		$student_name = input_filter($_POST['student_name']);
		$department = input_filter($_POST['department_id']);
		$year_semester = input_filter($_POST['year_semester']);
		$session = input_filter($_POST['session']);
		$admission_year = input_filter($_POST['admission_year']);
		$advisor = input_filter($_POST['advisor']);
		$thesis_supervisor = input_filter($_POST['thesis_supervisor']);
		$gender = input_filter($_POST['gender']);
		$hall_id = input_filter($_POST['hall_id']);
		$hall_room_no = input_filter($_POST['hall_room_no']);
		$student_email = input_filter($_POST['student_email']);
		$student_phone = input_filter($_POST['student_phone']);
		$student_username = input_filter($_POST['student_username']);
		$student_password = input_filter($_POST['student_password']);
		

		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['student_id']=$student_id;
		$_SESSION['au_old_value']['student_name']=$student_name;
		$_SESSION['au_old_value']['department_id']=$department;
		$_SESSION['au_old_value']['year_semester']=$year_semester;
		$_SESSION['au_old_value']['session']=$session;
		$_SESSION['au_old_value']['admission_year']=$admission_year;
		$_SESSION['au_old_value']['advisor']=$advisor;
		$_SESSION['au_old_value']['thesis_supervisor']=$thesis_supervisor;
		$_SESSION['au_old_value']['gender']=$gender;
		$_SESSION['au_old_value']['hall_id']=$hall_id;
		$_SESSION['au_old_value']['hall_room_no']=$hall_room_no;
		$_SESSION['au_old_value']['student_email']=$student_email;
		$_SESSION['au_old_value']['student_phone']=$student_phone;
		$_SESSION['au_old_value']['student_username']=$student_username;
		$_SESSION['au_old_value']['student_password']=$student_password;


		$error_found=false;

		if(!is_numeric($student_id)){
			$_SESSION['au_student_id_error']="Invalid Student ID. Only numeric value is valid.";
			$error_found=true;
		}
		else if($student_id<=0 || ($student_id%1000)>124){
			$_SESSION['au_student_id_error']="Invalid Student ID";
			$error_found=true;
		}
		else if($DB->is_valid_student_id($student_id)){
			$_SESSION['au_student_id_error']="Duplicate Student ID";
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
		if(!isset($_SESSION['au_student_id_error']) && !isset($_SESSION['au_department_id_error'])){
			if(strlen($department)==1){
				if($department!=$student_id[-4]){
					$_SESSION['au_department_id_error']="Student ID and Department are contradictory";
					$_SESSION['au_student_id_error']="Student ID and Department are contradictory";
				}
			}
		}


		if($year_semester==0){
			$_SESSION['au_year_semester_error']="Please Select Year/Semester";
			$error_found=true;
		}
		else if(!($year_semester== 12 || $year_semester== 21 || $year_semester== 22 || $year_semester== 31 || $year_semester== 32 || $year_semester== 41 || $year_semester== 42 || ($year_semester== 51 && $department==6) || ($year_semester== 52 && $department==6))){
			$_SESSION['au_year_semester_error']="Invalid Year/Semester";
			$error_found=true;
		}

		if($session!=''){
			if(strlen($session)!=9){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}
			else if($session[4]!='-'){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}			
			else if(!is_numeric(substr($session,0,4)) || !is_numeric(substr($session,5,9))){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}
			else if(substr($session,0,4)+1!=substr($session,5,9)){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}

		}

		if(!is_numeric($admission_year)){
			$_SESSION['au_admission_year_error']="Invalid Admission Year";
			$error_found=true;
		}
		else if(strlen($admission_year)!=4){
			$_SESSION['au_admission_year_error']="Invalid Admission Year";
			$error_found=true;
		}
		else if($admission_year>substr($session,5,9) && $session!=''){
			$_SESSION['au_admission_year_error']="Session and Admission Year are contradictory";
			$_SESSION['au_session_error']="Session and Admission Year are contradictory";
			$error_found=true;
		}
		

		if($advisor!=''){
			if(!is_numeric($advisor)){
				$_SESSION['au_advisor_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($advisor)!=5){
				$_SESSION['au_advisor_error']="Length of Advisor ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_teacher($advisor)){
				$_SESSION['au_advisor_error']="Invalid Advisor ID";
				$error_found=true;
			}
			
		}

		if($thesis_supervisor!=''){
			if(!is_numeric($thesis_supervisor)){
				$_SESSION['au_thesis_supervisor_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($thesis_supervisor)!=5){
				$_SESSION['au_thesis_supervisor_error']="Length of Thesis Supervisor ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_teacher($thesis_supervisor)){
				$_SESSION['au_thesis_supervisor_error']="Invalid Thesis Supervisor ID";
				$error_found=true;
			}
			
		}

		if($gender==0){
			$_SESSION['au_gender_error']="Please Select Gender";
			$error_found=true;
		}
		else if($gender!=1 && $gender!=2){
			$_SESSION['au_gender_error']="Invalid Gender Value";
			$error_found=true;
		}
		
		if($hall_id!=0){
			if(!$DB->is_valid_hall_id($hall_id)){
				$_SESSION['au_hall_id_error']="Invalid Hall";
				$error_found=true;
			}
			else if($hall_id==6 && $gender!=2){
				$_SESSION['au_hall_id_error']="This Hall is specialized only for Female Students.";
				$error_found=true;	
			}
		}
		else{
			$_SESSION['au_hall_id_error']="Please Select Hall";
			$error_found=true;
		}

		if($hall_room_no!=''){
			if(!is_numeric($hall_room_no)){
				$_SESSION['au_hall_room_no_error']="Invalid Room Number.";
				$error_found=true;
			}
			else if(strlen($hall_room_no)<3 ||strlen($hall_room_no)>5){
				$_SESSION['au_hall_room_no_error']="Invalid Room Number.";
				$error_found=true;
			}
		}


		if($student_email!=''){
			if($DB->is_duplicate_user_email($student_email)){
				$_SESSION['au_email_error']="Duplicate entry of email";
				$error_found=true;		
			}
		}
		if($student_phone!=''){
			if($DB->is_duplicate_user_phone($student_phone)){
				$_SESSION['au_phone_error']="Duplicate entry of phone";
				$error_found=true;		
			}
		}
		if($student_username!=''){
			if($DB->is_valid_username($student_username)){
				$_SESSION['au_username_error']="Username Already Assigned";
				$error_found=true;		
			}
		}
		if($error_found){
			header("Location: ../admin-panel/?tab=studentManagement&action=add");
			return;
		}
		
		if($DB->add_new_student_user($student_id, $student_name, $department, $year_semester, $session, $admission_year, $advisor, $thesis_supervisor, $gender, $hall_id, $hall_room_no, $student_email, $student_phone, $student_username, $student_password)){
			$_SESSION['au_success']="Student added Successfully";
			unset($_SESSION['au_old_value']);
			header("Location: ../admin-panel/?tab=studentManagement&action=add");
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=studentManagement&action=add");
			return;	
		}
	}

	else if(isset($_POST['update_student_data'])){
		$student_id = $_SESSION['updating_student_id'];
		$student_name = input_filter($_POST['student_name']);
		$department = input_filter($_POST['department_id']);
		$year_semester = input_filter($_POST['year_semester']);
		$session = input_filter($_POST['session']);
		$admission_year = input_filter($_POST['admission_year']);
		$advisor = input_filter($_POST['advisor']);
		$thesis_supervisor = input_filter($_POST['thesis_supervisor']);
		$gender = input_filter($_POST['gender']);
		$hall_id = input_filter($_POST['hall_id']);
		$hall_room_no = input_filter($_POST['hall_room_no']);
		$student_email = input_filter($_POST['student_email']);
		$student_phone = input_filter($_POST['student_phone']);
		$student_username = input_filter($_POST['student_username']);
		$student_password = input_filter($_POST['student_password']);
		


		$_SESSION['au_old_value']=array();
		$_SESSION['au_old_value']['student_id']=$student_id;
		$_SESSION['au_old_value']['student_name']=$student_name;
		$_SESSION['au_old_value']['department_id']=$department;
		$_SESSION['au_old_value']['year_semester']=$year_semester;
		$_SESSION['au_old_value']['session']=$session;
		$_SESSION['au_old_value']['admission_year']=$admission_year;
		$_SESSION['au_old_value']['advisor']=$advisor;
		$_SESSION['au_old_value']['thesis_supervisor']=$thesis_supervisor;
		$_SESSION['au_old_value']['gender']=$gender;
		$_SESSION['au_old_value']['hall_id']=$hall_id;
		$_SESSION['au_old_value']['hall_room_no']=$hall_room_no;
		$_SESSION['au_old_value']['student_email']=$student_email;
		$_SESSION['au_old_value']['student_phone']=$student_phone;
		$_SESSION['au_old_value']['student_username']=$student_username;
		$_SESSION['au_old_value']['student_password']=$student_password;

		$old_info=$DB->get_all_information_of_student($student_id);
		$error_found=false;

		
		
		if($department==0){
			$_SESSION['au_department_id_error']="Please Select Department";
			$error_found=true;
		}
		else if(!$DB->is_valid_department_id($department)){
			$_SESSION['au_department_id_error']="Invalid Department";
			$error_found=true;
		}
		if(!isset($_SESSION['au_student_id_error']) && !isset($_SESSION['au_department_id_error'])){
			if(strlen($department)==1){
				if($department!=$student_id[-4]){
					$_SESSION['au_department_id_error']="Student ID and Department are contradictory";
					$_SESSION['au_student_id_error']="Student ID and Department are contradictory";
				}
			}
		}


		if($year_semester==0){
			$_SESSION['au_year_semester_error']="Please Select Year/Semester";
			$error_found=true;
		}
		else if(!($year_semester== 12 || $year_semester== 21 || $year_semester== 22 || $year_semester== 31 || $year_semester== 32 || $year_semester== 41 || $year_semester== 42 || ($year_semester== 51 && $department==6) || ($year_semester== 52 && $department==6))){
			$_SESSION['au_year_semester_error']="Invalid Year/Semester";
			$error_found=true;
		}

		if($session!=''){
			if(strlen($session)!=9){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}
			else if($session[4]!='-'){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}			
			else if(!is_numeric(substr($session,0,4)) || !is_numeric(substr($session,5,9))){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}
			else if(substr($session,0,4)+1!=substr($session,5,9)){
				$_SESSION['au_session_error']="Invalid Session";
				$error_found=true;
			}

		}
		else
			$session=NULL;

		if(!is_numeric($admission_year)){
			$_SESSION['au_admission_year_error']="Invalid Admission Year";
			$error_found=true;
		}
		else if(strlen($admission_year)!=4){
			$_SESSION['au_admission_year_error']="Invalid Admission Year";
			$error_found=true;
		}
		else if($admission_year>substr($session,5,9) && $session!=''){
			$_SESSION['au_admission_year_error']="Session and Admission Year are contradictory";
			$_SESSION['au_session_error']="Session and Admission Year are contradictory";
			$error_found=true;
		}
		

		if($advisor!=''){
			if(!is_numeric($advisor)){
				$_SESSION['au_advisor_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($advisor)!=5){
				$_SESSION['au_advisor_error']="Length of Advisor ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_teacher($advisor)){
				$_SESSION['au_advisor_error']="Invalid Advisor ID";
				$error_found=true;
			}
		}

		if($thesis_supervisor!=''){
			if(!is_numeric($thesis_supervisor)){
				$_SESSION['au_thesis_supervisor_error']="Enter only numeric ID";
				$error_found=true;
			}
			else if(strlen($thesis_supervisor)!=5){
				$_SESSION['au_thesis_supervisor_error']="Length of Thesis Supervisor ID must be 5";
				$error_found=true;
			}
			else if(!$DB->is_valid_teacher($thesis_supervisor)){
				$_SESSION['au_thesis_supervisor_error']="Invalid Thesis Supervisor ID";
				$error_found=true;
			}
			
		}

		if($gender==0){
			$_SESSION['au_gender_error']="Please Select Gender";
			$error_found=true;
		}
		else if($gender!=1 && $gender!=2){
			$_SESSION['au_gender_error']="Invalid Gender Value";
			$error_found=true;
		}
		
		if($hall_id!=0){
			if(!$DB->is_valid_hall_id($hall_id)){
				$_SESSION['au_hall_id_error']="Invalid Hall";
				$error_found=true;
			}
			else if($hall_id==6 && $gender!=2){
				$_SESSION['au_hall_id_error']="This Hall is specialized only for Female Students.";
				$error_found=true;	
			}
		}

		if($hall_room_no!=''){
			if(!is_numeric($hall_room_no)){
				$_SESSION['au_hall_room_no_error']="Invalid Room Number.";
				$error_found=true;
			}
			else if(strlen($hall_room_no)<3 ||strlen($hall_room_no)>5){
				$_SESSION['au_hall_room_no_error']="Invalid Room Number.";
				$error_found=true;
			}
		}


		if($student_email!='' && $student_email!=$old_info['email']){
			if($DB->is_duplicate_user_email($student_email)){
				$_SESSION['au_email_error']="Duplicate entry of email";
				$error_found=true;		
			}
		}
		if($student_phone!='' && $student_phone!=$old_info['phone']){
			if($DB->is_duplicate_user_phone($student_phone)){
				$_SESSION['au_phone_error']="Duplicate entry of phone";
				$error_found=true;		
			}
		}
		if($student_username!='' && $student_username!=$old_info['username']){
			if($DB->is_valid_username($student_username)){
				$_SESSION['au_username_error']="Username Already Assigned";
				$error_found=true;		
			}
		}
		if($error_found){
			header("Location: ../admin-panel/?tab=studentManagement&action=edit&student_id=".$student_id);
			return;
		}

		if($DB->update_student_information($student_id, $student_name, $department, $year_semester, $session, $admission_year, $advisor, $thesis_supervisor, $gender, $hall_id, $hall_room_no, $student_email, $student_phone, $student_username, $student_password)){
			unset($_SESSION['au_old_value']);
			$_SESSION['au_success']="Information Updated";
			header("Location: ../admin-panel/?tab=studentManagement&action=details&student_id=".$student_id);
			return;
		}
		else{
			$_SESSION['au_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=studentManagement&action=edit&student_id=".$student_id);
			return;	
		}


	}
	else if(isset($_POST['delete_student'])){
		$student_id=$_SESSION['deleting_student_id'];

		if($DB->delete_student($student_id)){
			$_SESSION['au_delete_success']="student Deleted";
			unset($_SESSION['deleting_student_id']);	
			header("Location: ../admin-panel/?tab=studentManagement");
			return;
		}
		else{
			$_SESSION['au_delete_error']="Error occurred.<br>Please try again";
			header("Location: ../admin-panel/?tab=studentManagement");
			return;	
		}
	}
	
	else
		header("Location: ../");
?>