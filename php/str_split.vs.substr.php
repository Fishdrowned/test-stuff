<?php
include __DIR__ . '/.include.php';
$longStr = str_repeat('A B', 1e6);
$chunkLength = 1024 * 1024;
$loop = 1e2;
$output = '';

// str_split
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $output = '';
    foreach (str_split($longStr, $chunkLength) as $piece) {
        $output .= $piece;
    }
}
var_dump('str_split() microseconds: ' . Timer::stop() * 1e6 / $loop, $output == $longStr, strlen($output));

// substr
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $output = '';
    $start = 0;
    while (isset($longStr{$start})) {
        $output .= substr($longStr, $start, $chunkLength);
        $start += $chunkLength;
    }
}
var_dump('substr() microseconds: ' . Timer::stop() * 1e6 / $loop, $output == $longStr, strlen($output));

// substr 2
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $output = '';
    for ($start = 0, $length = strlen($longStr); $start < $length; $start += $chunkLength) {
        $output .= substr($longStr, $start, $chunkLength);
    }
}
var_dump('another substr() microseconds: ' . Timer::stop() * 1e6 / $loop, $output == $longStr, strlen($output));
