<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 123919199,
		'offset' => -21600,
		'dst' => false
	),
	array(
		'from' => 123919200,
		'to' => 129617999,
		'offset' => -18000,
		'dst' => true
	),
	array(
		'from' => 129618000,
		'to' => 409039199,
		'offset' => -21600,
		'dst' => false
	),
	array(
		'from' => 409039200,
		'to' => 413873999,
		'offset' => -18000,
		'dst' => true
	),
	array(
		'from' => 413874000,
		'to' => 2147483647,
		'offset' => -21600,
		'dst' => false
	)
);
