<?php
include dirname(__DIR__) . '/.include.php';
include __DIR__ . '/functions.php';

$loop = 2e5;

echo 'Loops: ', $loop, PHP_EOL;

echo 'Empty loop: ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
}
echo Timer::stop(), PHP_EOL;

echo '$tmp = $i: ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = $i;
}
echo Timer::stop(), PHP_EOL;

echo 'if ($i % 2): ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    if ($i % 2) {}
}
echo Timer::stop(), PHP_EOL;

echo 'if ($i % 2) $tmp = $i: ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    if ($i % 2) {
        $tmp = $i;
    }
}
echo Timer::stop(), PHP_EOL;

echo '$tmp = $i; if ($i % 2) $tmp = $i: ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = $i;
    if ($i % 2) {
        $tmp = $i;
    }
}
echo Timer::stop(), PHP_EOL;

echo 'benchSimpleCall(): ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    benchSimpleCall();
}
echo Timer::stop(), PHP_EOL;

echo 'benchSimpleCallWithArgs($v): ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    benchSimpleCallWithArgs($i);
}
echo Timer::stop(), PHP_EOL;

echo '$tmp = benchSimpleCallWithArgsAndReturn($i): ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = benchSimpleCallWithArgsAndReturn($i);
}
echo Timer::stop(), PHP_EOL;

echo '$tmp = benchSimpleCallWithStaticTypeHintArgs($i): ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = benchSimpleCallWithStaticTypeHintArgs($i);
}
echo Timer::stop(), PHP_EOL;

echo '$tmp = \'var\' . $i: ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = 'var' . $i;
}
echo Timer::stop(), PHP_EOL;

echo '$tmp = "var $i": ';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $tmp = "var $i";
}
echo Timer::stop(), PHP_EOL;

echo 'Memory peak: ', memory_get_peak_usage() / 1024, 'k', PHP_EOL;
