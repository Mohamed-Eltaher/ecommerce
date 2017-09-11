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