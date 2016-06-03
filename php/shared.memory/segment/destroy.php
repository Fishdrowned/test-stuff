<?php
include dirname(dirname(__DIR__)) . '/.include.php';
$shmKey = ftok(__DIR__ . '/write.php', 't');
if ($shmId = @shm_attach($shmKey, 1024)) {
	shm_remove($shmId);
	var_dump('Deleted share memory.');
	shm_detach($shmId);
} else {
	var_dump('Failed to open shared memory.');
}
