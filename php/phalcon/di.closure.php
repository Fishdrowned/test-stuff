<?php
use Phalcon\Di;

$di = new Di\FactoryDefault;
var_dump('Phalcon ' . \Phalcon\Version::get());

function initDir(Di $di)
{
    $di->setShared('DIR', function () {
        return __DIR__;
    });
}

;

initDir($di);

function getDir($path = null)
{
    return Di::getDefault()['DIR'] . ($path ? '/' . $path : '');
}

class SomeComponent
{

    public static function register()
    {
        return getDir('xx');
    }
}

var_dump(SomeComponent::register());
