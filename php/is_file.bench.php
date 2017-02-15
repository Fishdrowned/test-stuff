<?php
include __DIR__ . '/.include.php';

$loop = 1000;
$files = glob(__DIR__ . '/*.php');
$nonExistingFiles = [];
foreach ($files as $file) {
    $nonExistingFiles[] = $file . '.fake';
}

$result = [];
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    foreach($files as $file) {
        $result[$file] = is_file($file);
    }
}
$cost = Timer::stop();
var_dump($result);
var_dump(sprintf('Loop: %s, $files count: %s, total time: %s seconds', $loop, count($files), $cost));
var_dump(sprintf('is_file cost on existing files: %s microseconds', $cost / $loop / count($files) * 1e6));

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    foreach($files as $file) {
        $result[$file] = !empty($result[$file]);
    }
}
$cost = Timer::stop();
var_dump(sprintf('Loop: %s, $files count: %s, total time: %s seconds', $loop, count($files), $cost));
var_dump(sprintf('!empty cost on existing files: %s microseconds', $cost / $loop / count($files) * 1e6));

$result = [];
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    foreach($nonExistingFiles as $file) {
        $result[$file] = is_file($file);
    }
}
$cost = Timer::stop();
var_dump($result);
var_dump(sprintf('Loop: %s, $nonExistingFiles count: %s, total time: %s seconds', $loop, count($nonExistingFiles), $cost));
var_dump(sprintf('is_file cost on non-existing files: %s microseconds', $cost / $loop / count($nonExistingFiles) * 1e6));

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    foreach($nonExistingFiles as $file) {
        $result[$file] = !empty($result[$file]);
    }
}
$cost = Timer::stop();
var_dump(sprintf('Loop: %s, $nonExistingFiles count: %s, total time: %s seconds', $loop, count($nonExistingFiles), $cost));
var_dump(sprintf('!empty cost on non-existing files: %s microseconds', $cost / $loop / count($nonExistingFiles) * 1e6));
