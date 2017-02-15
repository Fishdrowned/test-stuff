<?php
namespace {

    define('SOME_CONSTANT', 1);
}

namespace Some\Name\Space {

    use ReflectionFunction;

    $reflection = new ReflectionFunction(function ($const = PHP_EOL, $const2 = SOME_CONSTANT) {
    });
    // Should display PHP_EOL, actual Some\Name\Space\PHP_EOL
    echo $reflection->getParameters()[0]->getDefaultValueConstantName() . PHP_EOL;
    // Should display SOME_CONSTANT, actual Some\Name\Space\SOME_CONSTANT
    echo $reflection->getParameters()[1]->getDefaultValueConstantName() . PHP_EOL;
}
