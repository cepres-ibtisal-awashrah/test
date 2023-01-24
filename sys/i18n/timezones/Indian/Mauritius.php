<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 403041599,
		'offset' => 14400,
		'dst' => false
	),
	array(
		'from' => 403041600,
		'to' => 417034799,
		'offset' => 18000,
		'dst' => true
	),
	array(
		'from' => 417034800,
		'to' => 1224971999,
		'offset' => 14400,
		'dst' => false
	),
	array(
		'from' => 1224972000,
		'to' => 1238273999,
		'offset' => 18000,
		'dst' => true
	),
	array(
		'from' => 1238274000,
		'to' => 2147483647,
		'offset' => 14400,
		'dst' => false
	)
);
