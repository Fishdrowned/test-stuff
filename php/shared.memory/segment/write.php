<?php
include dirname(dirname(__DIR__)) . '/.include.php';
$shmKey = ftok(__DIR__ . '/write.php', 't');
if ($shmId = @shm_attach($shmKey, 1024)) {
	$data = include(__DIR__ . '/data.php');
	shm_put_var($shmId, 0, $data);
	var_dump('Written data:', $data);
	shm_detach($shmId);
} else {
	var_dump('Failed to open shared memory.');
}
