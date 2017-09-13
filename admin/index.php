<?php

	session_start();
	if (isset($_SESSION['Username'])) {
		header('Location: dashboard.php'); // Redirect To Dashboard Page
	}; 

	$noNavbar = "";   // variable to prevent showing navbar at admin page
	$pageTitle = 'login';

	include 'init.php';

	// Check If User Coming From HTTP Post Request
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);  // for security purposes we use sha1

		// Check If The User Exist In Database
		$stmt = $con->prepare("SELECT 
									UserID, Username, Password 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									Password = ? 
								AND 
									GroupID = 1
								LIMIT 1");

		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		// If Count > 0 This Mean The Database Contain Record About This Username
		if ($count > 0) {
			$_SESSION['Username'] = $username; // Register Session Name
			$_SESSION['ID'] = $row['UserID']; // Register Session ID
			header('Location: dashboard.php'); // Redirect To Dashboard Page
			exit();
		}
	}
	
?>	
	<!-- Admin Login Form-->	
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center text-capitalize">admin login</h4>
		<input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-lg btn-block" type="submit" value="login" />
	</form>	

<?php
	include $tmp . 'footer.php';
?>	