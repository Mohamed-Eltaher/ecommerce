<?php

include 'admin/connect.php';    // so if you needed db, just include init.php in your page

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

