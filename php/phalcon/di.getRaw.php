<?php

use Phalcon\Di;

$di = new Di\FactoryDefault;

class DiSetClass
{}

class DiSetSubClass extends DiSetClass
{}

$class = DiSetClass::class;
$subClass = DiSetSubClass::class;

var_dump($di->has($class));
var_dump($di->get($class));
$di->set($class, $subClass);
var_dump($di->has($class));
var_dump($di->get($class));
var_dump($di->getRaw($class));
