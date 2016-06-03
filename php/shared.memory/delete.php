<?php
include dirname(__DIR__) . '/.include.php';
$shmKey = ftok(__DIR__ . '/create.php', 't');
if ($shmId = @shmop_open($shmKey, 'a', 0, 0)) {
	shmop_delete($shmId);
	var_dump("Deleted share memory block.");
} else {
	var_dump('Failed to open shared memory.');
}
