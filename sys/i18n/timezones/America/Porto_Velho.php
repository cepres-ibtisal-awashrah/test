<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 499751999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 499752000,
		'to' => 511239599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 511239600,
		'to' => 530596799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 530596800,
		'to' => 540269999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 540270000,
		'to' => 562132799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 562132800,
		'to' => 571201199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 571201200,
		'to' => 2147483647,
		'offset' => -14400,
		'dst' => false
	)
);
