<?php
require __DIR__ . '/.include.php';

$rounds = 1e4;
$data = [
    'test' => "\n",
    'request' => $_REQUEST,
    'server' => $_SERVER,
];

Timer::start();
for ($i = 0; $i < $rounds; ++$i) {
    $data = json_decode(json_encode($data), true);
}
var_dump('json_encode rounds ' . $rounds, Timer::stop());

Timer::start();
for ($i = 0; $i < $rounds; ++$i) {
    $data = unserialize(serialize($data));
}
var_dump('serialize rounds ' . $rounds, Timer::stop());

Timer::start();
for ($i = 0; $i < $rounds; ++$i) {
//    var_export($data, 1);
    eval('$data = ' . var_export($data, 1) . ';');
}
var_dump('var_export rounds ' . $rounds, Timer::stop());

Timer::start();
for ($i = 0; $i < $rounds; ++$i) {
    parse_str(http_build_query($data), $data);
}
var_dump('http_build_query rounds ' . $rounds, Timer::stop());

var_dump($data);
