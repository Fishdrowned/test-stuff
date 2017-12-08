<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Registry;

include dirname(__DIR__) . '/.include.php';

$di = new FactoryDefault();

$_SERVER['x'] = 0;
$loop = 5e5;
var_dump(sprintf('Loop count: %s', $loop));

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $_SERVER['x'] = $i;
}
$cost = Timer::stop();
var_dump(sprintf('Accessing $_SERVER, result:%s, time cost: %s seconds, %s microseconds per loop',
    $_SERVER['x'],
    $cost,
    $cost * 1e6 / $loop
));

$staticProperty = new class
{
    public static $x;
};
$staticProperty::$x = 0;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $staticProperty::$x = $i;
}
$cost = Timer::stop();
var_dump(sprintf('Accessing Class::$x, result:%s, time cost: %s seconds, %s microseconds per loop',
    $staticProperty::$x,
    $cost,
    $cost * 1e6 / $loop
));

$di->server = ['x' => 0];
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $di->server['x'] = $i;
}
$cost = Timer::stop();
var_dump(sprintf('Accessing $di->server["x"], result:%s, time cost: %s seconds, %s microseconds per loop',
    $di->server['x'],
    $cost,
    $cost * 1e6 / $loop
));

$registry = new Registry();
$registry['x'] = 0;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $registry['x'] = $i;
}
$cost = Timer::stop();
var_dump(sprintf('Accessing Phalcon\Registry, result:%s, time cost: %s seconds, %s microseconds per loop',
    $registry['x'],
    $cost,
    $cost * 1e6 / $loop
));

$offsetSet = new class implements ArrayAccess
{
    protected $data;

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
};
$offsetSet['x'] = 0;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $offsetSet['x'] = $i;
}
$cost = Timer::stop();
var_dump(sprintf('Accessing ArrayAccess::offsetSet(), result:%s, time cost: %s seconds, %s microseconds per loop',
    $offsetSet['x'],
    $cost,
    $cost * 1e6 / $loop
));
