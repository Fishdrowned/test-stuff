<?php
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SYNC);
if (!$client->connect('127.0.0.1', 9080, 1))
{
	exit("connect failed. Error: {$client->errCode}\n");
}
$request = array(
	'request' => $_REQUEST,
	'cookies' => $_COOKIE,
	'server' => $_SERVER,
	'files' => $_FILES
);
$data = serialize($request);
$client->send(strlen($data) . '|');
$client->send($data);
//echo $client->recv();
$client->close();
