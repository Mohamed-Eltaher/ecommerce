<?php

$dsn = 'mysql:host=localhost;dbname=shop';  // name of your db

$user = 'root';  // general user

$pass= "";  // no pass

$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
	);

try {
	$con = new PDO($dsn, $user, $pass, $option);

	$con->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e) {
	echo 'failed to connect' . $e->getMessage();
}