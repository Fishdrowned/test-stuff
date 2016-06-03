<?php
require __DIR__ . '/.include.php';

var_dump('clone ' . $count = 1e6);
$obj = new Timer();
Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $x = clone $obj;
}
var_dump(Timer::stop(), round(memory_get_usage() / 1024 / 1024, 2) . 'M');

var_dump('new ' . $count);
Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $x = new Timer();
}
var_dump(Timer::stop(), round(memory_get_usage() / 1024 / 1024, 2) . 'M');
