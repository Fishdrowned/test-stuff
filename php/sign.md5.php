<?php

function apiSign(array $data, $secret) {
	ksort($data);
	unset($data['sign']);
	$sign = array();
	foreach ($data as $k => $v) {
		$sign[] = $k . '=' . $v;
	}
	$sign = implode('&', $sign);
	return md5(md5($sign) . $secret);
}

var_dump($_REQUEST, apiSign($_REQUEST, '8da8d1d6b9f98229f4b465f68cd1a7c6'));
