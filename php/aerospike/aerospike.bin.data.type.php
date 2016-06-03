<?php
error_reporting(-1);
$port = 3000;
$config = array("hosts" => array(array("addr" => 'centos7', "port" => $port),));
$connOptions = array(
	Aerospike::OPT_CONNECT_TIMEOUT => 2000,
	Aerospike::OPT_READ_TIMEOUT => 2000,
	Aerospike::OPT_WRITE_TIMEOUT => 2000,
	Aerospike::OPT_POLICY_KEY => Aerospike::POLICY_KEY_SEND,
);

$db = new Aerospike($config, false, $connOptions);
if (!$db->isConnected()) {
	exit;
}

$bigNum = pow(2, 32) + 1;
$key = $db->initKey('test', 'passport', $id = 2);
$data = array('data' => array('id' => $id, 'name' => 'x', 'shit_fuck_long_key_name' => 'well'), 'id' => $id, 'name' => 'x', 'increment' => $bigNum);
$readOptions = array(
	Aerospike::OPT_POLICY_REPLICA => Aerospike::POLICY_REPLICA_ANY,
	Aerospike::OPT_POLICY_CONSISTENCY => Aerospike::POLICY_CONSISTENCY_ONE,
);
//$status = $db->put($key, $data);
//if ($status != Aerospike::OK) {
//	throw new Exception($db->error(), $db->errorno());
//}
//var_dump($status);
//$status = $db->removeBin($key, array('shit_fuck_long', 'shit_fuck_'));
//if ($status != Aerospike::OK) {
//	var_dump($db->error());
//}
$db->increment($key, 'increment', 1);

$status = $db->get($key, $result, null, $readOptions);
var_dump($key, $status, $result);
