<?php
// function to type page name
function page_title () {
	global $pageTitle;
	if (isset($pageTitle)) {
		echo $pageTitle;
	} else {
		echo 'Default';
	}
}
/*
** Home Redirect Function v2.0
** This Function Accept Parameters
** $theMsg = Echo The Message [ Error | Success | Warning ]
** $url = The Link You Want To Redirect To
** $seconds = Seconds Before Redirecting
*/
function redirectHome($theMsg, $url = null, $seconds = 3) {
	if ($url === null) {
		$url = 'index.php';
		$link = 'Homepage';
	} else {
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'Previous Page';
		} else {
			$url = 'index.php';
			$link = 'Homepage';
		}
	}
	echo $theMsg;
	echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";
	header("refresh:$seconds;url=$url");
	exit();
}

/*
** Check Items Function v1.0
** Function to Check Item In Database [ Function Accept Parameters ]
** $select = The Item To Select [ Example: user, item, category ]
** $from = The Table To Select From [ Example: users, items, categories ]
** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
*/
function checkItem($select, $from, $value) {
	global $con;
	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count;
}


/*
** Count Number Of Items Function v1.0
** Function To Count Number Of Items Rows
** $item = The Item To Count
** $table = The Table To Choose From
*/
function countItems($item, $table) {
	global $con;
	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
	$stmt2->execute();
	return $stmt2->fetchColumn();
}

/* check user reg status */

function userStatus($user) {
	global $con;
	$stmt = $con->prepare("SELECT 
									Username, Regstatus 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									Regstatus = 0 ");

		$stmt->execute(array($user));
		$count = $stmt->rowCount();
		return $count;
}

/*
** get latest records function V 0.1
** Function To get latest items from DP
** $select = The Item To Count
** $table = The Table To Choose From
** $limit = number of items to get
*/

function getLatest($select, $table, $order, $limit = 5) {
	global $con;
	$stmGet = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
	$stmGet->execute();
	$rows = $stmGet->fetchAll();
	return $rows;
}

