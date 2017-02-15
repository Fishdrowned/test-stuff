<?php

function apiSign(array $data, $secret)
{
    ksort($data);
    unset($data['sign']);
    $sign = [];
    foreach ($data as $k => $v) {
        $sign[] = $k . '=' . $v;
    }
    $sign = implode('&', $sign);
    return md5(md5($sign) . $secret);
}

$data = $_REQUEST;
unset($data['secret']);
$secret = isset($_REQUEST['secret']) ? $_REQUEST['secret'] :
    (isset($_SERVER['HTTP_SECRET']) ? $_SERVER['HTTP_SECRET'] : '8da8d1d6b9f98229f4b465f68cd1a7c6');

var_dump($data, $secret, apiSign($data, $secret));
