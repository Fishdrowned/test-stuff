<?php
header('Content-type: text/plain');
include dirname(dirname(__DIR__)) . '/.include.php';
$sockFile = __DIR__ . '/command.sock';
if (!$socket = @stream_socket_client('unix://' . $sockFile, $errNo, $errStr, 5)) {
	if ($errNo == 61) {
		echo "Service not started.\n";
	}
	else {
		echo "$errStr ($errNo)\n";
	}
} else {
	$data = (string)getRequest('command', 'status');
	fwrite($socket, $data, strlen($data));
	if ($response = fread($socket, 8192)) {
		echo $response;
	}
	fclose($socket);
}
