<?php
include __DIR__ . '/.include.php';
include __DIR__ . '/.db.php';
$pdo = Db::init('centos7'/*'127.0.0.1'*/, 'passport_users', 'root', '');
$maxId = (int)$pdo->query('SELECT passport_id FROM avatar_conversion ORDER BY passport_id DESC LIMIT 1')->fetchColumn();
$stmt = $pdo->prepare('INSERT INTO avatar_conversion (passport_id, username) VALUES (:passport_id, :username)');
Timer::start();
for ($i = 1, $count = 1e3; $i <= $count; ++$i) {
	$stmt->execute(array(':passport_id' => $id = $maxId + $i, ':username' => 'user_' . $id));
}
var_dump('Time cost:', $t = Timer::stop());
var_dump('QPS: ', $count / $t);
