<?php
    require ("../databaseserver.php");
    require 'FPDF/fpdf.php';
    
    if(!isset($_SESSION['DCMS_user'])){
        require('../include/error.php');
        return;
    }
    else{
        if($DB->current_user->user_type!="student"){
            require('../include/error.php');
            return;
        }
    }
    if(!$DB->is_clearance_application_submitted($DB->current_user->student_id)){
        require('../include/error.php');
        return;
    }
    
    $clearance_applicaton_data=mysqli_fetch_array($DB->get_application_data_of_student($DB->current_user->student_id));
    $clearance_id=$clearance_applicaton_data['clearance_id'];

    if(!$DB->is_valid_application_id($clearance_id)){
        echo "Invalid Clearance ID.";
        return;
    }
    
    if($clearance_applicaton_data['final_status']!=1){
        require('../include/error.php');
        return;
    }
    
    $section_officer= " ";
    $hall_assistant= " ";
    $hall_provost= " ";
    $office_assistant= " ";
    $thesis_supervisor= " ";
    $dept_head= " ";
    $assistant_dsw= " ";
    $dsw= " ";
    $student_signature= " ";
    $deputy_exam_controller= " ";



    $error=" ";
    $con = new PDO('mysql:host=localhost;dbname=dcms','root','');
    $query ="SELECT clearance_id, c.student_id as student_id, approved_level, so_exam_controller, aso_hall, provost, labs, aso_department, c.thesis_supervisor as thesis_supervisor, head_department, assistant_dsw, dsw, deputy_exam_controller, final_status, name, name_of_father, name_of_mother, department_id, current_year, current_semester, session, admission_year, hall, hall_room_number FROM clearance as c, student as s WHERE c.clearance_id='$clearance_id' and s.student_id=c.student_id";
    $result = $con->prepare($query);
    $result->execute();
    if($result->rowCount()==1){
    $data = $result->fetch();
    if($data['so_exam_controller']) $section_officer= "Approved";

    if($data['aso_hall']) $hall_assistant= "Approved";
    if($data['provost']) $hall_provost= "Approved";
    if($data['aso_department']) $office_assistant= "Approved";
    if($data['thesis_supervisor']==1) $thesis_supervisor= "Approved";
    if($data['head_department']) $dept_head= "Approved";

    if($data['assistant_dsw']) $assistant_dsw= "Approved";
    if($data['dsw']) $dsw= "Approved";
    if($data['deputy_exam_controller']) $deputy_exam_controller= "Approved";   

    $dept = $DB->get_department_name($data['department_id']);
    $student_name=$data['name'];
    $father_name=$data['name_of_father'];
    $student_id= $data['student_id'];
    $year =$data['current_year'];
    $semester=$data['current_semester'];
    $acadamic_year=$data['session'];
    $admission_year=$data['admission_year'];
    $hall_name=$DB->get_hall_name($data['hall']);
    $room_number=$data['hall_room_number'];    

    }else{
    echo "Something Went Wrong!";
    return;
    }




    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image('../images/icon/duet_icon.png',15,15,20, 20);

    $pdf->SetFont('Arial','B',15);
    $pdf->setTextColor(0, 0, 0);
    $pdf->Cell(200,8,"Dhaka University of Engineering & Technology, Gazipur",0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(200,8,"Gaziput-1707",0,1,'C');
    $pdf->Cell(200,6,"Computer Science and Engineering",0,1,'C');
    $pdf->Cell(200,6,"Student's Clearance Form",0,1,'C');


    $pdf->Cell(50,10,' ',0,1,'C');

    $pdf->MultiCell(190,6,"Student's Name :  ".$student_name.".  Father's Name:  ".$father_name.".  Student's ID : ".$student_id.".  Year : ".$year.".  Semester : ".$semester.".  Session : ".$acadamic_year.".  Admission year : ".$admission_year.". All Heads of Departments/Branch Officers are requested to issue certificates/deposit refunds/certify claims/ no-claims on personal grounds after completing the undergraduate/postgraduate programme.",0,'j',false);

    $pdf->Cell(50,2,' ',0,1,'C');
    $pdf->SetFont('Arial','B',12);



    $pdf->Cell(160,4,$section_officer,0,1,'R');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(170,4,"_______________",0,1,'R');
    $pdf->Cell(166,7,"Section Officer",0,1,'R');
    $pdf->Cell(190,4,"Office of the Controller of Examinations",0,1,'R');

    $pdf->Cell(50,4,' ',0,1,'C');
    $pdf->MultiCell(190,4,"1. Name of the Hall of Residence  ".$hall_name.".  Room No : ".$room_number.".",0,'L',false);
    $pdf->Cell(50,4,' ',0,1,'C');

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20);
    $pdf->Cell(30,4,$hall_assistant,0,0,'L');
    $pdf->Cell(110,4,$hall_provost,0,1,'R');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10);
    $pdf->Cell(30,4,"_________________",0,0,'L');
    $pdf->Cell(130,4,"_______________",0,1,'R');
    $pdf->Cell(10);
    $pdf->Cell(30,7,"Hall office assistant    ",0,0,'L');
    $pdf->Cell(120,7,"Provost  ",0,1,'R');

    $pdf->Cell(50,4,' ',0,1,'C');
    $pdf->Cell(0,7,"2.Labs  ",0,1,'L');

    $pdf->Cell(50,4,' ',0,1,'C');

        //$pdf->Cell(20,10,"Date:",0,0,'C');
        //$pdf->Cell(30,10,date("j-n-Y"),0,1,'C');
    // labs table column
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,10,'Serial',1,0,'C');
    $pdf->Cell(96,10,'Labs/Workshops Name',1,0,'C');
    //$pdf->Cell(40,10,'Comment',1,0,'C');
    $pdf->Cell(37,10,'Lab Assistant',1,0,'C');
    $pdf->Cell(37,10,'Officer In charge',1,1,'C');
    // table rows
    $pdf->SetFont('Arial','',12);

    $query ="SELECT lab.name,log.assistant_approved,log.officer_approved  FROM labs_approve_log as log , labs as lab where clearance_id=$clearance_id and lab.lab_id=log.lab_id";
    $result = $con->prepare($query);
    $result->execute();
    if($result->rowCount()!=0)
    {
     $i=0;
    while($data = $result->fetch())
    {
    if($data['assistant_approved']) $lab_assistant="Approved";
    else $lab_assistant=" ";
    if($data['officer_approved']) $lab_officer="Approved";
    else $lab_officer=" ";

    $pdf->Cell(20,10,++$i,1,0,'C');
    $pdf->Cell(96,10,$data['name'],1,0,'C');
    //$pdf->Cell(40,10," ",1,0,'C');
    $pdf->Cell(37,10,$lab_assistant,1,0,'C');
    $pdf->Cell(37,10,$lab_officer,1,1,'C');
    }

    }

    $pdf->Cell(50,4,' ',0,1,'C');

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20);
    $pdf->Cell(30,4,$office_assistant,0,0,'L');
    $pdf->Cell(70,4,$thesis_supervisor,0,0,'C');
    $pdf->Cell(50,4,$dept_head,0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10);
    $pdf->Cell(30,4,"_________________",0,0,'L');
    $pdf->Cell(90,4,"_________________",0,0,'C');
    $pdf->Cell(35,4,"_______________",0,1,'R');
    $pdf->Cell(10);
    $pdf->Cell(30,7,"   Office assistant",0,0,'L');
    $pdf->Cell(90,7,"Thesis Supervisor",0,0,'C');
    $pdf->Cell(40,7,"Head of the Department",0,1,'R');

    $pdf->Cell(50,4,' ',0,1,'C');
    $pdf->Cell(0,7,"3. Administrative Offices:  ",0,1,'L');

    $pdf->Cell(50,4,' ',0,1,'C');

    // labs table column
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,10,'Serial',1,0,'C');
    $pdf->Cell(96,10,'Various offices',1,0,'C');
    //$pdf->Cell(40,10,'Comment',1,0,'C');
    $pdf->Cell(37,10,'Officer/Employee',1,0,'C');
    $pdf->Cell(37,10,'Head of Office',1,1,'C');
    // table rows
    $pdf->SetFont('Arial','',12);


    $query ="SELECT o.office_id, o.office_name,c.exam_controller,c.comptroller,c.medical_center,c.computer_center,c.physical_edu_center,c.central_library FROM office as o, clearance as c where office_id>=21 and office_id<=26 and clearance_id=$clearance_id";
    $result = $con->prepare($query);
    $result->execute();
    if($result->rowCount()!=0)
    {
     $i=0;
    while($data = $result->fetch())
    {
    $ass_office="";
    $office_head=" ";
    if($data['exam_controller']>=1 && $data['office_id']==21) $ass_office= "Approved";
    if($data['exam_controller']==2 && $data['office_id']==21) $office_head= "Approved";

    if($data['comptroller']>=1 && $data['office_id']==22) $ass_office= "Approved";
    if($data['comptroller']==2 && $data['office_id']==22) $office_head= "Approved";

    if($data['medical_center']>=1 && $data['office_id']==23) $ass_office= "Approved";
    if($data['medical_center']==2 && $data['office_id']==23) $office_head= "Approved";

    if($data['computer_center']>=1 && $data['office_id']==24) $ass_office= "Approved";
    if($data['computer_center']==2 && $data['office_id']==24) $office_head= "Approved";

    if($data['physical_edu_center']>=1 && $data['office_id']==25) $ass_office= "Approved";
    if($data['physical_edu_center']==2 && $data['office_id']==25) $office_head= "Approved";

    if($data['central_library']>=1 && $data['office_id']==26) $ass_office= "Approved";
    if($data['central_library']==2 && $data['office_id']==26) $office_head= "Approved";

    $pdf->Cell(20,10,++$i,1,0,'C');
    $pdf->Cell(96,10,$data['office_name'],1,0,'C');
    //$pdf->Cell(40,10," ",1,0,'C');
    $pdf->Cell(37,10,$ass_office,1,0,'C');
    $pdf->Cell(37,10,$office_head,1,1,'C');
    }

    }

    $pdf->Cell(50,4,' ',0,1,'C');

    $pdf->Cell(0,7,"Clearance may/may not be granted.",0,1,'L');
    $pdf->Cell(50,4,' ',0,1,'C');

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20);
    $pdf->Cell(30,4,$assistant_dsw,0,0,'L');
    $pdf->Cell(110,4,$dsw,0,1,'R');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10);
    $pdf->Cell(30,4,"_________________",0,0,'L');
    $pdf->Cell(130,4,"_______________",0,1,'R');
    $pdf->Cell(5);
    $pdf->Cell(10,7,"Deputy Director (Student Welfare)",0,0,'L');
    $pdf->Cell(165,7,"Director (Student Welfare)",0,1,'R');

    $pdf->Cell(50,10,' ',0,1,'C');

    $pdf->MultiCell(190,6,"Due (if any) _ _ _ _ _ _ _ _ _ _ _ to the undersigned student after deducting their security deposit _ _ _ _ _ _ _ _ _ In words: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ can be returned.",0,'j',false);

    $pdf->Cell(50,4,' ',0,1,'C');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20);
    $pdf->Cell(30,4,$student_signature,0,0,'L');
    $pdf->Cell(110,4,$deputy_exam_controller,0,1,'R');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10);
    $pdf->Cell(30,4,"_________________",0,0,'L');
    $pdf->Cell(130,4,"_______________",0,1,'R');
    $pdf->Cell(10);
    $pdf->Cell(10,7,"Student's Signature",0,0,'L');
    $pdf->Cell(165,7,"Deputy Controller of Examinations",0,1,'R');

    $pdf->Cell(50,4,' ',0,1,'C');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(50,4,' ',0,1,'C');
    $pdf->Cell(190,8,"(For use in Comptroller's Office)",0,1,'C');
    $pdf->Cell(50,10,' ',0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(190,8,"Money _ _ _ _ _ _ _ _ _ _ ( in words: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ only ) got it.",0,'j',false);


    $pdf->Cell(50,10,' ',0,1,'C');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190,4," ",0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(190,4,"_______________",0,1,'C');
    $pdf->Cell(10);
    $pdf->Cell(170,7,"Signature of Student (Recipient)",0,1,'C');



    $pdf->Cell(50,8,' ',0,1,'C');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20);
    $pdf->Cell(28,4," ",0,0,'L');
    $pdf->Cell(110,4," ",0,1,'R');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10);
    $pdf->Cell(30,4,"_________________",0,0,'L');
    $pdf->Cell(130,4,"_______________",0,1,'R');
    $pdf->Cell(10);
    $pdf->Cell(10,7,"Cashier's signature",0,0,'L');
    $pdf->Cell(165,7,"Signature of Responsible officer",0,1,'R');

    $pdf->Cell(50,4,' ',0,1,'C');




    $pdf->Output();
           
 
?>