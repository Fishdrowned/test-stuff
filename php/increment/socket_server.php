<?php
if (!$socket = stream_socket_server("tcp://0.0.0.0:15376", $errNo, $errStr)) {
	echo "$errStr ($errNo)\n";
} else {
	$i = 0;
	while (true) {
		while ($conn = @stream_socket_accept($socket)) {
			++$i;
			fwrite($conn, $i . "\r\n");
			fclose($conn);
		}
	}
}
/*$ip = '0.0.0.0';
$port = '15376';
$backLog = 8192;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if (!socket_bind($socket, $ip, $port)) {
	echo 'socket_bind error ', $err = socket_last_error(), ': ', socket_strerror($err);
	exit;
}
if (!socket_listen($socket, $backLog)) {
	echo 'socket_listen error ', $err = socket_last_error(), ': ', socket_strerror($err);
	exit;
}
if (!$msgSock = @socket_accept($socket)) {
	echo 'socket_accept error ', $err = socket_last_error(), ': ', socket_strerror($err);
	exit;
}

$i = 0;
do {
	++$i;
	if (!$msgSock = @socket_accept($socket)) {
		echo 'socket_accept error ', $err = socket_last_error(), ': ', socket_strerror($err);
		break;
	}
	$instruction = socket_read($msgSock, 100, PHP_NORMAL_READ);
	socket_write($msgSock, $i . "\r\n");
	socket_close($msgSock);

} while (true);

socket_close($socket);*/
