<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 9971999,
		'offset' => -28800,
		'dst' => false
	),
	array(
		'from' => 9972000,
		'to' => 25693199,
		'offset' => -25200,
		'dst' => true
	),
	array(
		'from' => 25693200,
		'to' => 41421599,
		'offset' => -28800,
		'dst' => false
	),
	array(
		'from' => 41421600,
		'to' => 57747599,
		'offset' => -25200,
		'dst' => true
	),
	array(
		'from' => 57747600,
		'to' => 73475999,
		'offset' => -28800,
		'dst' => false
	),
	array(
		'from' => 73476000,
		'to' => 84013199,
		'offset' => -25200,
		'dst' => true
	),
	array(
		'from' => 84013200,
		'to' => 2147483647,
		'offset' => -25200,
		'dst' => false
	)
);
