<?php

use Phalcon\Mvc\Model;
use Phalcon\Db\Adapter\Pdo\Mysql as PhalconMysql;

class TestPhalconSnapshot extends Model
{
    public $key;
    public $value;

    public function initialize()
    {
        $this->setSource('test_snapshot');
        $this->keepSnapshots(true);
    }
}

$di = new Phalcon\Di\FactoryDefault;
$di->set('db', function () {
    return new PhalconMysql([
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'phalcon_test',
    ]);
});

/* @var PhalconMysql $db */
$db = $di->getShared('db');

$db->execute('CREATE TABLE IF NOT EXISTS `test_snapshot` (
 `key` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
 `value` TEXT COLLATE utf8_unicode_ci,
 PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

Model::setup([
    'exceptionOnFailedSave' => true,
]);

$model = new TestPhalconSnapshot;
$model->key = microtime();
$model->value = '';
$model->save();
$model->value = time();
$model->save();
