<?php
include dirname(dirname(__DIR__)) . '/.include.php';
if (0) {
	$shmKey = ftok(__DIR__ . '/write.php', 't');
	if ($shmId = @shm_attach($shmKey, 1024)) {
		if (shm_has_var($shmId, 0)) {
			$data = shm_get_var($shmId, 0);
			var_dump('Read data:', $data);
		} else {
			var_dump('Failed to read from shared memory.');
		}
		shm_detach($shmId);
	} else {
		var_dump('Failed to open shared memory.');
	}
} else {
	$file = __DIR__ . '/data.php';
	$data = is_file($file) ? include($file) : false;
	var_dump('include', $data);
}
