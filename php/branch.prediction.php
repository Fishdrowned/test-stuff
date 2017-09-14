<?php
include __DIR__ . '/.include.php';

// 测试分支预测影响
$loop = 1e2;
$randomArray = [];
$arraySize = 32768;
for ($c = 0; $c < $arraySize; ++$c) {
    $randomArray[] = mt_rand(0, 255);
}
$sortedArray = $reverseSortedArray = $randomArray;
sort($sortedArray);
rsort($reverseSortedArray);

// Calculate sum of elements >= 128

// on a random array
$sum = 0;
var_dump("Random array foreach, {$loop} loops");
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    foreach ($randomArray as $v) {
        $v >= 128 and $sum += $v;
    }
}
var_dump(Timer::stop() . ' seconds, sum: ' . $sum);
// 0.170329 seconds, sum: 313973700
// 0.17222 seconds, sum: 313123700
// 0.176975 seconds, sum: 315014100

// on a sorted array
$sum = 0;
var_dump("Sorted array foreach, {$loop} loops");
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    foreach ($sortedArray as $v) {
        $v >= 128 and $sum += $v;
    }
}
var_dump(Timer::stop() . ' seconds, sum: ' . $sum);
// 0.145282 seconds, sum: 313973700
// 0.149103 seconds, sum: 313123700
// 0.144432 seconds, sum: 315014100

// on a reverse sorted array
$sum = 0;
var_dump("Sorted array foreach, {$loop} loops");
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    foreach ($reverseSortedArray as $v) {
        $v >= 128 and $sum += $v;
    }
}
var_dump(Timer::stop() . ' seconds, sum: ' . $sum);
// 0.146905 seconds, sum: 313973700
// 0.147795 seconds, sum: 313123700
// 0.144523 seconds, sum: 315014100
