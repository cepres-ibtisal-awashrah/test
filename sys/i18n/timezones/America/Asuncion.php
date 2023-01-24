<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 86759999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 86760000,
		'to' => 134017199,
		'offset' => -10800,
		'dst' => false
	),
	array(
		'from' => 134017200,
		'to' => 181367999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 181368000,
		'to' => 194497199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 194497200,
		'to' => 212990399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 212990400,
		'to' => 226033199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 226033200,
		'to' => 244526399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 244526400,
		'to' => 257569199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 257569200,
		'to' => 276062399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 276062400,
		'to' => 291783599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 291783600,
		'to' => 307598399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 307598400,
		'to' => 323405999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 323406000,
		'to' => 339220799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 339220800,
		'to' => 354941999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 354942000,
		'to' => 370756799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 370756800,
		'to' => 386477999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 386478000,
		'to' => 402292799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 402292800,
		'to' => 418013999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 418014000,
		'to' => 433828799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 433828800,
		'to' => 449636399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 449636400,
		'to' => 465451199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 465451200,
		'to' => 481172399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 481172400,
		'to' => 496987199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 496987200,
		'to' => 512708399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 512708400,
		'to' => 528523199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 528523200,
		'to' => 544244399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 544244400,
		'to' => 560059199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 560059200,
		'to' => 575866799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 575866800,
		'to' => 591681599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 591681600,
		'to' => 607402799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 607402800,
		'to' => 625031999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 625032000,
		'to' => 638938799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 638938800,
		'to' => 654753599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 654753600,
		'to' => 670474799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 670474800,
		'to' => 686721599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 686721600,
		'to' => 699418799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 699418800,
		'to' => 718257599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 718257600,
		'to' => 733546799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 733546800,
		'to' => 749447999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 749448000,
		'to' => 762317999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 762318000,
		'to' => 780983999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 780984000,
		'to' => 793767599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 793767600,
		'to' => 812519999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 812520000,
		'to' => 825649199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 825649200,
		'to' => 844574399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 844574400,
		'to' => 856666799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 856666800,
		'to' => 876023999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 876024000,
		'to' => 888721199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 888721200,
		'to' => 907473599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 907473600,
		'to' => 920775599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 920775600,
		'to' => 938923199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 938923200,
		'to' => 952225199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 952225200,
		'to' => 970372799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 970372800,
		'to' => 983674799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 983674800,
		'to' => 1002427199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1002427200,
		'to' => 1018148399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1018148400,
		'to' => 1030852799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1030852800,
		'to' => 1049597999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1049598000,
		'to' => 1062907199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1062907200,
		'to' => 1081047599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1081047600,
		'to' => 1097985599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1097985600,
		'to' => 1110682799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1110682800,
		'to' => 1129435199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1129435200,
		'to' => 1142132399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1142132400,
		'to' => 1160884799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1160884800,
		'to' => 1173581999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1173582000,
		'to' => 1192939199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1192939200,
		'to' => 1205031599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1205031600,
		'to' => 1224388799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1224388800,
		'to' => 1236481199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1236481200,
		'to' => 1255838399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1255838400,
		'to' => 1270954799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1270954800,
		'to' => 1286078399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1286078400,
		'to' => 1302404399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1302404400,
		'to' => 1317527999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1317528000,
		'to' => 1333853999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1333854000,
		'to' => 1349582399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1349582400,
		'to' => 1365908399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1365908400,
		'to' => 1381031999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1381032000,
		'to' => 1397357999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1397358000,
		'to' => 1412481599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1412481600,
		'to' => 1428807599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1428807600,
		'to' => 1443931199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1443931200,
		'to' => 1460257199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1460257200,
		'to' => 1475380799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1475380800,
		'to' => 1491706799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1491706800,
		'to' => 1506830399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1506830400,
		'to' => 1523156399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1523156400,
		'to' => 1538884799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1538884800,
		'to' => 1555210799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1555210800,
		'to' => 1570334399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1570334400,
		'to' => 1586660399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1586660400,
		'to' => 1601783999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1601784000,
		'to' => 1618109999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1618110000,
		'to' => 1633233599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1633233600,
		'to' => 1649559599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1649559600,
		'to' => 1664683199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1664683200,
		'to' => 1681009199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1681009200,
		'to' => 1696132799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1696132800,
		'to' => 1713063599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1713063600,
		'to' => 1728187199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1728187200,
		'to' => 1744513199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1744513200,
		'to' => 1759636799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1759636800,
		'to' => 1775962799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1775962800,
		'to' => 1791086399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1791086400,
		'to' => 1807412399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1807412400,
		'to' => 1822535999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1822536000,
		'to' => 1838861999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1838862000,
		'to' => 1853985599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1853985600,
		'to' => 1870311599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1870311600,
		'to' => 1886039999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1886040000,
		'to' => 1902365999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1902366000,
		'to' => 1917489599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1917489600,
		'to' => 1933815599,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1933815600,
		'to' => 1948939199,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1948939200,
		'to' => 1965265199,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1965265200,
		'to' => 1980388799,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 1980388800,
		'to' => 1996714799,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 1996714800,
		'to' => 2011838399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 2011838400,
		'to' => 2028164399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 2028164400,
		'to' => 2043287999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 2043288000,
		'to' => 2059613999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 2059614000,
		'to' => 2075342399,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 2075342400,
		'to' => 2091668399,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 2091668400,
		'to' => 2106791999,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 2106792000,
		'to' => 2123117999,
		'offset' => -10800,
		'dst' => true
	),
	array(
		'from' => 2123118000,
		'to' => 2138241599,
		'offset' => -14400,
		'dst' => false
	),
	array(
		'from' => 2138241600,
		'to' => 2147483647,
		'offset' => -10800,
		'dst' => true
	)
);
