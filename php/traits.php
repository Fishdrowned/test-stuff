<?php
include __DIR__ . '/.include.php';

trait AccessInvisible
{

    public function getPrivate()
    {
        return $this->private;
    }

    public function setPrivate($value)
    {
        $this->private = $value;
        return $this;
    }

    public function getProtected()
    {
        return $this->protected;
    }

    public function setProtected($value)
    {
        $this->protected = $value;
        return $this;
    }
}

class SomeClass
{
    use AccessInvisible;
    private $private;
    protected $protected;
}

class AnotherClass extends SomeClass
{
    use AccessInvisible;

    public function getPrivate()
    {
        return parent::getPrivate();
    }

    public function setPrivate($value)
    {
        return parent::setPrivate($value);
    }
}

$obj = new SomeClass();
$obj->setPrivate(1)->setProtected(2);
var_dump($obj, $obj->getPrivate(), $obj->getProtected());

$obj2 = new AnotherClass();
$obj2->setPrivate(3)->setProtected(4);
var_dump($obj2, $obj2->getPrivate(), $obj2->getProtected());
