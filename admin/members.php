<?php

/*
============================================
== Manage Members Page
== Here you can edit, add , delete members
=============================================
*/

session_start();
$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
	include 'init.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
	if ($do == 'manage') { 
	####################################
	#### Manage Page
	####################################

		$query = "";
		if (isset($_GET['page']) && $_GET['page'] == 'pending') {
			$query = 'AND RegStatus = 0';
		}
		// select all users except Admin 
		$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
		// execute the statement
		$stmt->execute();
		// Assign the statement to variable
		$rows = $stmt->fetchAll();
?>
		<h1 class="text-center">Manage Member</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="table table-bordered text-center">
					<tr class="info">
						<td>#ID</td>
						<td>Username</td>
						<td>Email</td>
						<td>Fullname</td>
						<td>Registered date</td>
						<td>Control</td>
					</tr>
					<?php 
					foreach ($rows as $row) {
						echo '<tr>';
							echo '<td>' . $row['UserID'] . '</td>';
							echo '<td>' . $row['Username'] . '</td>';
							echo '<td>' . $row['Email'] . '</td>';
							echo '<td>' . $row['Fullname'] . '</td>';
							echo '<td>' . $row['Date'] . '</td>';
							echo "<td> <a href='members.php?do=Edit&userid=" . $row['UserID'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
							<a href='members.php?do=delete&userid=" . $row['UserID'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
								 if ($row['RegStatus'] == 0 ) {
								 	echo "<a href='members.php?do=activate&userid=" . $row['UserID'] ."' class='btn btn-info'> Activate</a>";
								 }
							 echo "</td>";	
						echo '</tr>';
					}
					?>
				</table>
			</div>
			<a href='members.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i> new member</a>
		</div>
	<?php } elseif ($do == 'delete') {  
	####################################
	#### Delete Page
	####################################	
		//if condition for security purposes to check if the user exist
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
		$stmt->execute(array($userid));
		$count = $stmt->rowCount(); 

		if ($count > 0) {
			$stmt = $con->prepare("DELETE FROM users WHERE UserID= :zuser");
			$stmt->bindparam(":zuser", $userid);
			$stmt->execute();
			// echo success message ?>
			<div class='alert alert-success'>
			<?php echo  $stmt->rowCount() . 'Record Deleted';
			echo "</div>"; 
		} else{
			$theMsg = "<div class='alert alert-danger'>There is no member with this ID</div>";
			redirectHome($theMsg, 'back', 5); 
		}
	} elseif ($do == 'activate') {
		####################################
		#### Activate Page
		####################################	
		//if condition for security purposes to check if the user exist
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
		$stmt->execute(array($userid));
		$count = $stmt->rowCount(); 

		if ($count > 0) {
			$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ? ");
			$stmt->execute(array($userid));
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
	
	 elseif ($do == 'add') {
	####################################
	#### ADD Page
	####################################
	?>	
		<h1 class="text-center">Add Member</h1>
			<div class="container">
				<form METHOD="POST" action="?do=insert" class="form-horizontal">		
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">User Name</label>
						<div class="col-md-6">
							<input type="text" name="username" class="form-control" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Password</label>
						<div class="col-md-6">	
							<input type="Password" name="password" class="form-control password" autocomplete="new-password" required="required">
							<i class="show-pass fa fa-eye fa-2x"></i>
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Email</label>
						<div class="col-md-6">
							<input type="Email" name="email" class="form-control" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Full Name</label>
						<div class="col-md-6">
							<input type="text" name="fullname" class="form-control" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<input type="submit" value="ADD" class="form-control btn-primary">
						</div>
					</div>
				</form>
			</div>
	<?php }

	elseif ($do == 'insert') {
		####################################
		#### Insert Page
		####################################
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			echo "<div class='container'>";
			echo "<h1 class='text-center'>Update Member</h1>";

			// Get Variables form the form	
			$user = $_POST['username'];
			$email = $_POST['email'];
			$pass = $_POST['password'];
			$name = $_POST['fullname'];

			$hashpass= sha1($_POST['password']);
			
			//validation of the form
			$formErorres = array();
			if (strlen($user) < 4 ) {
				$formErorres[] = "Username can not be less than 4 letters";
			}
			if (empty($user)) {
				$formErorres[] = "Username can not be empty";
			}
			if (empty($email)) {
				$formErorres[] = "Email can not be empty";
			}
			if (empty($pass)) {
				$formErorres[] = "Password can not be empty";
			}
			if (empty($name)) {
				$formErorres[] = "Full Name can not be empty";
			}

			foreach ($formErorres as $erorr) {
				echo "<div class='alert alert-danger'> $erorr </div>";
			}

			if (empty($formErorres)) {
				// check if the member already exist in database
				$check = checkItem("Username", "users", $user);
				if ($check == 1) {
					echo 'Sorry, this member exist in database';
				} else{
				// insert userinfo into DP
				$stmt = $con->prepare("INSERT INTO users(Username, Password, Email, Fullname, RegStatus, Date)
										 VALUES(:zuser, :zpass, :zmail, :zname, 1, now()) ");
				$stmt->execute(array(
						'zuser' => $user,
						'zpass' => $hashpass,
						'zmail' => $email,
						'zname' => $name
					));
				// echo success message ?>
				<div class='alert alert-success'>
				<?php echo  $stmt->rowCount() . 'Record updated';
				echo "</div>";

				redirectHome('', 'back'); 
				}
			}
			
		} else {
			$theMsg = "<div class='alert alert-danger'>sorry, there is no such id</div>";
			redirectHome($theMsg, 5);
		}
		echo "</div>";	
	}
	
	elseif ($do == 'Edit') {
	####################################
	#### Edit Page
	####################################
		//if condition for security purposes
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount(); 

		if ($count > 0) { ?>

			<h1 class="text-center">Edit Member</h1>
			<div class="container">
				<form METHOD="POST" action="?do=update" class="form-horizontal">
				<input type="hidden" name="userid" value="<?php echo $userid ?>" />
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">User Name</label>
						<div class="col-md-6">
							<input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Password</label>
						<div class="col-md-6">
							<input type="hidden" name="old-password" value="<?php echo $row['Password'] ?>" />
							<input type="Password" name="new-password" class="form-control" autocomplete="new-password">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Email</label>
						<div class="col-md-6">
							<input type="Email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Full Name</label>
						<div class="col-md-6">
							<input type="text" name="fullname" class="form-control" value="<?php echo $row['Fullname'] ?>" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<input type="submit" value="Update" class="form-control btn-primary" autocomplete="new-password">
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
		echo "<h1 class='text-center'>Update Member</h1>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// Get Variables form the form
			$id = $_POST['userid'];
			$user = $_POST['username'];
			$email = $_POST['email'];
			$name = $_POST['fullname'];
			// password trick
			$pass = empty($_POST['new-password']) ? $_POST['old-password'] : sha1($_POST['new-password']);

			//validation of the form
			$formErorres = array();
			if (strlen($user) < 4 ) {
				$formErorres[] = "Username can not be less than 4 letters";
			}
			if (empty($user)) {
				$formErorres[] = "Username can not be empty";
			}
			if (empty($email)) {
				$formErorres[] = "Email can not be empty";
			}
			if (empty($name)) {
				$formErorres[] = "Full Name can not be empty";
			}

			foreach ($formErorres as $erorr) {
				echo "<div class='alert alert-danger'> $erorr </div>";
			}

			if (empty($formErorres)) {
				// Update the DP with this Info
				$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, Fullname = ?, Password = ? WHERE UserID = ? ");
				$stmt->execute(array($user, $email, $name, $pass, $id)); 
				// echo success message ?>
				<div class='alert alert-success'>
				<?php echo  $stmt->rowCount() . 'Record updated';
				echo "</div>"; 
				redirectHome("" ,'back', 5);
			}
			
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