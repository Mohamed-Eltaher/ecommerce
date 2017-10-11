<?php
	session_start();
	$pageTitle = 'Profile';
	include 'init.php';
?>
	<h1 class="text-center"><?php echo $sessionUser; ?> Profile</h1>
	<div class="my-information">
		<div class="container">
			 <div class="panel panel-primary">
			 	<div class="panel-heading">My Information</div>
			 	<div class="panel-body">
			 		test info
			 	</div>
			 </div>
		</div>
	</div>	

	<div class="ads">
		<div class="container">
			 <div class="panel panel-primary">
			 	<div class="panel-heading">My Ads</div>
			 	<div class="panel-body">
			 		test ads
			 	</div>
			 </div>
		</div>
	</div>

	<div class="my-comments">
		<div class="container">
			 <div class="panel panel-primary">
			 	<div class="panel-heading">Latest Comments</div>
			 	<div class="panel-body">
			 		test comments
			 	</div>
			 </div>
		</div>
	</div>		
<?php
	include $tmp . 'footer.php';
?>	