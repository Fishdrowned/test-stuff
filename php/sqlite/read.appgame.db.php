<?php
include dirname(__DIR__) . '/.include.php';
include dirname(__DIR__) . '/.db.php';

$pdo = Db::initSqlite('/home/christopher/AppGameSDKDB.db');

foreach ($pdo->query('SELECT name FROM sqlite_master;')->fetchAll(PDO::FETCH_ASSOC) as $tableRow) {
    $table = reset($tableRow);
    var_dump($table, $pdo->query("SELECT * FROM {$table}")->fetchAll(PDO::FETCH_ASSOC));
}
