<?php
include dirname(__DIR__) . '/.include.php';
$shmKey = ftok(__DIR__ . '/create.php', 't');
if ($shmId = @shmop_open($shmKey, 'w', 0, 0)) {
	$shmSize = shmop_size($shmId);
	var_dump($shmKey, $shmId, $shmSize);

	Timer::start();
	for ($i = 0; $i < 1e5; ++$i) {
//		$data = substr('        ' . base_convert('FFFFFFFF', 16, 36), - 8);
		$data = 'FFFFFFFF';
		$bytes = shmop_write($shmId, $data, 0);
	}
	var_dump("Written {$bytes} bytes of data: '{$data}'.", base_convert($data, 16, 10), Timer::stop());
} else {
	var_dump('Failed to open shared memory.');
}
