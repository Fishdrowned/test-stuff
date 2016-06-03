<?php
function base62encode($val) {
	$val = (int)abs($val);
	$base = 62;
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str = '';
	do {
		$i = $val % $base;
		$str = $chars[$i] . $str;
		$val = ($val - $i) / $base;
	} while($val > 0);
	return $str;
}

function generateAvatarUrl($id) {
	$hash = crc32($id) + 3e5;
	$path = substr_replace(substr(base62encode($hash), 0, 4), '/', 2, 0);
	$path = substr(base62encode(crc32($id) + 62), 0, 2);
	$fileName = base62encode($id);
	$url = 'uploads/avatar/' . $path . '/' . $fileName . '.png';
	return $url;
}

foreach (array(100548841940001304, 393842, 3938425, 39384256, 1, 2, 3, 4, 62, 0) as $id) {
	$url = generateAvatarUrl($id);
	var_dump($url);
}
