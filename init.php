<?php

// Error Reporting
ini_set('display_errors', 'on');
error_reporting(E_ALL);

include 'admin/connect.php'; // so if you needed db, just include init.php in your page

// Registering session user in a var to use it everywhere
$sessionUser = "";
if (isset($_SESSION['member'])) {
	$sessionUser =  $_SESSION['member'];
}

// Routes
$func = 'includes/functions/';   // functions Directory
$lang= 'includes/langs/';  // Lang Directory
$tmp = 'includes/templates/';   // Templates Directory
$css = 'admin/layout/css/';   // css Directory
$frontcss = 'layout/css/';   // frontend css Directory
$js = 'admin/layout/js/';   // js Directory
$frontjs = 'layout/js/';   // Frontend js Directory


include $func . 'functions.php';
include $lang . 'english.php';
include $tmp . 'header.php';

