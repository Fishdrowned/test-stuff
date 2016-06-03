<?php

include __DIR__ . '/.include.php';

class Holder
{
    /**
     * @var Insertion
     */
    protected $obj;

    /**
     * @return Insertion
     */
    public function getObj()
    {
        return $this->obj;
    }

    /**
     * @param Insertion $obj
     * @return $this
     */
    public function setObj($obj)
    {
        $this->obj = $obj;
        return $this;
    }

    /**
     * @param Insertion $obj
     * @return $this
     */
    public function processObj($obj)
    {
        $this->setObj($obj);
        $obj->show();
        return $this;
    }
}

class Insertion
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __destruct()
    {
        var_dump('Unset ' . $this->getName());
        showTrace(false);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function show()
    {
        var_dump('I am ' . $this->getName());
    }
}

class AnotherHolder
{
    /**
     * @var Holder
     */
    protected static $_holder;
    /**
     * @var Insertion
     */
    protected static $_obj;
    /**
     * @var Holder
     */
    protected $holder;
    /**
     * @var Insertion
     */
    protected $obj;

    public function __construct($holder)
    {
        $this->holder = $holder;
    }

    /**
     * @param Insertion $obj
     * @return $this
     */
    public function process($obj)
    {
        $this->holder->setObj($obj);
        $this->obj = $this->holder->getObj();
        $this->obj->show();
        return $this;
    }

    /**
     * @param Insertion $obj
     */
    public static function staticProcess($obj)
    {
        $obj->show();
    }
}

$holder = new Holder();
$holder->setObj(new Insertion('A'));
$insertionA = $holder->getObj();
$insertionA->show();
$holder->setObj(new Insertion('B'));
$insertionB = $holder->getObj();
$insertionB->show();
$holder->processObj(new Insertion('C'));
$holder->processObj(new Insertion('D'));
$holder->processObj(new Insertion('E'));

$anotherHolder = new AnotherHolder($holder);
$anotherHolder->process(new Insertion('F'));
$anotherHolder->process(new Insertion('G'));

AnotherHolder::staticProcess(new Insertion('H'));
AnotherHolder::staticProcess(new Insertion('I'));

$closure = function(Insertion $obj) {
    $obj->show();
};
$closure(new Insertion('J'));
$closure(new Insertion('K'));

echo 'script end';
