<?php
echo 'Parent pid: ' . posix_getpid() . PHP_EOL;
$GLOBALS['a'] = 1;
/* @var swoole_process[] $processes */
$processes = [];
for ($i = 0; $i < 5; ++$i) {
    $processes[$i] = new swoole_process(function (swoole_process $process) {
        ++$GLOBALS['a'];
        echo 'Child pid: ' . $process->pid . ': ' . $GLOBALS['a'] . PHP_EOL;
    });
}
$processes[0]->start();
$processes[1]->start();
++$GLOBALS['a'];
$processes[2]->start();
echo 'Outside: ' . $GLOBALS['a'] . PHP_EOL;
