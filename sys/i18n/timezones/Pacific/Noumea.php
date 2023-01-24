<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 250001999,
		'offset' => 39600,
		'dst' => false
	),
	array(
		'from' => 250002000,
		'to' => 257342399,
		'offset' => 43200,
		'dst' => true
	),
	array(
		'from' => 257342400,
		'to' => 281451599,
		'offset' => 39600,
		'dst' => false
	),
	array(
		'from' => 281451600,
		'to' => 288878399,
		'offset' => 43200,
		'dst' => true
	),
	array(
		'from' => 288878400,
		'to' => 849365999,
		'offset' => 39600,
		'dst' => false
	),
	array(
		'from' => 849366000,
		'to' => 857228399,
		'offset' => 43200,
		'dst' => true
	),
	array(
		'from' => 857228400,
		'to' => 2147483647,
		'offset' => 39600,
		'dst' => false
	)
);
