<?php
include __DIR__ . '/.include.php';

function someFunction()
{
}

class someClassWithStaticMethods
{

    public static function someFunction()
    {
    }
}

$loop = 1e6;
var_dump(sprintf('Loop count: %s', $loop));

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    someFunction();
}
$cost = Timer::stop();
var_dump(sprintf('someFunction time cost: %s seconds, %s microseconds per loop',
    $cost,
    $cost * 1e6 / $loop
));
// php5.6: 0.693548, php7: 0.596769

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    someClassWithStaticMethods::someFunction();
}
$cost = Timer::stop();
var_dump(sprintf('someClassWithStaticMethods time cost: %s seconds, %s microseconds per loop',
    $cost,
    $cost * 1e6 / $loop
));
// php5.6: 0.762555, php7: 0.696835
