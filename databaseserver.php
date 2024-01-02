<?php
	if(!isset($_SESSION)) {
    	session_start();
	}

	function input_filter($testData){
		$testData=htmlspecialchars($testData);
		$testData=stripslashes($testData);
		$testData=stripcslashes($testData);
		return $testData;
	}

	class Admin{
		public $user_id;
		public $username;
		public $email;
		public $phone;
		public $name;
		public $designation;
		public $office;
		public $office_loc;
		public $user_type;
		public $user_type_number;
		public $approver_level;
		public $account_status;
		function __construct(){
			$this->user_type="admin";
			$this->user_type_number=2;
		}
		function set_data($user_id, $username, $email, $phone, $name, $designation, $office, $office_id, $office_loc, $approver_level) {
		    $this->user_id = $user_id;
		    $this->username = $username;
		    $this->email = $email;
		    $this->phone = $phone;
		    $this->name = $name;
		    $this->designation = $designation;
		    $this->office = $office;
		    $this->office_id = $office_id;
		    $this->office_loc = $office_loc;
		    $this->approver_level = $approver_level;
		}
	}

	class Student{
		public $student_id;
		public $username;
		public $email;
		public $phone;
		public $name;
		public $department;
		public $year;
		public $semester;
		public $user_type;
		public $user_type_number;
		function __construct(){
			$this->user_type="student";
			$this->user_type_number=1;
		}
		function set_data($user_id, $username, $email, $phone, $name, $department, $year, $semester) {
		    $this->student_id = $user_id;
		    $this->username = $username;
		    $this->email = $email;
		    $this->phone = $phone;
		    $this->name = $name;
		    $this->department = $department;
		    $this->year = $year;
		    $this->semester = $semester;
		}
	}

	class Database{
		private $conn;
		public $current_user;

	  	function __construct() {
		    $this->conn = mysqli_connect("localhost","root","","dcms");
		}

		function validate_login($userId, $userPassword){
			$userPassword=md5($userPassword);
			$query=mysqli_query($this->conn, "SELECT user_id FROM users WHERE ((user_id='$userId' OR username='$userId') AND password='$userPassword')");
			if(mysqli_num_rows($query)==1)
				return true;
			else
				return false;
		}

		function get_user_type($userId){
			$query=mysqli_query($this->conn, "SELECT user_type FROM users WHERE (user_id='$userId' OR username='$userId')");
			
			$row=mysqli_fetch_array($query);
			$user_type=NULL;
			switch ($row['user_type']) {
				case 1:
					$user_type='student';
					break;
				
				default:
					$user_type='admin';
					break;
			}
			return $user_type;
		}

		function get_user_data($userId){
			$query=mysqli_query($this->conn, "SELECT user_id, username, user_type, phone, email FROM users WHERE (user_id='$userId' OR username='$userId')");
			
			$user_data=mysqli_fetch_array($query);
			if($user_data['user_type']==1)
				$user_data['user_type']="student";
			else if($user_data['user_type']==2)
				$user_data['user_type']="admin";
			else if($user_data['user_type']==0)
				$user_data['user_type']="superAdmin";
			return $user_data;
		}

		function get_admin_data($user_id){
			$query=mysqli_query($this->conn, "SELECT * FROM admin WHERE user_id='$user_id'");
			return mysqli_fetch_array($query);
		}


		function get_all_information_of_admin($user_id){
			$query=mysqli_query($this->conn, "SELECT a.user_id, name, designation, office_id,username, email, phone, active FROM admin a, users u WHERE a.user_id='$user_id' and a.user_id=u.user_id");
			return mysqli_fetch_array($query);
		}

		function get_all_information_of_student($student_id){
			$query=mysqli_query($this->conn, "SELECT * FROM student s, users u WHERE s.student_id='$student_id' and s.student_id=u.user_id");
			return mysqli_fetch_array($query);
		}

		function get_all_information_of_lab($lab_id){
			$query=mysqli_query($this->conn, "SELECT * FROM labs WHERE lab_id='$lab_id'");
			return mysqli_fetch_array($query);
		}


		function get_approver_level($user_id){
			$query=mysqli_query($this->conn, "SELECT level FROM approver WHERE approver_id='$user_id'");
			
			if(mysqli_num_rows($query)==0)
				return -1;
			$row=mysqli_fetch_array($query);
			return $row['level'];
		}

		function update_department_information($department_id, $department_name){
			try{
				mysqli_query($this->conn, "UPDATE department SET department_name='$department_name' WHERE department_id='$department_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function update_approver_information($approver_id, $approver_type){
			try{
				mysqli_query($this->conn, "UPDATE approver SET level='$approver_type' WHERE approver_id='$approver_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function delete_approver($approver_id){
			try{
				mysqli_query($this->conn, "DELETE FROM approver WHERE approver_id='$approver_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}	
		}

		function get_all_special_approver(){
			$query=mysqli_query($this->conn, "SELECT * FROM approver");
			return $query;
		}


		function get_approver_categories(){
			$query=mysqli_query($this->conn, "SELECT * FROM approver_category");
			return $query;
		}


		function get_approver_type($level){
			$query=mysqli_query($this->conn, "SELECT type FROM approver_category WHERE level='$level'");
			return mysqli_fetch_array($query)['type'];
		}

		

		function initialize_user($userId){
			$user_data=$this->get_user_data($userId);
			$userId=$user_data['user_id'];
			$additional_data=NULL;
			if($user_data['user_type']=="admin"){
				$query=mysqli_query($this->conn, "SELECT name, designation, o.office_id, office_name, office_loc FROM admin a, office o WHERE (a.user_id='$userId' and a.office_id=o.office_id)");
				$additional_data=mysqli_fetch_array($query);
				$approver_level = $this->get_approver_level($userId);
				$_SESSION['DCMS_user']=new Admin();
				$_SESSION['DCMS_user']->set_data($userId, $user_data['username'], $user_data['email'], $user_data['phone'], $additional_data['name'], $additional_data['designation'], $additional_data['office_name'],$additional_data['office_id'], $additional_data['office_loc'], $approver_level);
				$this->current_user=$_SESSION['DCMS_user'];

			}
			else if($user_data['user_type']=="student"){
				$query=mysqli_query($this->conn, "SELECT student_id, name, department_name, current_year, current_semester FROM student s, department d WHERE (s.student_id='$userId' and s.department_id=d.department_id)");
				$additional_data=mysqli_fetch_array($query);
				
				$_SESSION['DCMS_user']=new Student();
				$_SESSION['DCMS_user']->set_data($userId, $user_data['username'], $user_data['email'], $user_data['phone'], $additional_data['name'], $additional_data['department_name'], $additional_data['current_year'], $additional_data['current_semester']);
				$this->current_user=$_SESSION['DCMS_user'];
			}

			else if($user_data['user_type']=="superAdmin"){
				$query=mysqli_query($this->conn, "SELECT name, designation, o.office_id, office_name, office_loc FROM admin a, office o WHERE (a.user_id='$userId' and a.office_id=o.office_id)");
				$additional_data=mysqli_fetch_array($query);
				$_SESSION['DCMS_user']=new Admin();
				$_SESSION['DCMS_user']->set_data($userId, $user_data['username'], $user_data['email'], $user_data['phone'], $additional_data['name'], $additional_data['designation'], $additional_data['office_name'],$additional_data['office_id'], $additional_data['office_loc'], NULL);
				$_SESSION['DCMS_user']->user_type="superAdmin";
				$this->current_user=$_SESSION['DCMS_user'];
			}
			
		}

		function is_valid_admin_user($user_id){
			$query=mysqli_query($this->conn, "SELECT user_id FROM admin WHERE user_id='$user_id'");
			return mysqli_num_rows($query)>0;
		}

		function is_valid_teacher($user_id){
			$query=mysqli_query($this->conn, "SELECT user_id FROM admin WHERE user_id='$user_id' and office_id between 1 and 19");
			return mysqli_num_rows($query)>0;
		}

		function is_valid_username($username){
			$query=mysqli_query($this->conn, "SELECT user_id FROM users WHERE username='$username'");
			return mysqli_num_rows($query)>0;
		}

		function is_duplicate_user_email($email){
			$query=mysqli_query($this->conn, "SELECT user_id FROM users WHERE email='$email'");
			return mysqli_num_rows($query)>0;
		}

		function is_duplicate_user_phone($phone){
			$query=mysqli_query($this->conn, "SELECT user_id FROM users WHERE phone='$phone'");
			return mysqli_num_rows($query)>0;
		}

		function is_valid_hall_id($hall_id){
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls WHERE hall_id='$hall_id'");
			return mysqli_num_rows($query)>0;
		}

		function is_valid_hall_name($hall_name){
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls WHERE name='$hall_name'");
			return mysqli_num_rows($query)>0;
		}

		function is_valid_hall_short_name($hall_short_name){
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls WHERE short_name='$hall_short_name'");
			return mysqli_num_rows($query)>0;
		}


		function is_duplicate_lab_name($lab_name, $department){
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE name='$lab_name' and department='$department'");
			return mysqli_num_rows($query)>0;
		}

		function is_valid_lab_id($lab_id){
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE lab_id='$lab_id'");
			return mysqli_num_rows($query)>0;
		}


		function is_valid_department_id($department_id){
			$query=mysqli_query($this->conn, "SELECT department_id FROM department WHERE department_id='$department_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}


		function is_valid_department_name($department_name){
			$query=mysqli_query($this->conn, "SELECT department_id FROM department WHERE department_name='$department_name'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}


		function add_new_admin_user($user_id, $user_name, $designation, $office_id, $user_username, $user_password, $user_email, $user_phone){
			if(mysqli_query($this->conn, "INSERT INTO admin(user_id,name,designation,office_id) VALUES('$user_id', '$user_name', '$designation', '$office_id')")){
				if($user_password!='')
					$user_password=md5($user_password);
				if(mysqli_query($this->conn, "UPDATE users SET username='$user_username',password='$user_password',email='$user_email', phone='$user_phone' WHERE user_id='$user_id'")){
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			return true;
		}

		function add_new_student_user($student_id, $student_name, $department_id, $year_semester, $session, $admission_year, $advisor, $thesis_supervisor, $gender, $hall_id, $hall_room_no, $email, $phone, $username, $password){
			try{
				$curr_year=$year_semester[0];
				$curr_sem=$year_semester[1];
				mysqli_query($this->conn, "INSERT INTO student(student_id,name,gender,department_id,current_year,current_semester,session,admission_year) VALUES('$student_id', '$student_name', '$gender', '$department_id', '$curr_year', '$curr_sem', '$session', '$admission_year')");
				if($advisor!='')
					mysqli_query($this->conn,"UPDATE student SET advisor='$advisor' WHERE student_id='$student_id'");
				if($thesis_supervisor!='')
					mysqli_query($this->conn,"UPDATE student SET thesis_supervisor='$thesis_supervisor' WHERE student_id='$student_id'");
				if($hall_id!=0)
					mysqli_query($this->conn,"UPDATE student SET hall='$hall_id' WHERE student_id='$student_id'");
				if($hall_room_no!='')
					mysqli_query($this->conn,"UPDATE student SET hall_room_number='$hall_room_no' WHERE student_id='$student_id'");
				if($username!='')
					mysqli_query($this->conn, "UPDATE users SET username='$username' WHERE user_id='$student_id'");
				if($password!=''){
					$password=md5($password);
					mysqli_query($this->conn, "UPDATE users SET password='$password' WHERE user_id='$student_id'");
				}
				if($email!='')
					mysqli_query($this->conn, "UPDATE users SET email='$email' WHERE user_id='$student_id'");
				if($phone!='')
					mysqli_query($this->conn, "UPDATE users SET phone='$phone' WHERE user_id='$student_id'");
				
				return true;
			}
			catch(Exception $e){
				die($e);
				return false;
			}
		}

		function add_new_hall($hall_id,$hall_name,$hall_short_name,$provost,$a_provost_list,$hall_assistant){
			try{
				mysqli_query($this->conn, "INSERT INTO halls(hall_id,name,short_name) VALUES('$hall_id', '$hall_name', '$hall_short_name')");

				if($provost!='')
					mysqli_query($this->conn, "UPDATE halls SET provost='$provost' WHERE hall_id='$hall_id'");
				for($i=0;$i<4;$i++){
					$a_provost='a_provost'.($i+1);
					if($a_provost_list[$i]!=''){
						$id=$a_provost_list[$i];
						mysqli_query($this->conn, "UPDATE halls SET $a_provost='$id' WHERE hall_id='$hall_id'");
					}
				}
				if($hall_assistant!='')
					mysqli_query($this->conn, "UPDATE halls SET a_section_officer='$hall_assistant' WHERE hall_id='$hall_id'");
				
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function get_new_lab_id_of_department($department){
			$maxlabid=mysqli_query($this->conn,"SELECT MAX(lab_id) as maxlabid FROM labs WHERE department='$department'");
			$maxlabid=mysqli_fetch_array($maxlabid)['maxlabid'];
			if($maxlabid)
				return $maxlabid+1;
			else{
				if(intdiv($department,10)==0)
					return $department.'001';
				else
					return $department.'01';
			}
		}

		function add_new_lab($lab_id, $lab_name, $department, $lab_assistant, $lab_incharge){
			try{
				mysqli_query($this->conn,"INSERT INTO labs(lab_id, department, name) VALUES('$lab_id','$department', '$lab_name')");
				if($lab_assistant!='')
					mysqli_query($this->conn,"UPDATE labs SET assistant='$lab_assistant' WHERE lab_id='$lab_id'");
				if($lab_incharge!='')
					mysqli_query($this->conn,"UPDATE labs SET officer='$lab_incharge' WHERE lab_id='$lab_id'");
				return true;

			}
			catch(Exception $e){
				return false;
			}
		}


		function update_lab_information($lab_id,$lab_name,$department,$lab_assistant,$lab_incharge){
			try{
				mysqli_query($this->conn,"UPDATE labs SET name='$lab_name',department='$department' WHERE lab_id='$lab_id'");
				if($lab_assistant!='')
					mysqli_query($this->conn,"UPDATE labs SET assistant='$lab_assistant' WHERE lab_id='$lab_id'");
				else
					mysqli_query($this->conn,"UPDATE labs SET assistant=NULL WHERE lab_id='$lab_id'");
				if($lab_incharge!='')
					mysqli_query($this->conn,"UPDATE labs SET officer='$lab_incharge' WHERE lab_id='$lab_id'");
				else
					mysqli_query($this->conn,"UPDATE labs SET officer=NULL WHERE lab_id='$lab_id'");
				return true;

			}
			catch(Exception $e){
				die($e);
				return false;
			}
		}

		function get_number_of_student_of_hall($hall_id){
			$query=mysqli_query($this->conn,"SELECT COUNT(*) as nos FROM student WHERE hall='$hall_id'");
			return mysqli_fetch_array($query)['nos'];
		}

		function update_hall_information($hall_id,$hall_name,$hall_short_name,$provost,$a_provost_list,$hall_assistant){
			try{
				mysqli_query($this->conn, "UPDATE halls SET name='$hall_name',short_name='$hall_short_name' WHERE hall_id='$hall_id'");
				if($provost!='')
					mysqli_query($this->conn, "UPDATE halls SET provost='$provost' WHERE hall_id='$hall_id'");
				else
					mysqli_query($this->conn, "UPDATE halls SET provost=NULL WHERE hall_id='$hall_id'");
				
				for($i=0;$i<4;$i++){
					$a_provost='a_provost'.($i+1);
					if($a_provost_list[$i]!=''){
						$id=$a_provost_list[$i];
						mysqli_query($this->conn, "UPDATE halls SET $a_provost='$id' WHERE hall_id='$hall_id'");
					}
					else{
						mysqli_query($this->conn, "UPDATE halls SET $a_provost=NULL WHERE hall_id='$hall_id'");	
					}
				}
				if($hall_assistant!='')
					mysqli_query($this->conn, "UPDATE halls SET a_section_officer='$hall_assistant' WHERE hall_id='$hall_id'");
				else
					mysqli_query($this->conn, "UPDATE halls SET a_section_officer=NULL WHERE hall_id='$hall_id'");
				
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}
		function delete_hall($hall_id){
			try{
				mysqli_query($this->conn,"DELETE FROM halls WHERE hall_id='$hall_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function add_new_office($office_id, $office_name, $admin_head, $head_officer, $office_loc){
			try{
				if($admin_head!='' && $head_officer!=''){
					mysqli_query($this->conn, "INSERT INTO office(office_id,office_name,administrative_head,head_officer,office_loc) VALUES('$office_id', '$office_name', '$admin_head', '$head_officer', '$office_loc')");
				}
				
				else if($admin_head=='' && $head_officer!=''){
					mysqli_query($this->conn, "INSERT INTO office(office_id,office_name,head_officer,office_loc) VALUES('$office_id', '$office_name', '$head_officer', '$office_loc')");
				}
				else if($admin_head!=''&&$head_officer==''){
					mysqli_query($this->conn, "INSERT INTO office(office_id,office_name,admin_head,office_loc) VALUES('$office_id', '$office_name', '$admin_head', '$office_loc')");
				}
				else{
					mysqli_query($this->conn, "INSERT INTO office(office_id,office_name,office_loc) VALUES('$office_id', '$office_name', '$office_loc')");
				}
				
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function update_office_information($office_id, $office_name, $admin_head, $head_officer, $office_loc){
			try{
				if($admin_head!='' && $head_officer!=''){
					mysqli_query($this->conn, "UPDATE office SET office_name='$office_name',administrative_head='$admin_head',head_officer='$head_officer',office_loc='$office_loc' WHERE office_id='$office_id'");
				}
				
				else if($admin_head=='' && $head_officer!=''){
					mysqli_query($this->conn, "UPDATE office SET office_name='$office_name',administrative_head=NULL,head_officer='$head_officer',office_loc='$office_loc' WHERE office_id='$office_id'");
				}
				else if($admin_head!=''&&$head_officer==''){
					mysqli_query($this->conn, "UPDATE office SET office_name='$office_name',administrative_head='$admin_head',head_officer=NULL,office_loc='$office_loc' WHERE office_id='$office_id'");
				}
				else{
					mysqli_query($this->conn, "UPDATE office SET office_name='$office_name',administrative_head=NULL,head_officer=NULL,office_loc='$office_loc' WHERE office_id='$office_id'");
				}
				
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function update_admin_user($user_id, $user_name, $designation, $office_id, $user_username, $user_password, $user_email, $user_phone){
			if(mysqli_query($this->conn, "UPDATE admin SET name='$user_name',designation='$designation',office_id='$office_id' WHERE user_id='$user_id'")){
				if($user_password!=''){
					$user_password=md5($user_password);
					if(mysqli_query($this->conn, "UPDATE users SET username='$user_username',password='$user_password',email='$user_email', phone='$user_phone' WHERE user_id='$user_id'")){
					}
					else{
						return false;
					}
				}
				else{
					if(mysqli_query($this->conn, "UPDATE users SET username='$user_username',email='$user_email', phone='$user_phone' WHERE user_id='$user_id'")){
					}
					else{
						return false;
					}
				}	
			}
			else{
				return false;
			}
			return true;
		}



		function update_student_information($student_id, $student_name, $department, $year_semester, $session, $admission_year, $advisor, $thesis_supervisor, $gender, $hall_id, $hall_room_no, $student_email, $student_phone, $student_username, $student_password){

			$student_old_data=mysqli_fetch_array(mysqli_query($this->conn, "SELECT * FROM student s, users u WHERE s.student_id='$student_id' and s.student_id=u.user_id"));

			if($student_old_data['name'] != $student_name){
				try {
					mysqli_query($this->conn, "UPDATE student SET name='$student_name' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['department_id'] != $department){
				try {
					mysqli_query($this->conn, "UPDATE student SET department_id='$department' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['gender'] != $gender){
				try {
					mysqli_query($this->conn, "UPDATE student SET gender='$gender' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['current_year'] != $year_semester[0]){
				try {
					$current_year_val = $year_semester[0];
					mysqli_query($this->conn, "UPDATE student SET current_year='$current_year_val' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['current_semester'] != $year_semester[1]){
				try {
					$current_sem_val = $year_semester[1];
					mysqli_query($this->conn, "UPDATE student SET current_semester='$current_sem_val' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['session'] != $session){
				try {
					mysqli_query($this->conn, "UPDATE student SET session='$session' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['admission_year'] != $admission_year){
				try {
					mysqli_query($this->conn, "UPDATE student SET admission_year='$admission_year' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['advisor'] != $advisor){
				try {
					mysqli_query($this->conn, "UPDATE student SET advisor='$advisor' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['thesis_supervisor'] != $thesis_supervisor){
				try {
					mysqli_query($this->conn, "UPDATE student SET thesis_supervisor='$thesis_supervisor' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['hall'] != $hall_id){
				try {
					mysqli_query($this->conn, "UPDATE student SET hall='$hall_id' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['hall_room_number'] != $hall_room_no){
				try {
					mysqli_query($this->conn, "UPDATE student SET hall_room_number='$hall_room_no' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			if($student_old_data['hall_room_number'] != $hall_room_no){
				try {
					mysqli_query($this->conn, "UPDATE student SET hall_room_number='$hall_room_no' WHERE student_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}				
			}
			

			if($student_password!=''){
				$student_password=md5($student_password);
				try {
					mysqli_query($this->conn, "UPDATE users SET password='$student_password' WHERE user_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}
			}

			if($student_old_data['username'] != $student_username){
				try {
					mysqli_query($this->conn, "UPDATE users SET username='$student_username' WHERE user_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}
			}
                        if($student_old_data['email'] != $student_email){
				try {
					mysqli_query($this->conn, "UPDATE users SET email='$student_email' WHERE user_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}
			}
			if($student_old_data['phone'] != $student_phone){
				try {
					mysqli_query($this->conn, "UPDATE users SET phone='$student_phone' WHERE user_id='$student_id'");
				} catch (Exception $e) {
					return false;
				}
			}

			return true;
		}

		
		function delete_admin_user($user_id){
			try{
				mysqli_query($this->conn, "UPDATE admin SET active=0 WHERE user_id='$user_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		
		function delete_student($student_id){
			try{
				mysqli_query($this->conn, "DELETE FROM reports WHERE student_id ='$student_id'");
				$clearance_ids=mysqli_query($this->conn, "SELECT clearance_id FROM clearance WHERE student_id='$student_id'");
				while($c_row=mysqli_fetch_array($clearance_ids)){
					$c_id=$c_row['clearance_id'];
					mysqli_query($this->conn, "DELETE FROM labs_approve_log WHERE clearance_id ='$c_id'");
				}
				mysqli_query($this->conn, "DELETE FROM clearance WHERE student_id='$student_id'");
				mysqli_query($this->conn, "DELETE FROM users WHERE user_id='$student_id'");
				mysqli_query($this->conn, "DELETE FROM combined_users WHERE user_id='$student_id'");
				mysqli_query($this->conn, "DELETE FROM student WHERE student_id ='$student_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}
		
		function delete_office($office_id){
			try{
				mysqli_query($this->conn, "UPDATE admin SET office_id=NULL WHERE office_id ='$office_id'");
				mysqli_query($this->conn, "UPDATE reports SET issuer_office=NULL WHERE issuer_office ='$office_id'");
				
				mysqli_query($this->conn, "DELETE FROM office WHERE office_id ='$office_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}
		
		function unrestrict_admin_user($user_id){
			try{
				mysqli_query($this->conn, "UPDATE admin SET active=1 WHERE user_id='$user_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function get_all_admin_user_information(){
			$query=mysqli_query($this->conn, "SELECT * FROM admin WHERE user_id!=1 and active=1");
			return ($query);
		}

		function get_all_teachers_information(){
			$query=mysqli_query($this->conn, "SELECT * FROM admin WHERE user_id!=1 and office_id between 1 and 19");
			return ($query);
		}

		function get_all_officers_information(){
			$query=mysqli_query($this->conn, "SELECT * FROM admin WHERE user_id!=1 and not office_id between 1 and 19");
			return ($query);
		}
		function get_all_restricted_users_information(){
			$query=mysqli_query($this->conn, "SELECT * FROM admin WHERE user_id!=1 and active=0");
			return ($query);
		}
		
		function get_all_lab_information(){
			$query=mysqli_query($this->conn, "SELECT * FROM labs");
			return ($query);
		}

		function get_all_lab_information_of_deartment($department_id){
			$query=mysqli_query($this->conn, "SELECT * FROM labs WHERE department='$department_id'");
			return ($query);
		}

		function get_all_student_user_information(){
			$query=mysqli_query($this->conn, "SELECT * FROM student");
			return ($query);
		}

		function get_information_of_student($student_id){
			$query=mysqli_query($this->conn, "SELECT * FROM student WHERE student_id='$student_id'");
			return mysqli_fetch_array($query);
		}


		function get_login_information_of_user($student_id){
			$query=mysqli_query($this->conn, "SELECT username, email,phone FROM users WHERE user_id='$student_id'");
			return mysqli_fetch_array($query);
		}


		function get_name_of_teacher($user_id){
			$query=mysqli_query($this->conn, "SELECT name FROM admin WHERE user_id='$user_id'");
			return mysqli_fetch_array($query)['name'];
		}

		function get_total_number_of_admin(){
			$query=mysqli_query($this->conn, "SELECT user_id FROM admin WHERE user_id!=1 and active=1");
			return (mysqli_num_rows($query));
		}


		function get_total_number_of_offices(){
			$query=mysqli_query($this->conn, "SELECT office_id FROM office");
			return (mysqli_num_rows($query));
		}

		function get_total_number_of_departments(){
			$query=mysqli_query($this->conn, "SELECT department_id FROM department");
			return (mysqli_num_rows($query));
		}

		function get_total_number_of_halls(){
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls");
			return (mysqli_num_rows($query));
		}

		function get_total_number_of_special_approver(){
			$query=mysqli_query($this->conn, "SELECT approver_id FROM approver");
			return (mysqli_num_rows($query));
		}


		function add_new_department($department_id, $department_name){
			try{
				mysqli_query($this->conn, "INSERT INTO department VALUES('$department_id','$department_name')");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function delete_department($department_id){
			try{
				mysqli_query($this->conn, "DELETE FROM department WHERE department_id='$department_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}
		

		function delete_lab($lab_id){
			try{
				mysqli_query($this->conn, "DELETE FROM labs_approve_log WHERE lab_id='$lab_id'");
				mysqli_query($this->conn, "DELETE FROM labs WHERE lab_id='$lab_id'");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}
		

		function add_new_special_approver($approver_id, $approver_type){
			try{
				mysqli_query($this->conn, "INSERT INTO approver VALUES('$approver_id','$approver_type')");
				return true;
			}
			catch(Exception $e){
				return false;
			}
		}

		function is_duplicate_approver($approver_id){
			$query=mysqli_query($this->conn, "SELECT approver_id FROM approver WHERE approver_id='$approver_id'");
			return (mysqli_num_rows($query)>0);
		}


		function get_total_number_of_labs(){
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs");
			return (mysqli_num_rows($query));
		}



		function get_total_number_of_student(){
			$query=mysqli_query($this->conn, "SELECT student_id FROM student");
			return (mysqli_num_rows($query));
		}


		function get_total_number_of_approved_application(){
			$query=mysqli_query($this->conn, "SELECT clearance_id FROM clearance WHERE final_status=1");
			return (mysqli_num_rows($query));
		}

		function get_total_number_of_pending_application(){
			$query=mysqli_query($this->conn, "SELECT clearance_id FROM clearance WHERE final_status=0");
			return (mysqli_num_rows($query));
		}


		function get_advisor_of_student($student_id){
			$query=mysqli_query($this->conn, "SELECT advisor FROM student WHERE student_id='$student_id'");
			return (mysqli_fetch_array($query)['advisor']);
		}

		function get_office_data($office_id){
			$query=mysqli_query($this->conn, "SELECT * FROM office WHERE office_id='$office_id'");
			return mysqli_fetch_array($query);
		}

		function get_all_office_data(){
			$query=mysqli_query($this->conn, "SELECT * FROM office");
			return $query;
		}

		function get_all_department_data(){
			$query=mysqli_query($this->conn, "SELECT * FROM department");
			return $query;
		}

		function get_number_of_students_of_department($department_id){
			$query=mysqli_query($this->conn, "SELECT COUNT(*) as nos FROM student WHERE department_id='$department_id'");
			return mysqli_fetch_array($query)['nos'];
		}

		function get_number_of_admin_of_department($department_id){
			$query=mysqli_query($this->conn, "SELECT COUNT(*) as nos FROM admin WHERE office_id='$department_id'");
			return mysqli_fetch_array($query)['nos'];
		}

		function get_all_hall_data(){
			$query=mysqli_query($this->conn, "SELECT hall_id,name FROM halls");
			return $query;
		}

		function get_all_hall_info(){
			$query=mysqli_query($this->conn, "SELECT * FROM halls");
			return $query;
		}

		function get_hall_info($hall_id){
			$query=mysqli_query($this->conn, "SELECT * FROM halls WHERE hall_id='$hall_id'");
			return mysqli_fetch_array($query);
		}
		

		function is_valid_office_id($office_id){
			$query=mysqli_query($this->conn, "SELECT * FROM office WHERE office_id='$office_id'");
			return mysqli_num_rows($query)>0;
		}

		function get_new_user_id_of_office($office_id){
			$query=mysqli_query($this->conn, "SELECT MAX(user_id) as uid FROM admin WHERE office_id='$office_id'");
			$max_uid=mysqli_fetch_array($query)['uid'];
			if($max_uid!=NULL){
				return (int)$max_uid+1;
			}
			else
				return $office_id.'0001';
		}

		function get_all_reports_of_office(){
			$office=$this->current_user->office_id;
			$query=mysqli_query($this->conn, "SELECT * FROM reports WHERE (issuer_office='$office' and report_status=1) ORDER BY issue_date DESC");
			return $query;
		}

		function get_all_reports_of_creator(){
			$issuer=$this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT * FROM reports WHERE (issuer='$issuer' and report_status=1) ORDER BY issue_date DESC");
			return $query;
		}

		function get_advising_student_issues(){
			$advisor=$this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT * FROM reports WHERE student_id in (SELECT student_id FROM student WHERE advisor='$advisor') and report_status=1 ORDER BY issue_date DESC");
			return $query;
		}
		
		function advising_student_available(){
			$advisor=$this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT student_id FROM student WHERE advisor='$advisor'");
			if(mysqli_num_rows($query)>0)
				return true;
			else
				return false;
		}

		function supervising_student_available(){
			$supervisor=$this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT student_id FROM student WHERE thesis_supervisor='$supervisor'");
			if(mysqli_num_rows($query)>0)
				return true;
			else
				return false;
		}
		


		function is_valid_student_id($student_id){
			$query=mysqli_query($this->conn, "SELECT student_id FROM student WHERE student_id='$student_id'");
			if(mysqli_num_rows($query)==1)
				return true;
			else
				return false;
		}

		function is_valid_report_id($report_id){
			$query=mysqli_query($this->conn, "SELECT report_id FROM reports WHERE report_id='$report_id'");
			if(mysqli_num_rows($query)==1)
				return true;
			else
				return false;
		}

		function does_report_id_exists($report_id){
			return $this->is_valid_report_id($report_id);
		}

		function issue_new_report($report_id, $student_id, $title, $description, $date_time){
			$issuer = $this->current_user->user_id;
			$office_id = $this->current_user->office_id;
			return mysqli_query($this->conn,"INSERT INTO reports VALUES('$report_id', '$student_id', 
				'$issuer', '$office_id', '$date_time', '$title', '$description', 1)");
		}

		function get_report_data($report_id){
			$query=mysqli_query($this->conn, "SELECT * FROM reports WHERE report_id='$report_id'");
			return mysqli_fetch_array($query);
		}

		function update_report_data($report_id, $title, $description){
			return mysqli_query($this->conn, "UPDATE reports SET title='$title', description='$description' WHERE report_id='$report_id'");
		}


		function mark_report_solved($report_id){
			return mysqli_query($this->conn, "UPDATE reports SET report_status=2 WHERE report_id='$report_id'");
		}

		function mark_report_deleted($report_id){
			return mysqli_query($this->conn, "UPDATE reports SET report_status=3 WHERE report_id='$report_id'");
		}
		

		function match_report_and_student_id($report_id, $student_id){
			$query=mysqli_query($this->conn, "SELECT report_id FROM reports WHERE report_id='$report_id' and student_id='$student_id'");
			if(mysqli_num_rows($query)>0)
				return true;
			else
				return false;
		}

		function match_report_and_office_id($report_id, $office_id){
			$query=mysqli_query($this->conn, "SELECT report_id FROM reports WHERE report_id='$report_id' and issuer_office='$office_id'");
			if(mysqli_num_rows($query)>0)
				return true;
			else
				return false;
		}

		function match_student_and_advisor($student_id, $advisor){
			$query=mysqli_query($this->conn, "SELECT student_id FROM student WHERE advisor='$advisor' and student_id='$student_id'");
			if(mysqli_num_rows($query)==1)
				return true;
			else
				return false;
		}

		function match_student_and_supervisor($student_id, $supervisor){
			$query=mysqli_query($this->conn, "SELECT student_id FROM student WHERE thesis_supervisor='$supervisor' and student_id='$student_id'");
			if(mysqli_num_rows($query)==1)
				return true;
			else
				return false;
		}

		

		function get_report_ids_against_student($student_id){
			$query=mysqli_query($this->conn, "SELECT report_id, title FROM reports WHERE (student_id='$student_id' and report_status=1) ORDER BY issue_date DESC");
			return $query;
		}

		function get_all_reports_against_student($student_id){
			$query=mysqli_query($this->conn, "SELECT report_id, title, issuer_office, report_status FROM reports WHERE (student_id='$student_id') ORDER BY issue_date DESC");
			return $query;
		}

		function get_number_of_reports_from_office_against_student($office_id, $student_id){
			$query=mysqli_query($this->conn, "SELECT report_id FROM reports WHERE (student_id='$student_id' and issuer_office='$office_id' and report_status=1) ORDER BY issue_date DESC");
			return mysqli_num_rows($query);
		}

		function is_allowed_to_apply($student_id){
			$query=mysqli_query($this->conn, "SELECT allowed_to_apply FROM student WHERE student_id='$student_id' and allowed_to_apply=1");
			if(mysqli_num_rows($query)==1)
				return true;
			else
				return false;	
		}

		function submit_new_application($application_id, $student_id){
			mysqli_query($this->conn, "INSERT INTO clearance(clearance_id, student_id) VALUES('$application_id','$student_id')");
			$student_department = $this->get_student_department($student_id);
			$query = mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE department='$student_department'");
			while($lab=mysqli_fetch_array($query)){
				$lab_id=$lab['lab_id'];
				mysqli_query($this->conn, "INSERT INTO labs_approve_log(clearance_id, department_id, lab_id) VALUES('$application_id','$student_department', '$lab_id')");
			}
		}

		function is_clearance_application_submitted($student_id){
			$query=mysqli_query($this->conn, "SELECT student_id FROM clearance WHERE student_id='$student_id' and final_status<=2");
			if(mysqli_num_rows($query)>=1)
				return true;
			else
				return false;	
		}

		function get_application_data($application_id){
			$query=mysqli_query($this->conn, "SELECT * FROM clearance WHERE clearance_id='$application_id'");
			return $query;
		}

		function is_valid_application_id($application_id){
			$query=mysqli_query($this->conn, "SELECT clearance_id FROM clearance WHERE clearance_id='$application_id' and final_status<=2");
			if(mysqli_num_rows($query)==1)
				return true;
			else
				return false;
		}


		function get_application_data_of_student($student_id){
			$query=mysqli_query($this->conn, "SELECT clearance_id, c.student_id as student_id, approved_level, so_exam_controller, aso_hall, provost, labs, aso_department, c.thesis_supervisor as thesis_supervisor, head_department, assistant_dsw, dsw, deputy_exam_controller, final_status, name, name_of_father, name_of_mother, department_id, current_year, current_semester, session, admission_year, hall, hall_room_number FROM clearance as c, student as s WHERE c.student_id='$student_id' and s.student_id=c.student_id");
			return $query;
		}


		function get_application_admin_office_data_of_student($student_id){
			$query=mysqli_query($this->conn, "SELECT exam_controller as s0, comptroller as s1, medical_center as s2, computer_center as s3, physical_edu_center as s4, central_library as s5 FROM clearance as c, student as s WHERE c.student_id='$student_id' and s.student_id=c.student_id");
			return $query;
		}
		
		function get_admin_office_list(){
			$query=mysqli_query($this->conn, "SELECT office_name FROM office WHERE office_id>20 and office_id<=26");
			return $query;
		}

		function is_so_exam_controller(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT approver_id FROM approver WHERE level=1 and approver_id='$user_id'");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;
		}

		function approve_as_so_exam_controller($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET so_exam_controller=1, approved_level=1 WHERE clearance_id='$application_id'");
		}

		function get_all_student_application(){
			$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level FROM clearance WHERE final_status=0 ORDER BY approved_level");
			return $query;
		}

		function is_deputy_exam_controller(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT approver_id FROM approver WHERE level=11 and approver_id='$user_id'");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;
		}

		function get_last_stage_application(){
			$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, final_status FROM clearance WHERE approved_level>=10 ORDER BY final_status, approved_level");
			return $query;
		}

		function get_hall_name($hall_id){
			if($hall_id==NULL)
				return "";
			$query=mysqli_query($this->conn, "SELECT name FROM halls WHERE hall_id='$hall_id'");
			return mysqli_fetch_array($query)['name'];
		}

		function is_hall_admin(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls WHERE provost='$user_id' or a_section_officer='$user_id'");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;
		}

		function is_provost(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls WHERE provost='$user_id'");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;	
		}

		function match_student_hall_provost($student_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls, student WHERE provost='$user_id' and student_id='$student_id' and student.hall=halls.hall_id");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;	
		}

		function match_student_hall_assistant($student_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls, student WHERE a_section_officer='$user_id' and student_id='$student_id' and student.hall=halls.hall_id");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;	
		}

		function is_hall_assistant_section_officer(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT hall_id FROM halls WHERE a_section_officer='$user_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;	
		}

		function get_hall_student_application(){
			$user_id = $this->current_user->user_id;
			$query = NULL;
			if($this->is_provost()){
				$query=mysqli_query($this->conn, "SELECT c.clearance_id, c.student_id, c.approved_level, c.aso_hall, c.provost FROM clearance as c, student as s, halls as h WHERE s.student_id=c.student_id and s.hall=h.hall_id and (h.a_section_officer='$user_id' or h.provost='$user_id') and c.final_status=0 and approved_level>=2 ORDER BY provost");
			}
			else{
				$query=mysqli_query($this->conn, "SELECT c.clearance_id, c.student_id, c.approved_level, c.aso_hall, c.provost FROM clearance as c, student as s, halls as h WHERE s.student_id=c.student_id and s.hall=h.hall_id and (h.a_section_officer='$user_id' or h.provost='$user_id') and c.final_status=0 and approved_level>=1 ORDER BY aso_hall");	
			}
			return $query;
		}


		function approve_as_aso_hall($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET aso_hall=1, approved_level=2 WHERE clearance_id='$application_id'");
		}



		function approve_as_hall_provost($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET provost=1, approved_level=3 WHERE clearance_id='$application_id'");
		}



		function get_supervising_student_application(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT c.clearance_id, c.student_id, c.approved_level FROM clearance as c, student as s WHERE s.student_id=c.student_id and s.thesis_supervisor='$user_id' and c.final_status=0 and approved_level>=5 ORDER BY c.thesis_supervisor");
			return $query;
		}



		function get_department_aso_applications(){
			$user_office = $this->current_user->office_id;
			$query=mysqli_query($this->conn, "SELECT c.clearance_id, c.student_id, c.approved_level FROM clearance as c, student as s WHERE s.student_id=c.student_id and c.final_status=0 and c.approved_level>=4 and s.department_id='$user_office' ORDER BY aso_department");
			return $query;
		}

		function get_department_head_applications(){
			$user_office = $this->current_user->office_id;
			$query=mysqli_query($this->conn, "SELECT c.clearance_id, c.student_id, c.approved_level FROM clearance as c, student as s WHERE s.student_id=c.student_id and c.final_status=0 and c.approved_level>=6 and s.department_id='$user_office' ORDER BY head_department");
			return $query;
		}

		function get_department_application(){
			if($this->is_department_head($this->current_user->office_id)){
				return $this->get_department_head_applications();
			}
			else
				return $this->get_department_aso_applications();
		}
				
		
		
		function get_student_department($student_id){
			$query=mysqli_query($this->conn, "SELECT department_id FROM student WHERE student_id='$student_id'");
			return mysqli_fetch_array($query)['department_id'];
		}

		function get_student_name($student_id){
			$query=mysqli_query($this->conn, "SELECT name FROM student WHERE student_id='$student_id'");
			return mysqli_fetch_array($query)['name'];
		}

		function get_department_name($department_id){
			$query=mysqli_query($this->conn, "SELECT department_name FROM department WHERE department_id='$department_id'");
			$row=mysqli_fetch_array($query);
			return $row['department_name'];
		}


		function is_lab_admin(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE assistant='$user_id' or officer='$user_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}

		function is_lab_assistant(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE assistant='$user_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}

		function is_lab_assistant_of_lab_id($lab_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE assistant='$user_id' and lab_id='$lab_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}

		function is_lab_officer(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE officer='$user_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}
		
		function is_lab_officer_of_lab_id($lab_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT lab_id FROM labs WHERE officer='$user_id' and lab_id='$lab_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}
		
		function get_lab_approval_data($application_id){
			$query=mysqli_query($this->conn, "SELECT * FROM labs_approve_log WHERE clearance_id='$application_id' ORDER BY officer_approved, assistant_approved");
			return $query;
		}
		
		function get_lab_approval_log($application_id){
			$query=mysqli_query($this->conn, "SELECT name, assistant_approved, officer_approved FROM labs_approve_log as lg, labs as l WHERE clearance_id='$application_id' and l.lab_id=lg.lab_id ORDER BY l.lab_id");
			return $query;
		}
		
		function get_lab_application(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT c.clearance_id, student_id, approved_level, l.name as lab_name, lg.lab_id as lab_id, assistant_approved, officer_approved FROM clearance as c, labs_approve_log as lg, labs as l WHERE  final_status=0 and approved_level>=3 and l.lab_id=lg.lab_id and c.clearance_id=lg.clearance_id and (l.assistant='$user_id' or (l.officer='$user_id' and lg.assistant_approved=1)) ORDER BY lg.officer_approved ASC, lg.assistant_approved ASC, lg.sl ASC");
			return $query;

		}


		function approve_as_lab_assistant($application_id, $lab_id){
			mysqli_query($this->conn, "UPDATE labs_approve_log SET assistant_approved=1 WHERE clearance_id='$application_id' and lab_id='$lab_id'");
		}

		function approve_as_lab_officer($application_id, $lab_id){
			mysqli_query($this->conn, "UPDATE labs_approve_log SET officer_approved=1 WHERE clearance_id='$application_id' and lab_id='$lab_id'");
			$query = mysqli_query($this->conn, "SELECT clearance_id FROM labs_approve_log WHERE clearance_id='$application_id' and officer_approved=0");
			if(mysqli_num_rows($query)==0){
				mysqli_query($this->conn, "UPDATE clearance SET labs=1, approved_level=4 WHERE clearance_id='$application_id'");
			}
		}
		



		function is_department_admin(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE (head_officer='$user_id' or administrative_head='$user_id') and office_id>0 and office_id<=20");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;
		}


		function is_administrative_office_admin_of_office($office_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE (head_officer='$user_id' or administrative_head='$user_id') and office_id='$office_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}
		
		

		function is_administrative_head_of_office($office_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE administrative_head='$user_id' and office_id='$office_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}
		
		function is_assistant_head_of_office($office_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE head_officer='$user_id' and office_id='$office_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}

		function approve_as_assistant_head_of_office($application_id, $office_type){
			mysqli_query($this->conn, "UPDATE clearance SET ".$office_type."=1 WHERE clearance_id='$application_id'");
		}

		function approve_as_administrative_head_of_office($application_id, $office_type){
			mysqli_query($this->conn, "UPDATE clearance SET ".$office_type."=2 WHERE clearance_id='$application_id'");
			$query = mysqli_query($this->conn, "SELECT clearance_id FROM clearance WHERE exam_controller=2 and central_library=2 and comptroller=2 and  medical_center=2 and computer_center=2 and  physical_edu_center=2 and clearance_id='$application_id'");
			if(mysqli_num_rows($query)>0){
				mysqli_query($this->conn, "UPDATE clearance SET approved_level=8 WHERE clearance_id='$application_id'");
			}
		}

		function approve_as_aso_department($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET aso_department=1, approved_level=5 WHERE clearance_id='$application_id'");
		}
		

		function approve_as_thesis_supervisor($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET thesis_supervisor=1, approved_level=6 WHERE clearance_id='$application_id'");
		}

		function approve_as_department_head($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET head_department=1, approved_level=7 WHERE clearance_id='$application_id'");
		}
		

		function main_exam_controller_application(){
			if($this->is_assistant_head_of_office(21)){
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, exam_controller FROM clearance WHERE final_status=0 and approved_level>=7 and exam_controller>=0 ORDER BY exam_controller");
				return $query;	
			}
			else{
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, exam_controller FROM clearance WHERE final_status=0 and approved_level>=7 and exam_controller>=1  ORDER BY exam_controller");
				return $query;
			
			}
		}
		
		
		function comptroller_application(){
			if($this->is_administrative_head_of_office(22)){
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, comptroller FROM clearance WHERE final_status=0 and approved_level>=7 and comptroller>=1 ORDER BY comptroller");
				return $query;	
			}
			else{
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, comptroller FROM clearance WHERE final_status=0 and approved_level>=7 and comptroller>=0 ORDER BY comptroller");
				return $query;
			
			}
		}
		


		function is_medical_center_admin(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE (head_officer='$user_id' or administrative_head='$user_id') and office_id=23");
			if(mysqli_num_rows($query)>0){
				return true;
			}
			else
				return false;
		}

		function medical_center_application(){
			if($this->is_administrative_head_of_office(23)){
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, medical_center FROM clearance WHERE final_status=0 and approved_level>=7 and medical_center>=1 ORDER BY medical_center");
				return $query;	
			}
			else{
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, medical_center FROM clearance WHERE final_status=0 and approved_level>=7 and medical_center>=0 ORDER BY medical_center");
				return $query;
			
			}
		}

		function computer_center_application(){
			if($this->is_administrative_head_of_office(24)){
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, computer_center FROM clearance WHERE final_status=0 and approved_level>=7 and computer_center>=1 ORDER BY computer_center");
				return $query;	
			}
			else{
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, computer_center FROM clearance WHERE final_status=0 and approved_level>=7 and computer_center>=0 ORDER BY computer_center");
				return $query;
			
			}
		}

		function physical_education_center_application(){
			if($this->is_administrative_head_of_office(25)){
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, physical_edu_center FROM clearance WHERE final_status=0 and approved_level>=7 and physical_edu_center>=1 ORDER BY physical_edu_center");
				return $query;	
			}
			else{
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, physical_edu_center FROM clearance WHERE final_status=0 and approved_level>=7 and physical_edu_center>=0 ORDER BY physical_edu_center");
				return $query;
			
			}
		}


		function central_library_application(){
			if($this->is_administrative_head_of_office(26)){
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, central_library FROM clearance WHERE final_status=0 and approved_level>=7 and central_library>=1 ORDER BY central_library");
				return $query;	
			}
			else{
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, central_library FROM clearance WHERE final_status=0 and approved_level>=7 and central_library>=0 ORDER BY central_library");
				return $query;
			
			}
		}
		

		function dsw_office_application(){
			if($this->is_administrative_head_of_office(27)){
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, assistant_dsw, dsw FROM clearance WHERE final_status=0 and approved_level>=9 ORDER BY approved_level");
				return $query;	
			}
			else{
				$query=mysqli_query($this->conn, "SELECT clearance_id, student_id, approved_level, assistant_dsw, dsw FROM clearance WHERE final_status=0 and approved_level>=8 ORDER BY approved_level");
				return $query;
			
			}
		}


		function approve_as_assistant_dsw($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET assistant_dsw=1, approved_level=9 WHERE clearance_id='$application_id'");
		}


		function approve_as_dsw($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET dsw=1, approved_level=10 WHERE clearance_id='$application_id'");
		}

		function is_administrative_office_admin(){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE (head_officer='$user_id' or administrative_head='$user_id') and office_id>20");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;
		}


		function is_aso_department($department_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE head_officer='$user_id' and office_id='$department_id'");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;
		}


		function is_department_head($department_id){
			$user_id = $this->current_user->user_id;
			$query=mysqli_query($this->conn, "SELECT office_id FROM office WHERE administrative_head='$user_id' and office_id='$department_id'");
			if(mysqli_num_rows($query)>=1){
				return true;
			}
			else
				return false;
		}

		function final_approve($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET deputy_exam_controller=1, approved_level=11, final_status=1 WHERE clearance_id='$application_id'");
		}
		

		function approve_declined_application($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET deputy_exam_controller=1, approved_level=11, final_status=1 WHERE clearance_id='$application_id'");
		}
		

		function decline_application($application_id){
			mysqli_query($this->conn, "UPDATE clearance SET deputy_exam_controller=2, final_status=2 WHERE clearance_id='$application_id'");
		}

		function get_admin_account_status($user_id){
			$query=mysqli_query($this->conn, "SELECT active FROM admin WHERE user_id='$user_id'");	
			return mysqli_fetch_array($query)['active']==1;
		}
		

		

		


	}
	$DB = new Database();


	class String_Manager{
		private $conn;
		public $strings;
	  	function __construct() {
	  		$strings=array();
		    $this->conn = mysqli_connect("fdb27.runhosting.com","4180147_dcs","2)dGBeWn5!+oJsJl","4180147_dcs");
		}
		function fetch_strings($user_type){
			$query=mysqli_query($this->conn, "SELECT name, value FROM site_strings WHERE for_user_type='$user_type' or for_user_type=0");
			while($row=mysqli_fetch_array($query)){
				$this->strings[$row['name']]=$row['value'];
			}
		}
	}
	$SM = new String_Manager();
	if(isset($_SESSION['DCMS_user'])){
		$DB->current_user=$_SESSION['DCMS_user'];
		if($DB->current_user->user_type_number==1)
			$DB->initialize_user($DB->current_user->student_id);
		else if($DB->current_user->user_type_number==2){
			$DB->initialize_user($DB->current_user->user_id);
			$DB->current_user->account_status=$DB->get_admin_account_status($DB->current_user->user_id);
		}
		$SM->fetch_strings($DB->current_user->user_type_number);
	}
	else
		$SM->fetch_strings(0);
?>
