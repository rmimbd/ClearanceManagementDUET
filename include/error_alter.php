<?php
$list_of_files_arr = get_included_files();
$string_to_look_for = 'databaseserver.php';
$file_not_included=true;
foreach ($list_of_files_arr as $file_path) {
  if (false !== strpos($file_path, $string_to_look_for)) {
    $file_not_included=false;
  } 
}
if($file_not_included)
	include('../databaseserver.php');
?>

		<br><br><br><br><br><br>
		<div class="singlebox" style="border: 0px solid #ffffff;">
		
		<div class="col-2" style="float:none;display: block;">
			<div class="box">
				<div class="boxTitle" style="text-align:center;">
					<h3>Error!</h3>
				</div>
				<div class="boxContent" style="text-align:center;">
					<br>
					<b>Unauthorized access request.</b>
				</div>
			</div>
		</div>
		
		<div class="clearFix"></div>
		</div>
		