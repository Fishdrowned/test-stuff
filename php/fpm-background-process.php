<?php
if (PHP_SAPI == 'cli') {
    sleep(10);
    echo 'xx', PHP_EOL;
    return;
}
$file = __FILE__;
$logFile = __DIR__ . '/fpm-background-process.log';
shell_exec("php '{$file}' >> '{$logFile}' &");
