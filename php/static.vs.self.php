<?php
class StaticA
{
    protected static $x = [];

    /**
     * @return mixed
     */
    public static function getSelfX()
    {
        return self::$x;
    }

    /**
     * @param mixed $x
     */
    public static function setSelfX($x)
    {
        self::$x[] = $x;
    }

    /**
     * @return mixed
     */
    public static function getStaticX()
    {
        return static::$x;
    }

    /**
     * @param mixed $x
     */
    public static function setStaticX($x)
    {
        static::$x[] = $x;
    }

    public function getObjectClass($const = true)
    {
        return $const ? __CLASS__ : get_class($this);
    }

    public static function getStaticClass($const = true)
    {
        return $const ? __CLASS__ : get_called_class();
    }
}

class StaticB extends StaticA
{

    /**
     * @return mixed
     */
    public static function getSelfX()
    {
        return self::$x;
    }

    /**
     * @param mixed $x
     */
    public static function setSelfX($x)
    {
        self::$x[] = $x;
    }

    /**
     * @return mixed
     */
    public static function getStaticX()
    {
        return static::$x;
    }

    /**
     * @param mixed $x
     */
    public static function setStaticX($x)
    {
        static::$x[] = $x;
    }
}
$a = new StaticA;
$b = new StaticB;

var_dump('__CLASS__: ', StaticA::getStaticClass(), StaticB::getStaticClass());
var_dump('get_called_class: ', StaticA::getStaticClass(false), StaticB::getStaticClass(false));

var_dump('object __CLASS__: ', $a->getObjectClass(), $b->getObjectClass());
var_dump('object get_class: ', $a->getObjectClass(false), $b->getObjectClass(false));

StaticA::setSelfX(123);
var_dump('StaticA::setSelfX():', StaticA::getSelfX(), StaticA::getStaticX(), StaticB::getSelfX(), StaticB::getStaticX());

StaticB::setSelfX(456);
var_dump('StaticB::setSelfX():', StaticA::getSelfX(), StaticA::getStaticX(), StaticB::getSelfX(), StaticB::getStaticX());

StaticA::setStaticX(789);
var_dump('StaticA::setStaticX():', StaticA::getSelfX(), StaticA::getStaticX(), StaticB::getSelfX(), StaticB::getStaticX());

StaticB::setStaticX(890);
var_dump('StaticB::setStaticX():', StaticA::getSelfX(), StaticA::getStaticX(), StaticB::getSelfX(), StaticB::getStaticX());
