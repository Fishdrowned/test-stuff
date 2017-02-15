<?php
include __DIR__ . '/.include.php';

$loop = 1e3;
var_dump('loop = ' . $loop);
$array = [];
$arraySize = 1000;
for ($i = 0; $i < $arraySize; ++$i) {
    $v = md5($i);
    $array[$v] = $v . ' - ' . $i;
}
var_dump('array size: ' . count($array));

$newArray = [];

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $newArray = [];
    foreach ($array as $k => $v) {
        $newArray[$k] = $v;
    }
}
$cost = Timer::stop();
var_dump(sprintf('foreach: %s seconds, %s microseconds per loop, result check: %s', $cost, $cost * 1e6 / $loop, var_export($array === $newArray, true)));

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $newArray = [];
    $keys = array_keys($array);
    $count = sizeof($keys);
    for ($j = 0; $j < $count; ++$j) {
        $newArray[$keys[$j]] = $array[$keys[$j]];
    }
}
$cost = Timer::stop();
var_dump(sprintf('for array_keys: %s seconds, %s microseconds per loop, result check: %s', $cost, $cost * 1e6 / $loop, var_export($array === $newArray, true)));

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $newArray = [];
    reset($array);
    while (list($k) = each($array)) {
        $newArray[$k] = $array[$k];
    }
}
$cost = Timer::stop();
var_dump(sprintf('while each: %s seconds, %s microseconds per loop, result check: %s', $cost, $cost * 1e6 / $loop, var_export($array === $newArray, true)));
