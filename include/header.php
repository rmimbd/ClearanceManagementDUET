<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

	<div class="header">
		<div class="mainmenu">
			<center><div class="siteTitle"><a href="/"><img src="../images/icon/duet_icon.ico" height="25"> <?php echo $SM->strings['site_title'];?></a></div></center>
			
		</div>
	</div><!-- /.header -->