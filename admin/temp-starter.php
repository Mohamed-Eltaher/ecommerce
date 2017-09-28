<?php
	/*
	================================================
	== Template Page
	================================================
	*/
	ob_start(); // Output Buffering Start
	session_start();
	$pageTitle = 'Categories';
	if (isset($_SESSION['Username'])) {
		include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		if ($do == 'Manage') {
			echo 'manage page';
		} elseif ($do == 'add') {
		} elseif ($do == 'insert') {
		} elseif ($do == 'Edit') {
		} elseif ($do == 'update') {
		} elseif ($do == 'delete') {
		};
		include $tmp . 'footer.php';
	} else {
		header('Location: index.php');
		exit();
	}
	ob_end_flush(); // Release The Output
?>