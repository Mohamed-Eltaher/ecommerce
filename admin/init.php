<?php

include 'connect.php';    // so if you needed db, just include init.php in your page

// Routes
$func = 'includes/functions/';   // functions Directory
$lang= 'includes/langs/';  // Lang Directory
$tmp = 'includes/templates/';   // Templates Directory
$css = 'layout/css/';   // css Directory
$js = 'layout/js/';   // js Directory


include $func . 'functions.php';
include $lang . 'english.php';
include $tmp . 'header.php';
if (!isset($noNavbar)){include $tmp . 'navbar.php';}
