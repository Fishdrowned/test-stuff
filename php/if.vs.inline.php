<?php
include __DIR__ . '/.include.php';

$loop = 5e5;
var_dump(sprintf('Loop count: %s', $loop));

$expected = [
    'foo' => 'bar',
    'hello' => 'world',
    'some' => 'else',
];

$value = null;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $condition = true;
    if ($condition) {
        $value = [
            'foo' => 'bar',
            'hello' => 'world',
            'some' => 'else',
        ];
    } else {
        $value = false;
    }
}
$cost = Timer::stop();
var_dump(sprintf('If result: %s, time cost: %s seconds, %s microseconds per loop',
    var_export($expected == $value, true),
    $cost,
    $cost * 1e6 / $loop
));

$value = null;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $condition = true;
    $value = $condition ? [
        'foo' => 'bar',
        'hello' => 'world',
        'some' => 'else',
    ] : false;
}
$cost = Timer::stop();
var_dump(sprintf('?: result: %s, time cost: %s seconds, %s microseconds per loop',
    var_export($expected == $value, true),
    $cost,
    $cost * 1e6 / $loop
));

$value = null;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $condition = true;
    $condition ? $value = [
        'foo' => 'bar',
        'hello' => 'world',
        'some' => 'else',
    ] : $value = false;
}
$cost = Timer::stop();
var_dump(sprintf('?: alt result: %s, time cost: %s seconds, %s microseconds per loop',
    var_export($expected == $value, true),
    $cost,
    $cost * 1e6 / $loop
));

$value = null;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $condition = true;
    $condition and $value = [
        'foo' => 'bar',
        'hello' => 'world',
        'some' => 'else',
    ];
}
$cost = Timer::stop();
var_dump(sprintf('and result: %s, time cost: %s seconds, %s microseconds per loop',
    var_export($expected == $value, true),
    $cost,
    $cost * 1e6 / $loop
));
