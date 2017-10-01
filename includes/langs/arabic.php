<?php

function lang($phrase) {

	static $lang = array(

		'MESSAGE' => 'Welcome in Arabic',
		'Admin'   => 'Administrator in Arabic',

		);
	
	return $lang[$phrase];
}
