<?php
include __DIR__ . '/.include.php';
include __DIR__ . '/.db.php';
$pdo = Db::init('centos7'/*'127.0.0.1'*/, 'passport_users', 'root', '');
$stmt = $pdo->prepare('SELECT * FROM avatar_conversion WHERE uid = :uid');
Timer::start();
for ($i = 0, $count = 1e4; $i < $count; ++$i) {
	$uid = mt_rand(1, 1e6);
	$stmt->execute(array(':uid' => $uid));
	$result = $stmt->fetchAll();
	$count < 10 and var_dump($result);
}
var_dump('Time cost:', $t = Timer::stop());
var_dump('QPS: ', $count / $t);
