<?php
error_reporting(-1);
set_error_handler(function ($errNo, $errStr, $errFile, $errLine) {
    throw new RuntimeException("{$errStr} on line {$errLine} of file '{$errFile}'", $errNo);
});

$doSomething = function ($param) {
    try {
        return implode(' ', $param);
    } catch (Exception $e) {
        echo $e->getMessage();
        return '';
    } finally {
        var_dump('finally');
    }
};

$param = ['good', 'param'];
var_dump($doSomething($param));
$param = 'bad param';
var_dump($doSomething($param));
