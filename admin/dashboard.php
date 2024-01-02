<?php
	if(!isset($_SESSION)){
		require('../include/error.php');
		return;
	}
?>

<div class="singlebox">
	<center>
		<p><?php echo $SM->strings['welcome_greeting'];?>, <b><?php  echo $DB->current_user->name;?></b></p>
		<p>
		<?php
			echo $DB->current_user->designation."<br>";
			echo $DB->current_user->office."<br>";
			echo $DB->current_user->office_loc."<br>";
		?></p>
	</center>
</div>
<?php if($DB->current_user->account_status==0) {?>
<br>
<br>
<marquee style="width: 70%;margin: auto; display: block; border: 1px solid maroon;"><h3 style="color:maroon;">This account is suspended. Please Contact Admin.</h3></marquee>
<?php unset($_SESSION['DCMS_user']);
} ?>