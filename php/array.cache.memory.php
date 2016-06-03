<?php
$data = md5('abcde123456');
$cache = array();
$startMem = memory_get_usage();
for ($i = 0, $count = 1e6; $i < $count; ++$i) {
    $cache[$i] = $data;
}
$endMem = memory_get_usage();
var_dump(round(($endMem - $startMem) / 1024 / 1024, 2) . 'M');
