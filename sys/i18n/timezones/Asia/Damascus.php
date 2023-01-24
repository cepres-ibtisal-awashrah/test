<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$transitions = array(
	array(
		'from' => 0,
		'to' => 10367999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 10368000,
		'to' => 23583599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 23583600,
		'to' => 41903999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 41904000,
		'to' => 55119599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 55119600,
		'to' => 73526399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 73526400,
		'to' => 86741999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 86742000,
		'to' => 105062399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 105062400,
		'to' => 118277999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 118278000,
		'to' => 136598399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 136598400,
		'to' => 149813999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 149814000,
		'to' => 168134399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 168134400,
		'to' => 181349999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 181350000,
		'to' => 199756799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 199756800,
		'to' => 212972399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 212972400,
		'to' => 231292799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 231292800,
		'to' => 241916399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 241916400,
		'to' => 262828799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 262828800,
		'to' => 273452399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 273452400,
		'to' => 418694399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 418694400,
		'to' => 433810799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 433810800,
		'to' => 450316799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 450316800,
		'to' => 465433199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 465433200,
		'to' => 508895999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 508896000,
		'to' => 529196399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 529196400,
		'to' => 541555199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 541555200,
		'to' => 562633199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 562633200,
		'to' => 574387199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 574387200,
		'to' => 594255599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 594255600,
		'to' => 607305599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 607305600,
		'to' => 623199599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 623199600,
		'to' => 638927999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 638928000,
		'to' => 654649199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 654649200,
		'to' => 670456799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 670456800,
		'to' => 686264399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 686264400,
		'to' => 702683999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 702684000,
		'to' => 717886799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 717886800,
		'to' => 733096799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 733096800,
		'to' => 748904399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 748904400,
		'to' => 765151199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 765151200,
		'to' => 780958799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 780958800,
		'to' => 796687199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 796687200,
		'to' => 812494799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 812494800,
		'to' => 828309599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 828309600,
		'to' => 844117199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 844117200,
		'to' => 859759199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 859759200,
		'to' => 875653199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 875653200,
		'to' => 891208799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 891208800,
		'to' => 907189199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 907189200,
		'to' => 922917599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 922917600,
		'to' => 938725199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 938725200,
		'to' => 954539999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 954540000,
		'to' => 970347599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 970347600,
		'to' => 986075999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 986076000,
		'to' => 1001883599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1001883600,
		'to' => 1017611999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1017612000,
		'to' => 1033419599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1033419600,
		'to' => 1049147999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1049148000,
		'to' => 1064955599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1064955600,
		'to' => 1080770399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1080770400,
		'to' => 1096577999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1096578000,
		'to' => 1112306399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1112306400,
		'to' => 1128113999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1128114000,
		'to' => 1143842399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1143842400,
		'to' => 1158872399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1158872400,
		'to' => 1175205599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1175205600,
		'to' => 1193950799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1193950800,
		'to' => 1207259999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1207260000,
		'to' => 1225486799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1225486800,
		'to' => 1238104799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1238104800,
		'to' => 1256849999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1256850000,
		'to' => 1270159199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1270159200,
		'to' => 1288299599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1288299600,
		'to' => 1301608799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1301608800,
		'to' => 1319749199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1319749200,
		'to' => 1333663199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1333663200,
		'to' => 1351198799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1351198800,
		'to' => 1365112799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1365112800,
		'to' => 1382648399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1382648400,
		'to' => 1396562399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1396562400,
		'to' => 1414702799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1414702800,
		'to' => 1428011999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1428012000,
		'to' => 1446152399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1446152400,
		'to' => 1459461599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1459461600,
		'to' => 1477601999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1477602000,
		'to' => 1491515999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1491516000,
		'to' => 1509051599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1509051600,
		'to' => 1522965599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1522965600,
		'to' => 1540501199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1540501200,
		'to' => 1554415199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1554415200,
		'to' => 1571950799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1571950800,
		'to' => 1585864799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1585864800,
		'to' => 1604005199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1604005200,
		'to' => 1617314399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1617314400,
		'to' => 1635454799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1635454800,
		'to' => 1648763999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1648764000,
		'to' => 1666904399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1666904400,
		'to' => 1680818399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1680818400,
		'to' => 1698353999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1698354000,
		'to' => 1712267999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1712268000,
		'to' => 1729803599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1729803600,
		'to' => 1743717599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1743717600,
		'to' => 1761857999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1761858000,
		'to' => 1775167199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1775167200,
		'to' => 1793307599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1793307600,
		'to' => 1806616799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1806616800,
		'to' => 1824757199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1824757200,
		'to' => 1838671199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1838671200,
		'to' => 1856206799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1856206800,
		'to' => 1870120799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1870120800,
		'to' => 1887656399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1887656400,
		'to' => 1901570399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1901570400,
		'to' => 1919105999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1919106000,
		'to' => 1933019999,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1933020000,
		'to' => 1951160399,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1951160400,
		'to' => 1964469599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1964469600,
		'to' => 1982609999,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 1982610000,
		'to' => 1995919199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 1995919200,
		'to' => 2014059599,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 2014059600,
		'to' => 2027973599,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 2027973600,
		'to' => 2045509199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 2045509200,
		'to' => 2059423199,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 2059423200,
		'to' => 2076958799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 2076958800,
		'to' => 2090872799,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 2090872800,
		'to' => 2109013199,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 2109013200,
		'to' => 2122322399,
		'offset' => 7200,
		'dst' => false
	),
	array(
		'from' => 2122322400,
		'to' => 2140462799,
		'offset' => 10800,
		'dst' => true
	),
	array(
		'from' => 2140462800,
		'to' => 2147483647,
		'offset' => 7200,
		'dst' => false
	)
);
