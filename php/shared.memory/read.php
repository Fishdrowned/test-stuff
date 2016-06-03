<?php
include dirname(__DIR__) . '/.include.php';
$shmKey = ftok(__DIR__ . '/create.php', 't');
if ($shmId = @shmop_open($shmKey, 'a', 0, 0)) {
	$shmSize = shmop_size($shmId);
	var_dump($shmKey, $shmId, $shmSize);
	$data = shmop_read($shmId, 0, $bytes = 8);
	var_dump("Read {$bytes} bytes of data: '{$data}'.", base_convert($data, 16, 10));
} else {
	var_dump('Failed to open shared memory.');
}
