<?php
include __DIR__ . '/.include.php';
$loop = 1e5;
var_dump('Loop: ' . $loop);

$input = '¤n';
$currencySymbol = '￥';
$amount = number_format(1234.5, 2);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $output = strtr($input, ['¤' => $currencySymbol, 'n' => $amount]);
}
var_dump('strtr: ' . $output , 'Time: ' . Timer::stop());

$input = '¤n';
$currencySymbol = '￥';
$amount = number_format(1234.5, 2);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $output = str_replace(['¤', 'n'], [$currencySymbol, $amount], $input);
}
var_dump('str_replace: ' . $output , 'Time: ' . Timer::stop());

$input = '%s%s';
$currencySymbol = '￥';
$amount = number_format(1234.5, 2);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $output = sprintf($input, $currencySymbol, $amount);
}
var_dump('sprintf: ' . $output , 'Time: ' . Timer::stop());

$currencySymbol = '￥';
$amount = number_format(1234.5, 2);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $output = $currencySymbol . $amount;
}
var_dump('concat: ' . $output , 'Time: ' . Timer::stop());
