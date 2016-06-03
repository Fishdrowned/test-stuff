<?php

include __DIR__ . '/.include.php';

function isMd5Ctype($value)
{
    return isset($value{31}) && !isset($value{32}) && ctype_xdigit($value);
}

function isMd5Regx($md5 ='')
{
    return preg_match('/^[a-f0-9]{32}$/', $md5);
}

$count = 1e5;
$md5 = '60dace79a7bbe1d1c3c3d849cd3fd341';
var_dump('$md5 = ' . $md5);
Timer::start();
for ($i = 1; $i < $count; ++$i) {
    $a = isMd5Ctype($md5);
}
var_dump('isMd5Ctype($md5) = ' . var_export(isMd5Ctype($md5), 1));
var_dump('isMd5Ctype total seconds: ' . $t = Timer::stop(), 'Microseconds for each: ' . $t * 1e6 / $count);

Timer::start();
for ($i = 1; $i < $count; ++$i) {
    $a = isMd5Regx($md5);
}
var_dump('isMd5Regx($md5) = ' . var_export(isMd5Regx($md5), 1));
var_dump('isMd5Regx total seconds: ' . $t = Timer::stop(), 'Microseconds for each: ' . $t * 1e6 / $count);
var_dump($md5{32});
