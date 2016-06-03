<?php

include __DIR__ . '/.include.php';

$array = [
    'child' => [
        'child' => [
            'child' => [
                'child' => [
                    'child' => [
                        'child' => 'no child',
                    ],
                ],
            ],
        ],
    ],
];
$obj = json_decode(json_encode($array));
$loop = 1e4;

var_dump('fnGet($array, \'child\')', fnGet($array, 'child', null, '.'));
var_dump('fnGet($array, \'child.child.child.child\')', fnGet($array, 'child.child.child.child', null, '.'));
var_dump('fnGet($array, \'child.child.child.child.child\')', fnGet($array, 'child.child.child.child.child', null, '.'));
var_dump('fnGet($array, \'non.exists\')', fnGet($array, 'non.exists', null, '.'));
var_dump('fnGet($obj, \'non.exists\')', fnGet($obj, 'non.exists', null, '.'));
var_dump('fnGet Loop ' . $loop);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $a = fnGet($array, 'child.child.child.child.child', null, '.');
}
var_dump($t = Timer::stop(), 'fnGet($array) Microseconds: ' . $t * 1e6 / $loop, $a);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $a = fnGet($obj, 'child.child.child.child.child', null, '.');
}
var_dump($t = Timer::stop(), 'fnGet($obj) Microseconds: ' . $t * 1e6 / $loop, $a);

var_dump('newFnGet($array, \'child\')', newFnGet($array, 'child', null, '.'));
var_dump('newFnGet($array, \'child.child.child.child\')', newFnGet($array, 'child.child.child.child', null, '.'));
var_dump('newFnGet($array, \'child.child.child.child.child\')', newFnGet($array, 'child.child.child.child.child', null, '.'));
var_dump('newFnGet($array, \'non.exists\')', newFnGet($array, 'non.exists', null, '.'));
var_dump('newFnGet($obj, \'non.exists\')', newFnGet($obj, 'non.exists', null, '.', true));
var_dump('newFnGet Loop ' . $loop);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $a = newFnGet($array, 'child.child.child.child.child', null, '.');
}
var_dump($t = Timer::stop(), 'newFnGet($array) Microseconds: ' . $t * 1e6 / $loop, $a);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $a = newFnGet($obj, 'child.child.child.child.child', null, '.', true);
}
var_dump($t = Timer::stop(), 'newFnGet($obj) Microseconds: ' . $t * 1e6 / $loop, $a);

var_dump('array_get($array, \'child\')', array_get($array, 'child', null, '.'));
var_dump('array_get($array, \'child.child.child.child\')', array_get($array, 'child.child.child.child', null, '.'));
var_dump('array_get($array, \'child.child.child.child.child\')', array_get($array, 'child.child.child.child.child', null, '.'));
var_dump('array_get($array, \'non.exists\')', array_get($array, 'non.exists', null, '.'));
var_dump('array_get Loop ' . $loop);
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $a = array_get($array, 'child.child.child.child.child', null, '.');
}
var_dump($t = Timer::stop(), 'array_get($array) Microseconds: ' . $t * 1e6 / $loop, $a);
