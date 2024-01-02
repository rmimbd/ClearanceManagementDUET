<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>


	<div class="footer">
		<div class="footerHolder">
			<div class="col-2">
				<h3><?php echo $SM->strings['text_help'];?></h3>
				<ul>
					<li><a href=""><?php echo $SM->strings['text_terms_conditions'];?></a></li>
					<li><a href=""><?php echo $SM->strings['text_contact_us'];?></a></li>
				</ul>
			</div>
			<div class="col-2">
				<h3>Quick Links</h3>
				<ul>
					<li><a href="http://www.duet.ac.bd"><?php echo $SM->strings['text_main_website'];?></a></li>
				</ul>
			</div>
			<div class="clearFix"></div>
			<div class="copyright">
				&copy; <?php echo $SM->strings['university_name'];?>
			</div>
		</div>
	</div>