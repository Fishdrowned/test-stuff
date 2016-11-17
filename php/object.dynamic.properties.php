<?php
include __DIR__ . '/.include.php';

/**
 * Class DynamicProperties
 *
 * @property $foo
 * @property $hello
 * @property $key
 * @property $what
 * @property $any
 */
class DynamicProperties
{
}

class DynamicPropertiesWithSet extends DynamicProperties
{
    protected $_dump = false;

    public function __construct($dump = false)
    {
        $this->_dump = $dump;
    }

    public function __set($name, $value)
    {
        $this->_dump and var_dump(func_get_args());
        $this->{$name} = $value;
        return $value;
    }

    public function setFoo($value)
    {
        $this->{'foo'} = $value;
        return $this;
    }
}

class DynamicPropertiesWithSetButInitialized extends DynamicPropertiesWithSet
{
    protected $properties = ['foo', 'hello', 'key', 'what', 'any'];

    public function __construct($dump = null)
    {
        parent::__construct($dump);
        foreach ($this->properties as $property) {
            $this->{$property} = null;
        }
    }
}

trait GeneratedPropertiesTrait
{
    public $foo;
    public $hello;
    public $key;
    public $what;
    public $any;
}

class DynamicPropertiesWithSetButInitializedAndTrait extends DynamicPropertiesWithSet
{
    use GeneratedPropertiesTrait;

    protected $properties = ['foo', 'hello', 'key', 'what', 'any'];
}

class FixedProperties extends DynamicProperties
{
    public $foo;
    public $hello;
    public $key;
    public $what;
    public $any;
}

$dynamic = new DynamicProperties();
$dynamicWithSet = new DynamicPropertiesWithSet(true);
$dynamicWithSetButInitialized = new DynamicPropertiesWithSetButInitialized(true);
$dynamicWithSetButInitializedAndTrait = new DynamicPropertiesWithSetButInitializedAndTrait(true);
$fixed = new FixedProperties();

$dynamic->foo = 'bar';
var_dump('$dynamic->foo', $dynamic->foo);

$dynamicWithSet->foo = 'bar';
var_dump('$dynamicWithSet->foo', $dynamicWithSet->foo);
$dynamicWithSet->setFoo('xx');
var_dump('$dynamicWithSet->setFoo()', $dynamicWithSet->foo);

$dynamicWithSetButInitialized->foo = 'bar';
var_dump('$dynamicWithSetButInitialized->foo', $dynamicWithSetButInitialized->foo);
$dynamicWithSetButInitialized->setFoo('xx');
var_dump('$dynamicWithSetButInitialized->setFoo()', $dynamicWithSetButInitialized->foo);

$dynamicWithSetButInitializedAndTrait->foo = 'bar';
var_dump('$dynamicWithSetButInitializedAndTrait->foo', $dynamicWithSetButInitializedAndTrait->foo);
$dynamicWithSetButInitializedAndTrait->setFoo('xx');
var_dump('$dynamicWithSetButInitializedAndTrait->setFoo()', $dynamicWithSetButInitializedAndTrait->foo);

$fixed->foo = 'bar';
var_dump('$fixed->foo', $fixed->foo);

$loop = 1e4;
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $obj = new DynamicProperties();
    $obj->foo = 'bar';
    $obj->hello = 'world';
    $obj->key = 'value';
    $obj->what = 'ever';
    $obj->any = 'more';
}
$t = Timer::stop() * 1e6 / $loop;
var_dump('DynamicProperties', "{$t} microseconds", $obj);

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $obj = new DynamicPropertiesWithSet();
    $obj->foo = 'bar';
    $obj->hello = 'world';
    $obj->key = 'value';
    $obj->what = 'ever';
    $obj->any = 'more';
}
$t = Timer::stop() * 1e6 / $loop;
var_dump('DynamicPropertiesWithSet', "{$t} microseconds", $obj);

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $obj = new DynamicPropertiesWithSetButInitialized();
    $obj->foo = 'bar';
    $obj->hello = 'world';
    $obj->key = 'value';
    $obj->what = 'ever';
    $obj->any = 'more';
}
$t = Timer::stop() * 1e6 / $loop;
var_dump('DynamicPropertiesWithSetButInitialized', "{$t} microseconds", $obj);

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $obj = new DynamicPropertiesWithSetButInitializedAndTrait();
    $obj->foo = 'bar';
    $obj->hello = 'world';
    $obj->key = 'value';
    $obj->what = 'ever';
    $obj->any = 'more';
}
$t = Timer::stop() * 1e6 / $loop;
var_dump('DynamicPropertiesWithSetButInitializedAndTrait', "{$t} microseconds", $obj);

Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $obj = new FixedProperties();
    $obj->foo = 'bar';
    $obj->hello = 'world';
    $obj->key = 'value';
    $obj->what = 'ever';
    $obj->any = 'more';
}
$t = Timer::stop() * 1e6 / $loop;
var_dump('FixedProperties', "{$t} microseconds", $obj);
