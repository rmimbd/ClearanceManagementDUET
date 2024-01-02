<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>


	<div class="footer">
		<div class="footerHolder">
			<div class="copyright">
				&copy; <?php echo $SM->strings['university_name'];?>
			</div>
		</div>
	</div>