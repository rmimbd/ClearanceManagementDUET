<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

	<div class="header">
		<div class="mainmenu">
			<center><div class="siteTitle"><a href="../"><img src="../images/icon/duet_icon.ico" height="25"> <?php echo $SM->strings['site_title'];?></a></div></center>
			<div class="menubutton" id="menubutton">
				<i class="fa fa-bars"></i>
			</div>
			<div class="clearFix"></div>
			<ul id="menu">
			<li><a href="index.php"><?php echo $SM->strings['text_home'];?></a></li>
			<li><a href="profile.php">Profile</a></li>
			<li><a id="menuItemClearance"><?php echo $SM->strings['clearance_apply_menu_item'];?></a>
				<ul id="submenuItemClearance" class="submenu">
					<div class="subMenuTopBox">......</div>
					<li><a href="apply_for_clearance.php"><?php echo $SM->strings['clearance_apply_submenu_new_application'];?></a></li>
					<li><a href="clearance_application_detail.php"><?php echo $SM->strings['clearance_apply_submenu_status'];?></a></li>
				</ul>
			</li>
			<li><a id="menuItemReports" href="reports.php"><?php echo $SM->strings['text_reports'];?></a></li>
			<li><a href="/index.php?logout=true"><?php echo $SM->strings['text_log_out'];?></a></li>
			</ul>
		</div>
	</div><!-- /.header -->