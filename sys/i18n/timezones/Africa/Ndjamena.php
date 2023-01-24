<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 308703599,
		'offset' => 3600,
		'dst' => false
	),
	array(
		'from' => 308703600,
		'to' => 321314399,
		'offset' => 7200,
		'dst' => true
	),
	array(
		'from' => 321314400,
		'to' => 2147483647,
		'offset' => 3600,
		'dst' => false
	)
);
