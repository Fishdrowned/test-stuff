<?php
$shmKey = ftok(__FILE__, 't');
$shmId = shmop_open($shmKey, 'n', 0644, 1024);
$shmSize = shmop_size($shmId);
var_dump($shmKey, $shmId, $shmSize);
