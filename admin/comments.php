<?php

/*
============================================
== Manage Comments Page
== Here you can edit, delete comments
=============================================
*/

session_start();
$pageTitle = 'Comments';

if (isset($_SESSION['Username'])) {
	include 'init.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
	if ($do == 'manage') { 
	####################################
	#### Manage Page
	####################################
		$stmt = $con->prepare("SELECT
							 comments.*, items.Name, users.Username  
							FROM 
								comments
							INNER JOIN 
								items 
							ON 
								items.Item_ID = comments.item_id
							INNER JOIN 
								users 
							ON 
								users.UserID = comments.user_id ");
		
		$stmt->execute();
		$rows = $stmt->fetchAll();
?>
		<h1 class="text-center">Manage Comments</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="table table-bordered text-center">
					<tr class="info">
						<td>ID</td>
						<td>Comment</td>
						<td>Item</td>
						<td>Username</td>
						<td>Added date</td>
						<td>Control</td>
					</tr>
					<?php 
					foreach ($rows as $row) {
						echo '<tr>';
							echo '<td>' . $row['c_id'] . '</td>';
							echo '<td>' . $row['comment'] . '</td>';
							echo '<td>' . $row['Name'] . '</td>';
							echo '<td>' . $row['Username'] . '</td>';
							echo '<td>' . $row['comment_date'] . '</td>';
							echo "<td> <a href='comments.php?do=Edit&comid=" . $row['c_id'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
							<a href='comments.php?do=delete&comid=" . $row['c_id'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
								 if ($row['status'] == 0 ) {
								 	echo "<a href='comments.php?do=approve&comid=" . $row['c_id'] ."' class='btn btn-info'> Approve</a>";
								 }
							 echo "</td>";	
						echo '</tr>';
					}
					?>
				</table>
			</div>
			
		</div>
	<?php } elseif ($do == 'delete') {  
	####################################
	#### Delete Page
	####################################	
		//if condition for security purposes to check if the user exist
		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
		$stmt->execute(array($comid));
		$count = $stmt->rowCount(); 

		if ($count > 0) {
			$stmt = $con->prepare("DELETE FROM comments WHERE c_id= :zcomment");
			$stmt->bindparam(":zcomment", $comid);
			$stmt->execute();
			// echo success message ?>
			<div class='alert alert-success'>
			<?php echo  $stmt->rowCount() . 'Record Deleted';
			echo "</div>"; 
		} else{
			$theMsg = "<div class='alert alert-danger'>There is no comment with this ID</div>";
			redirectHome($theMsg, 'back', 5); 
		}
	} elseif ($do == 'approve') {
		####################################
		#### Activate Page
		####################################	
		//if condition for security purposes to check if the user exist
		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? LIMIT 1");
		$stmt->execute(array($comid));
		$count = $stmt->rowCount(); 

		if ($count > 0) {
			$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ? ");
			$stmt->execute(array($comid));
			// echo success message ?>
			<div class='alert alert-success'>
			<?php echo  $stmt->rowCount() . 'Record Activated';
			echo "</div>"; 
			redirectHome("", 'back'); 
		} else{
			$theMsg = "<div class='alert alert-danger'>There is no member with this ID</div>";
			redirectHome($theMsg, 'back', 5); 
		}
	}
	
	elseif ($do == 'Edit') {
	####################################
	#### Edit Page
	####################################
		//if condition for security purposes
		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? LIMIT 1");
		$stmt->execute(array($comid));
		$comment = $stmt->fetch();
		$count = $stmt->rowCount(); 

		if ($count > 0) { ?>

			<h1 class="text-center">Edit comment</h1>
			<div class="container">
				<form METHOD="POST" action="?do=update" class="form-horizontal">
				<input type="hidden" name="comid" value="<?php echo $comid ?>" />
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Comment</label>
						<div class="col-md-6">
							<textarea class="form-control" name="comment">
							 <?php echo $comment['comment'] ?>
							</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<input type="submit" value="Save" class="form-control btn-primary" autocomplete="new-password">
						</div>
					</div>
				</form>
			</div>

	<?php	} else {
			$theMsg = "<div class='alert alert-danger'>sorry, there is no such id</div>";
			redirectHome($theMsg, 5);
	} 
	 	
 } 

	elseif ($do == 'update') {
		####################################
		#### Update Page
		####################################
		echo "<div class='container'>";
		echo "<h1 class='text-center'>Update Comment</h1>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// Get Variables form the form
			$id = $_POST['comid'];
			$comment = $_POST['comment'];

				// Update the DP with this Info
				$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ? ");
				$stmt->execute(array($comment, $id)); 
				// echo success message ?>
				<div class='alert alert-success'>
				<?php echo  $stmt->rowCount() . 'Record updated';
				echo "</div>"; 
				redirectHome("" ,'back', 5);		
		} else {
			$theMsg = "<div class='alert alert-danger'>sorry you can not browse this page directly</div>";
			redirectHome($theMsg, 5);
		}	
	}
	echo "</div>";
	include $tmp . 'footer.php';

}else{
	header('Location: index.php');
	exit();
}