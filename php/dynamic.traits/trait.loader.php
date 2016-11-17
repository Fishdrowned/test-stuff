<?php

use DynamicProperties\EmptyProperties;
use Phalcon\Text;

class TraitLoader
{
    protected static $instance;
    protected $namespace = 'DynamicProperties\\';

    protected function __construct()
    {
        spl_autoload_register([$this, 'autoLoad']);
    }

    public static function register()
    {
        static::$instance === null and static::$instance = new static();
    }

    public function autoLoad($className)
    {
        if (Text::startsWith($className, $this->namespace, false)) {
            $filename = $this->getFilename($className);
            if (is_file($filename)) {
                include $filename;
            } else {
                class_alias(EmptyProperties::class, $className);
            }
            return true;
        }
        return false;
    }

    protected function getFilename($className)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, str_replace('..', '', $className)) . '.php';
    }
}
