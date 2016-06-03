<?php
include __DIR__ . '/.include.php';

function prepareSignatureData(array $data)
{
    ksort($data);
    unset($data['sign']);
    $string = [];
    foreach ($data as $k => $v) {
        $string[] = $k . '=' . $v;
    }
    return implode('&', $string);
}

function sha256($data, $raw = false)
{
    return hash('sha256', $data, $raw);
}

function signArrayMd5($data, $secret)
{
    return md5(md5($data) . $secret);
}

function signArraySha256($data, $secret)
{
    return hash('sha256', hash('sha256', $data) . $secret);
}

function signArrayHmacSha256($data, $secret)
{
    return hash_hmac('sha256', $data, $secret);
}

$data = ['abc' => 'def', 'xx' => 'oo'];
$data = prepareSignatureData($data);
$secret = '1234abcd';
var_dump('Loop: ' . $loop = 1e5);

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = signArraySha256($data, $secret);
}
var_dump('signArraySha256():', signArraySha256($data, $secret), Timer::stop());

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = signArrayHmacSha256($data, $secret);
}
var_dump('signArrayHmacSha256():', signArrayHmacSha256($data, $secret), Timer::stop());

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = signArrayMd5($data, $secret);
}
var_dump('signArrayMd5():', signArrayMd5($data, $secret), Timer::stop());

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = signArrayMd5($data, $secret);
}
var_dump('signArrayMd5():', signArrayMd5($data, $secret), Timer::stop());
