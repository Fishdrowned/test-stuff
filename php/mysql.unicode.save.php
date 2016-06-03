<?php

include __DIR__ . '/.include.php';
include __DIR__ . '/.db.php';

$json = '{"openid":"oGLw7uDkSPXy8RF3uKgEE8Pj0NWo","nickname":"\ud83d\udd3a\u798e\ud83d\udd3b","sex":2,"language":"zh_CN","city":"\u5e7f\u5dde","province":"\u5e7f\u4e1c","country":"\u4e2d\u56fd","headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/kMCcpcjO3WqmE4oICHViaaNP3J2VB9Vc9HNUfcrl980A7RhmK2Vl7cicwziaUCBYRXdUuU93LA4oBXAf4RrRGB8oflPiaXLLB3wia\/0","privilege":[],"unionid":"ojDbAt8WUJH2h-LQJegGi6gA9xZk"}';
$data = json_decode($json, true);

var_dump($nickname = fnGet($data, 'nickname'), $data);
$db = Db::init('localhost', 'appgame_passport', 'root', '');
$db->query('SET NAMES utf8mb4;');
$db->query('SET CHARACTER SET utf8mb4;');
var_dump($db->query('SHOW VARIABLES LIKE "%char%"')->fetch(PDO::FETCH_ASSOC));
$stmt = $db->prepare('UPDATE `profiles` SET `firstName` = :nickname WHERE `id` = 6;');
$result = $stmt->execute(array(':nickname' => $nickname));
var_dump($result);
var_dump($db->query('SELECT * FROM `profiles` WHERE `id` = 6;')->fetch(PDO::FETCH_ASSOC));
