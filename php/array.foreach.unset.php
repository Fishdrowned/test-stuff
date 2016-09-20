<?php
// Array
$array = [1, 2, 3, 4];
var_dump($array);

// Unset 2 elements
$i = 0;
foreach ($array as $k => $v) {
    unset($array[$k]);
    if (++$i >= 2) {
        break;
    }
}
var_dump($array);

$array = [1, 2, 3, 4];

// Unset even elements
$i = 0;
foreach ($array as $k => $v) {
    if (++$i % 2) {
        unset($array[$k]);
    }
}
var_dump($array);

$array = [1, 2, 3, 4];

// Unset odd elements
$i = 0;
foreach ($array as $k => $v) {
    if (!(++$i % 2)) {
        unset($array[$k]);
    }
}
var_dump($array);

// ================================================================

// K-V Map
$array = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
var_dump($array);

// Unset 2 elements
$i = 0;
foreach ($array as $k => $v) {
    unset($array[$k]);
    if (++$i >= 2) {
        break;
    }
}
var_dump($array);

$array = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

// Unset even elements
$i = 0;
foreach ($array as $k => $v) {
    if (++$i % 2) {
        unset($array[$k]);
    }
}
var_dump($array);

$array = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

// Unset odd elements
$i = 0;
foreach ($array as $k => $v) {
    if (!(++$i % 2)) {
        unset($array[$k]);
    }
}
var_dump($array);
