<?php
include dirname(__DIR__) . '/.include.php';
include __DIR__ . '/trait.loader.php';

TraitLoader::register();

class DynamicFoo
{
    use \DynamicProperties\Generated\FooProperties;
}

class DynamicHello
{
    use \DynamicProperties\Generated\HelloProperties;
}

var_dump(new DynamicFoo());
var_dump(new DynamicHello());
