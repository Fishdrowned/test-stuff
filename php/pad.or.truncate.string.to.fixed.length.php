<?php
include __DIR__ . '/.include.php';

$loop = 1e5;
$fixedLength = 4;
$padding = '0';
$inputA = '123';
$inputB = '123456';

$padIt = function ($input, $padding, $length) {
    return isset($input{$length}) ? substr($input, -$length) : str_pad($input, $length, $padding, STR_PAD_LEFT);
};

$substrIt = function ($input, $padding, $length) {
    return substr($padding . $input, -$length);
};

$sprintfIt = function ($input, $padding, $length) {
    return sprintf("%'{$padding}{$length}s", $input);
};

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $a = $padIt($inputA, $padding, $fixedLength);
    $b = $padIt($inputB, $padding, $fixedLength);
}
$time = Timer::stop();
var_dump("str_pad \$a = '$a', \$b = '$b'", ($time / $loop * 1e6) . ' us/loop');

Timer::start();
$leftPad = str_repeat($padding, $fixedLength);
for ($i = 0; $i < $loop; ++$i) {
    $a = $substrIt($inputA, $leftPad, $fixedLength);
    $b = $substrIt($inputB, $leftPad, $fixedLength);
}
$time = Timer::stop();
var_dump("substr \$a = '$a', \$b = '$b'", ($time / $loop * 1e6) . ' us/loop');

Timer::start();
$leftPad = str_repeat($padding, $fixedLength);
for ($i = 0; $i < $loop; ++$i) {
    $a = $sprintfIt($inputA, $padding, $fixedLength);
    $b = $sprintfIt($inputB, $padding, $fixedLength);
}
$time = Timer::stop();
var_dump("sprintf \$a = '$a', \$b = '$b'", ($time / $loop * 1e6) . ' us/loop');
