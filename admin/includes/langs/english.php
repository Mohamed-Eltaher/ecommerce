<?php

// common function for langs. you can find it in google
function lang($phrase) {

	static $lang = array(

		// Navbar keys
		'Logo' => 'Eltaher',
		'Cat'   => 'Categories',

		);

	return $lang[$phrase];
}
