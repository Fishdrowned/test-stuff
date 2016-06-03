<?php
$ip = '127.0.0.1';
$port = '15376';

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!socket_connect($socket, $ip, $port)) {
	echo 'socket_create_listen error ', $err = socket_last_error(), ': ', socket_strerror($err);
	exit;
}
if (!socket_write($socket, $instruction = "xx\n", strlen($instruction))) {
	echo "socket_write() failed: reason: " . socket_strerror($socket) . "\n";
}
$out = socket_read($socket, 100, PHP_NORMAL_READ);
var_dump($out);
socket_close($socket);
