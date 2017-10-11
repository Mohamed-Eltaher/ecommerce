<?php
	session_start();
	$pageTitle = 'login';
	// if the user is registedred in the session, take him to the DashB
	if (isset($_SESSION['member'])) {
		header('Location: index.php'); 
	}; 
	include 'init.php'; 
	// Check If User Coming From HTTP Post Request
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);  // for security purposes we use sha1

		// Check If The User Exist In Database
		$stmt = $con->prepare("SELECT 
									Username, Password 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									Password = ? ");

		$stmt->execute(array($username, $hashedPass));
		$count = $stmt->rowCount();
		// If Count > 0 This Mean The Database Contain Record About This Username
		if ($count > 0) {
			$_SESSION['member'] = $username; // Register Session Name
			header('Location: index.php'); // Redirect To Dashboard Page
			exit();
		} 
	}	
?>
<div class="container">
	<div class="login-page">
		<h1 class="text-center in-out">
		 	<span data-class="login" class='selected'>Login</span> | <span data-class="signup">Signup</span>
		</h1>
		<!-- Start Login Form -->
		<form class="login inlog" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="form-group">
				<input class="form-control input-lg" type="text" name="user" placeholder="type your username" autocomplete="off" required="required" />
			</div>
			<div class="form-group">
				<input class="form-control input-lg" type="password" name="pass" placeholder=" type your password" autocomplete="new-password" required="required" />
			</div>
			<input class="btn btn-primary btn-lg btn-block" type="submit" value="login" />
		</form>
		<!-- End Login Form -->

		<!-- Start Signup Form -->
		<form class="signup inlog" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="form-group">
				<input class="form-control input-lg" type="text" name="user" placeholder="type your username" autocomplete="off" required="required" />
			</div>
			<div class="form-group">
				<input class="form-control input-lg" type="password" name="pass" placeholder=" type your password" autocomplete="new-password" required="required" />
			</div>
			<div class="form-group">
				<input class="form-control input-lg" type="email" name="email" placeholder="type your Email" autocomplete="off" required="required" />
			</div>
			<input class="btn btn-success btn-lg btn-block" type="Signout" value="signout" />
		</form>
		<!-- End Signup Form -->
	</div>
</div>  
<?php include $tmp . 'footer.php'; ?>	