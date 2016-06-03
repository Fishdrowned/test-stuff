<?php
include dirname(dirname(__DIR__)) . '/.include.php';

Timer::start();
for ($i = 0, $round = 1e4; $i < $round; ++$i) {
	$shmKey = ftok(__DIR__ . '/write.php', 't');
	$shmId = @shm_attach($shmKey, 1024);
	$data = shm_get_var($shmId, 0);
	shm_detach($shmId);
}
var_dump('shm_get_var', 'Read data:', $data, 'Rounds:', $round, 'Time:', Timer::stop());

Timer::start();
for ($i = 0; $i < $round; ++$i) {
	$file = __DIR__ . '/data.php';
	$data = is_file($file) ? include($file) : false;
}
var_dump('include', 'Read data:', $data, 'Rounds:', $round, 'Time:', Timer::stop());
