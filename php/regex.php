<?php
include __DIR__ . '/.include.php';
$regex = '/^[\pL\pN_\-\.]+$/u';
var_dump($regex,
    $val = '是', preg_match($regex, $val),
    $val = '😂', preg_match($regex, $val)
);
