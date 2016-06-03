<?php

include __DIR__ . '/.include.php';

ini_set('memory_limit', '256M');

$round = 1e6;
$context = [
    'test' => range(1, 1e6),
];

// Ternary
Timer::start();
for ($i = 0; $i < $round; ++$i) {
    $tmp = isset($context['test']) ? $context['test'] : '';
}
var_dump('Ternary:', Timer::stop());

// If
Timer::start();
for ($i = 0; $i < $round; ++$i) {
    if (isset($context['test'])) {
        $tmp = $context['test'];
    } else {
        $tmp = '';
    }
}
var_dump('If:', Timer::stop());
