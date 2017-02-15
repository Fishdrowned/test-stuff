<?php
$reflection = new ReflectionFunction(function (stdClass $a, callable $b, int $c, $d, array $e) {});
if (PHP_VERSION_ID >= 70000) {
    foreach ($reflection->getParameters() as $parameter) {
        if ($parameter->hasType()) {
            echo $parameter->getType()->__toString();
        }
        echo ' $', $parameter->getName(), ', ';
    }
    echo PHP_EOL;
}
