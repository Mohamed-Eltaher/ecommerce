<?php

// condition ? true : false;  (shortlisted if)

$do = isset($_GET['do']) ? $_GET['do'] : 'mange';

// if the page is the main page

if ( $do == 'manage') {
	echo 'welcome you are in manage category page';
	echo '<a href="?do=insert"> Add New Category +</a>';  
} elseif ($do == 'add') {
	echo 'you are in add page';
} elseif ($do == 'insert') {
	echo 'you are in insert page';
} else {
	echo 'error there is no such page';
}

