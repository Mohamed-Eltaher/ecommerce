<?php

	session_start();

	if (isset($_SESSION['Username'])) {
		include 'init.php';
		include $tmp . 'footer.php';
	}else{
		header('Location: index.php');
		exit();
	}