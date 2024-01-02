<?php
	require ("../databaseserver.php");
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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $SM->strings['site_title'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=0.9">
	<link rel="icon" href="../images/icon/duet_icon.ico">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../fonts/font-awesome.min.css">
</head>
<body>
	<!-- Main Section Start -->
	<!-- Header Start -->
	<?php
		require ("../include/student_header.php");
	?>
	<br><br><br>
	<!-- Header End -->
	<div class="main">
		<br><br>
		<center><h3>Reports Against You</h3></center>
		<?php
		$index=1;
		$reports = $DB->get_all_reports_against_student($DB->current_user->student_id);
		if(mysqli_num_rows($reports)>0){?>
			<table class="tableOne" style="width:75%; margin: auto;">
				<colgroup>
		    		<col span="1" style="width: 8%;">
		    		<col span="1" style="width: 17%;">
		    		<col span="1" style="width: 45%;">
		    		<col span="1" style="width: 20%;">
		    		<col span="1" style="width: 10%;">
		    	</colgroup>
				<tr class="tableOneHeader">
					<th>Serial</th>
					<th>Report ID</th>
					<th>Report Title</th>
					<th>Report Status</th>
					<th></th>
				</tr>
				<?php while($report=mysqli_fetch_array($reports)){?>
					<tr class="<?php echo $index%2==0?"evenRow":"oddRow";?>">
						<td><?php echo $index; ?></td>
						<td><?php echo $report['report_id']; ?></td>
						<td><?php echo $report['title']; ?></td>
						<td><?php
						switch ($report['report_status']) {
							case 1:
								echo "Active";
								break;
							case 2:
								echo "Resolved";
								break;
							case 3:
								echo "Withdrawn";
								break;
						}

						?></td>
						<td>
							<a href="view_report.php?report_id=<?php echo $report['report_id']; ?>"><button class="button2"><i class="fa fa-eye"></i> View</button></a>
						</td>
					</tr>
				<?php
				$index++;
				}?>
			</table>
		<?php
		}
		else{
			echo "<center>No issue reported against you.</center>";
		}
		?>
		<br>
		<br>
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

