<?php
include __DIR__ . '/.include.php';

$loop = 1e6;
$pow = 6;

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $result = $i ** $pow;
}
var_dump('**: ' . Timer::stop());

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $result = pow($i, $pow);
}
var_dump('pow(): ' . Timer::stop());
