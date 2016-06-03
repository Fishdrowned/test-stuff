<?php
$request = array(
	'request' => $_REQUEST,
	'cookies' => $_COOKIE,
	'server' => $_SERVER,
	'files' => $_FILES,
//	'misc' => str_pad('', 1e4, 'a '),
);
$data = serialize($request);
$sockFile = __DIR__ . '/service.sock';
$client = new swoole_client(SWOOLE_UNIX_STREAM, SWOOLE_SYNC);
$client->set(array(
	'open_length_check' => true,
	'package_max_length' => 262144,
	'package_length_type' => 'N', //see php pack()
	'package_length_offset' => 0,
	'package_body_offset' => 4,
));
if (!$client->connect($sockFile, 0)) {
	exit("connect failed. Error: {$client->errCode}\n");
}
$data = pack('N', strlen($data)) . $data;
$client->send($data);
$response = $client->recv();
$length = unpack('N', $response)[1];
$response = unserialize(substr($response, -$length));
var_dump($response['header']);
echo $response['body'];
$client->close();
