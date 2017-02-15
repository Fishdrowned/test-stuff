<?php
include __DIR__ . '/.include.php';

$loop = 1e8;
printf("Start %d loops...\n", $loop);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
}
printf("Finished, time cost is: %f\n", Timer::stop());
<<<EOT
Start 100000000 loops...
Finished, time cost is: 8.928253
~0.09 microseconds per loop
EOT;
