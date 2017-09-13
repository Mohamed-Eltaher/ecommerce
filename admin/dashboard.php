<?php

session_start();

if (isset($_SESSION['Username'])) {
	$pageTitle = 'Dashboard';
	include 'init.php'; 
	/* start Dashborad page */
	?>
	<div class="container">
		<h1 class="text-center">DashBoard</h1>
		<div class="main text-center">
			<div class="row">
				<div class="col-md-3">
					<div class="states">
						Total Members
						<span><a href="members.php"><?php echo countItems('UserId', 'users') ?></a></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="states">
						Pending Members
						<span>20</span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="states">
						Total Items
						<span>200</span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="states">
						Total Comments
						<span>200</span>
					</div>
				</div>
			</div>
		</div>
		<div class="panels">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
					  <div class="panel-heading">Latest Registered Users</div>
					  <div class="panel-body">
					    Panel content
					  </div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-default">
					  <div class="panel-heading">Latest Items</div>
					  <div class="panel-body">
					    Panel content
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	/* end Dashborad page */
	 include $tmp . 'footer.php';
}else{
	header('Location: index.php');
	exit();
}