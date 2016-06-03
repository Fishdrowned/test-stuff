<?php
require __DIR__ . '/.include.php';

$rounds = 5e3;
$data = array(
	'test' => "\n",
	'request' => $_REQUEST,
	'server' => $_SERVER,
);

Timer::start();
for ($i = 0; $i < $rounds; ++$i) {
	json_decode(json_encode($data), true);
}
var_dump('json_encode rounds ' . $rounds, Timer::stop(), json_encode($data));

Timer::start();
for ($i = 0; $i < $rounds; ++$i) {
	unserialize(serialize($data));
}
var_dump('serialize rounds ' . $rounds, Timer::stop(), serialize($data));

Timer::start();
for ($i = 0; $i < $rounds; ++$i) {
	parse_str(http_build_query($data));
}
var_dump('http_build_query rounds ' . $rounds, Timer::stop(), http_build_query($data));

var_dump($data);
