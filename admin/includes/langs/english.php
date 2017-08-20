<?php

// common function for langs. you can find it in google
function lang($phrase) {

	static $lang = array(

		// Navbar keys
		'Logo' 		=> 'Home',
		'cat'   	=> 'Categories',
		'item'   	=> 'Items',
		'member'   	=> 'Members',
		'statistic'   => 'Statistics',
		'log'   	=> 'Logs',
		'name'   	=> 'Eltaher',

		);

	return $lang[$phrase];
}
