<?php
include __DIR__ . '/.include.php';
include __DIR__ . '/.db.php';
$pdo = Db::init('127.0.0.1', 'test_queue', 'root', '');
$stmt = $pdo->prepare('replace `test_uid` (uid,key) values(null,"uid")');
Timer::start();
for ($i = 0, $count = 1e4; $i < $count; ++$i) {
	$stmt->execute();
}
var_dump('Time cost:', $t = Timer::stop());
var_dump('QPS: ', $count / $t);
