<?php

session_start();
if (isset($_SESSION['Username'])) {
	$pageTitle = 'Dashboard';
	include 'init.php'; 
	// get latest users function
	$latestUser = 5;
	$getLatestUsers = getLatest("*", "users", "UserID", $latestUser);
	$latestItem = 5;
	$getLatestitem = getLatest("*", "items", "Item_ID", $latestItem);
	$latestcom = 2;
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
						<span>
							<a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="panels">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
					  <div class="panel-heading toggle-info">Latest <?php echo $latestUser; ?> Registered Users
					  <i class="fa fa-minus pull-right"></i>
					  </div>
					  <div class="panel-body">
					    <?php
					    if (!empty($getLatestUsers)) { 
							foreach ($getLatestUsers as $user) { ?>
							<li class="list-unstyled clearfix">
								<?php echo $user['Username']; ?>			
								<a class='btn btn-primary pull-right' href="members.php?do=Edit&userid=<?php echo $user['UserID'] ?>" >Edit</a>
							</li>		 
						<?php } } else{ echo ' there is no users to show';} ?>
					  </div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-default">
					  <div class="panel-heading toggle-info">Latest <?php echo $latestItem; ?> Items
						<i class="fa fa-minus pull-right"></i>
					  </div>
					  <div class="panel-body">
					    <?php
					    	if (!empty($getLatestitem)) { 
							foreach ($getLatestitem as $item) {	?>
							<li class="list-unstyled clearfix">
								<?php echo $item['Name']; ?>			
								<a class='btn btn-primary pull-right' href="items.php?do=Edit&itemid=<?php echo $item['Item_ID'] ?> " >Edit</a>
								<?php if ($item['Approve'] == 0 ) {
								 	echo "<a href='items.php?do=approve&itemid=" . $item['Item_ID'] ."' class='btn btn-info pull-right'><i class='fa fa-check'></i> Approve</a>";
								 }	?>	
							</li>				
						<?php } } else{echo ' there is no items here';} ?>
					  </div>
					</div>
				</div>
			</div>
			<!-- start comments row -->
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
					  <div class="panel-heading toggle-info">Latest Comments
					  <i class="fa fa-comment-o pull-right"></i>
					  </div>
					  <div class="panel-body">
						 <?php
							$stmt = $con->prepare("SELECT
							 comments.*,  users.Username  
							FROM 
								comments
							
							INNER JOIN 
								users 
							ON 
								users.UserID = comments.user_id 
							ORDER BY
								 c_id DESC 
							LIMIT
								 $latestcom ");
							
							$stmt->execute();
							$comments = $stmt->fetchAll();
						    if (!empty($comments)) {
							    foreach ($comments as $comment) {
							    	echo  "<span>";
							    		echo "<a href='members.php?do=Edit&userid=" . $comment['c_id'] . "'>" . $comment['Username'] . "</a>";
							    	 echo "</span>";
							    	echo "<p>" . $comment['comment'] . "</p>";
							    } 
						    } else {echo "No Comments to show";} 								 
						 ?>
					  </div>
					</div>
				</div>
			</div>
			<!--end comments row-->
		</div>
	</div>
	<?php
	/* end Dashborad page */
	 include $tmp . 'footer.php';
}else{
	header('Location: index.php');
	exit();
}