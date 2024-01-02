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

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=0.9">
	<title><?php echo "Error - ".$SM->strings['site_title'];?></title>
	<link rel="icon" href="../images/icon/duet_icon.ico">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<!-- Main Section Start -->
	<!-- Header Start -->
	<?php
		require ("header.php");
	?>
	<br><br><br>
	<!-- Header End -->
	<div class="main">
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
		<br><br><br>
		<!-- Mission and Vision Section End -->

		
		

	</div><!-- /.main -->
	<!-- Main Section End -->
	<!-- Footer Section Start -->
	<?php
		require ("../include/footer.php");
	?>
	<!-- Footer Section End -->
	<script src="../js/jquery-2.x-git.min.js"></script>
	<script src="../js/function.js"></script>

</body>
</html>