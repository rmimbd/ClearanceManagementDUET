$("#report_filter_dropdown_activator").click(function(){
	$("#report_filter_dropdown_list").slideToggle(100);
});

$("#clearance_filter_dropdown_activator").click(function(){
	$("#clearance_filter_dropdown_list").slideToggle(100);
});

$("#user_filter_dropdown_activator").click(function(){
	$("#user_filter_dropdown_list").slideToggle(100);
});

$("#type_filter_dropdown_activator").click(function(){
	$("#type_filter_dropdown_list").slideToggle(100);
});

$("#menuItemClearance").click(function(){
	$("#submenuItemClearance").slideToggle(100);
});

$("#popup_close_button").click(function(){
	((this.parentNode).parentNode).removeChild(this.parentNode);
});

var initialApprovalViewerActive=false;
$("#initialApprovalTitle").click(function(){
	if(initialApprovalViewerActive==false){
		$("#initialApprovalViewer").css('transform','rotate(180deg)');
		initialApprovalViewerActive=true;
	}
	else{
		$("#initialApprovalViewer").css('transform','rotate(0deg)');
		initialApprovalViewerActive=false;
	}
	$('#initialApproval').slideToggle();
});



var hallApprovalViewerActive=false;
$("#hallApprovalTitle").click(function(){
	if(hallApprovalViewerActive==false){
		$("#hallApprovalViewer").css('transform','rotate(180deg)');
		hallApprovalViewerActive=true;
	}
	else{
		$("#hallApprovalViewer").css('transform','rotate(0deg)');
		hallApprovalViewerActive=false;
	}
	$('#hallApproval').slideToggle();
});





var labApprovalViewerActive=false;
$("#labApprovalTitle").click(function(){
	if(labApprovalViewerActive==false){
		$("#labApprovalViewer").css('transform','rotate(180deg)');
		labApprovalViewerActive=true;
	}
	else{
		$("#labApprovalViewer").css('transform','rotate(0deg)');
		labApprovalViewerActive=false;
	}
	$('#labApproval').slideToggle();
});



var departmentApprovalViewerActive=false;
$("#departmentApprovalTitle").click(function(){
	if(departmentApprovalViewerActive==false){
		$("#departmentApprovalViewer").css('transform','rotate(180deg)');
		departmentApprovalViewerActive=true;
	}
	else{
		$("#departmentApprovalViewer").css('transform','rotate(0deg)');
		departmentApprovalViewerActive=false;
	}
	$('#departmentApproval').slideToggle();
});



var adminOfficeApprovalViewerActive=false;
$("#adminOfficeApprovalTitle").click(function(){
	if(adminOfficeApprovalViewerActive==false){
		$("#adminOfficeApprovalViewer").css('transform','rotate(180deg)');
		adminOfficeApprovalViewerActive=true;
	}
	else{
		$("#adminOfficeApprovalViewer").css('transform','rotate(0deg)');
		adminOfficeApprovalViewerActive=false;
	}
	$('#adminOfficeApproval').slideToggle();
});



var dswApprovalViewerActive=false;
$("#dswApprovalTitle").click(function(){
	if(dswApprovalViewerActive==false){
		$("#dswApprovalViewer").css('transform','rotate(180deg)');
		dswApprovalViewerActive=true;
	}
	else{
		$("#dswApprovalViewer").css('transform','rotate(0deg)');
		dswApprovalViewerActive=false;
	}
	$('#dswApproval').slideToggle();
});


var finalApprovalViewerActive=false;
$("#finalApprovalTitle").click(function(){
	if(finalApprovalViewerActive==false){
		$("#finalApprovalViewer").css('transform','rotate(180deg)');
		finalApprovalViewerActive=true;
	}
	else{
		$("#finalApprovalViewer").css('transform','rotate(0deg)');
		finalApprovalViewerActive=false;
	}
	$('#finalApproval').slideToggle();
});


$menu_active=false;
$('#menubutton').click(function(){
	$('#menu').slideToggle();
	$menu_active=!$menu_active;
	if($menu_active)
		document.getElementById('menubutton').innerHTML="<i class='fa fa-plus' style='transform:rotate(45deg)'></i>";
	else
		document.getElementById('menubutton').innerHTML="<i class='fa fa-bars'></i>";
});


$(document).ready(function(){
    $('#search_key').on('keyup', function() {
        var key=$(this).val();
        key=key.toLowerCase();
        for(var i=1;i<=total_row;i++){
        	let id='#application_id_'+i;
        	let row_id='#application_row_'+i;
        	let application_id=$(id).text();
        	application_id=application_id.toLowerCase();
        	let deptid='#department_name_id_'+i;
        	let deptname=$(deptid).text();
        	deptname=deptname.toLowerCase();
        	let lname='';
        	if(lab_approval_active){
        		let lid='#lab_name_id_'+i;
        		lname=$(lid).text();
        		lname=lname.toLowerCase();
        	}
        	if(application_id.search(key)>=0 || deptname.search(key)>=0 || (lname.search(key)>=0) && lname!=''){
        		$(row_id).slideDown();
        	}
        	else
        		$(row_id).slideUp();
        }
    });
});


$(document).ready(function(){
    $('#user_search_key').on('keyup', function() {
        var key=$(this).val();
        key=key.toLowerCase();
        let j=1;
        if(key==''){
        	for(var i=1;i<=total_row;i++){
        		let row_id='#user_row_'+i;
        		let sl='sl_'+i;
        		$(row_id).slideDown();
        		sl=document.getElementById(sl);
        		if(sl!=null)
        			sl.innerHTML=i;
        	}
        	return;
        }
        for(var i=1;i<=total_row;i++){
        	let id='#user_id_'+i;
        	let row_id='#user_row_'+i;
            let name_id='#name_'+i;
            let name=$(name_id).text();
        	let user_id=$(id).text();
        	user_id=user_id.toLowerCase();
        	let office_id='#office_'+i;
        	let office=$(office_id).text();
        	office=office.toLowerCase();
        	name=name.toLowerCase();
        	let sl='sl_'+i;
        	if(user_id.search(key)>=0 || office.search(key)>=0 || name.search(key)>=0){
        		$(row_id).slideDown();
        		document.getElementById(sl).innerHTML=j++;
        	}
        	else
        		$(row_id).slideUp();
        }
    });
});

$(document).ready(function(){
    $('#student_search_key').on('keyup', function() {
        var key=$(this).val();
        key=key.toLowerCase();
        let j=1;
        if(key==''){
        	for(var i=1;i<=total_row;i++){
        		let row_id='#user_row_'+i;
        		let sl='sl_'+i;
        		$(row_id).slideDown();
        		sl=document.getElementById(sl);
        		if(sl!=null)
        			sl.innerHTML=i;
        	}
        	return;
        }
        for(var i=1;i<=total_row;i++){
        	let id='#student_id_'+i;
        	let row_id='#user_row_'+i;
            let name_id='#name_'+i;
            let department_id='#department_'+i;
            let name=$(name_id).text();
        	let student_id=$(id).text();
        	let department=$(department_id).text();
        	student_id=student_id.toLowerCase();
        	let year_sem_id='#year_sem_'+i;
        	let year_sem=$(year_sem_id).text();
        	year_sem=year_sem.toLowerCase();
        	name=name.toLowerCase();
        	department=department.toLowerCase();
        	let sl='sl_'+i;
        	if(student_id.search(key)>=0 || name.search(key)>=0 || department.search(key)>=0 || year_sem.search(key)>=0){
        		$(row_id).slideDown();
        		document.getElementById(sl).innerHTML=j++;
        	}
        	else
        		$(row_id).slideUp();
        }
    });
});


$(document).ready(function(){
    $('#office_search_key').on('keyup', function() {
        var key=$(this).val();
        key=key.toLowerCase();
        let j=1;
        if(key==''){
        	for(var i=1;i<=total_row;i++){
        		let row_id='#office_row_'+i;
        		let sl='sl_'+i;
        		$(row_id).slideDown();
        		sl=document.getElementById(sl);
        		if(sl!=null)
        			sl.innerHTML=i;
        	}
        	return;
        }
        for(var i=1;i<=total_row;i++){
        	let id='#office_id_'+i;
        	let row_id='#office_row_'+i;
            let name_id='#name_'+i;
            let head_id='#admin_head_'+i;
            let officer_id='#head_officer_'+i;
            let name=$(name_id).text();
        	let office_id=$(id).text();
        	let head=$(head_id).text();
        	let officer=$(officer_id).text();
        	office_id=office_id.toLowerCase();
        	name=name.toLowerCase();
        	head=head.toLowerCase();
        	officer=officer.toLowerCase();
        	let sl='sl_'+i;
        	if(office_id.search(key)>=0 || name.search(key)>=0 || head.search(key)>=0 || officer.search(key)>=0){
        		$(row_id).slideDown();
        		document.getElementById(sl).innerHTML=j++;
        	}
        	else
        		$(row_id).slideUp();
        }
    });
});

$(document).ready(function(){
    $('#lab_search_key').on('keyup', function() {
        var key=$(this).val();
        key=key.toLowerCase();
        let j=1;
        if(key==''){
        	for(var i=1;i<=total_row;i++){
        		let row_id='#lab_row_'+i;
        		let sl='sl_'+i;
        		$(row_id).slideDown();
        		sl=document.getElementById(sl);
        		if(sl!=null)
        			sl.innerHTML=i;
        	}
        	return;
        }
        for(var i=1;i<=total_row;i++){
        	let id='#lab_id_'+i;
        	let row_id='#lab_row_'+i;
            let name_id='#name_'+i;
            let department_id='#department_'+i;
            let name=$(name_id).text();
        	let lab_id=$(id).text();
        	let department=$(department_id).text();
        	lab_id=lab_id.toLowerCase();
        	let assistant_id='#assistant_'+i;
        	let assistant=$(assistant_id).text();
        	assistant=assistant.toLowerCase();
        	
        	let incharge_id='#incharge_'+i;
        	let incharge=$(incharge_id).text();
        	incharge=incharge.toLowerCase();
        	name=name.toLowerCase();
        	department=department.toLowerCase();
        	let sl='sl_'+i;
        	if(lab_id.search(key)>=0 || name.search(key)>=0 || department.search(key)>=0 || assistant.search(key)>=0 || incharge.search(key)>=0){
        		$(row_id).slideDown();
        		document.getElementById(sl).innerHTML=j++;
        	}
        	else
        		$(row_id).slideUp();
        }
    });
});


$(window).on("load resize",function(e){
	$("#adminWindow").css('height',$("#adminInterfaceContent").height()+10);
	$("#leftNavigation").css('min-height',$("#adminWindow").height());
	$("#report_filter_dropdown_activator").css('width', $("#report_filter_dropdown_list").width()+5);
	$("#clearance_filter_dropdown_activator").css('width', $("#clearance_filter_dropdown_list").width()+5);
	$("#user_filter_dropdown_activator").css('width', $("#user_filter_dropdown_list").width()+5);
	$("#type_filter_dropdown_activator").css('width', $("#type_filter_dropdown_list").width()+5);
	$(".squareCard").css('width',$(".squareCard").height()*2.245);
});


$(window).on("scroll resize",function(e){
	$("#clearance_filter_dropdown_list").slideUp(100);
	$("#report_filter_dropdown_list").slideUp(100);
	$("#submenuItemClearance").slideUp(100);
});