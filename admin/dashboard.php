<?php

session_start();

if (isset($_SESSION['Username'])) {
	$pageTitle = 'Dashboard';
	include 'init.php'; 
	// get latest users function
	$latest = 5;
	$getLatest = getLatest("*", "users", "UserID", $latest);
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
						<span>
							<a href="members.php?do=manage&page=pending"><?php echo checkItem('RegStatus', 'users', 0) ?>			
							</a>
						</span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="states">
						Total Items
						<span>
							<a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a>
						</span>
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
					  <div class="panel-heading">Latest <?php echo $latest; ?> Registered Users</div>
					  <div class="panel-body">
					    <?php
							foreach ($getLatest as $user) {	?>
								<a href="members.php?do=Edit&userid=<?php echo $user['UserID'] ?>">
									<?php echo $user['Username'] . '</br>'; ?>
								</a>		 
						<?php } ?>
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