<?php
include __DIR__ . '/.include.php';
include __DIR__ . '/.db.php';

$pdo = Db::init('127.0.0.1', 'phwoolcon_test', 'root', '');

$reflection = new ReflectionClass($pdo);

var_dump($reflection->getProperties());
