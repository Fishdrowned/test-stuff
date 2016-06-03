<?php
error_reporting(-1);
$port = 3000;
$config = array("hosts" => array(array("addr" => '10.254.169.78', "port" => $port),array("addr" => '10.254.168.78', "port" => $port)));
$connOptions = array(
    Aerospike::OPT_CONNECT_TIMEOUT => 2000,
    Aerospike::OPT_READ_TIMEOUT => 2000,
    Aerospike::OPT_WRITE_TIMEOUT => 2000,
    Aerospike::OPT_POLICY_KEY => Aerospike::POLICY_KEY_SEND,
);

$begin = microtime(true);
$db = new Aerospike($config, false, $connOptions);
if (!$db->isConnected()) {
    file_put_contents($log, "$pid|0|0|0|0|0|0|0|0|0\n", FILE_APPEND);
    exit(1);
}
$writes = 0;
$write_fails = 0;
$reads = 0;
$read_fails = 0;

$pid = getmypid();
$key = $db->initKey("test", "performance", $pid);
$kv = array('v' => 0, 'username' => 'username', 'email' => 'email@noreply.com', 'salt' => '774404', 'password' => '$2y$10$KyldTxX8/B1t4ZFy2gCIx.VWnqCN0b6zCiV0sjK733neH.Cl7mQrW', 'confirmed' => 1, 'remember_token' => 'NuzKkgQZGppODBuBVvxazmVbCWZT8OTiONq3ZXO6aQaVeqLkvbFtliwIhlDk');
$readOptions = array(
    Aerospike::OPT_POLICY_REPLICA => Aerospike::POLICY_REPLICA_ANY,
    Aerospike::OPT_POLICY_CONSISTENCY => Aerospike::POLICY_CONSISTENCY_ONE,
);
$write_every = 10;
for ($num_ops = 0, $total_ops = 50; $num_ops < $total_ops; $num_ops++) {
    $key['key'] = 'write-'.mt_rand(1,2e6);
    if (0&&($num_ops % $write_every) == 0) {
        $kv['v'] = $num_ops;
        $res = $db->put($key, $kv);
        $writes++;
        if ($res !== Aerospike::OK) {
            $write_fails++;
        }
    } else {
        $res = $db->get($key, $r, array(), $readOptions);
        $reads++;
        if ($res !== Aerospike::OK) {
            $read_fails++;
        }
    }
}
$end = microtime(true);
$delta = $end - $begin;
$tps = ($num_ops / $delta);
//file_put_contents($log, "$pid|$num_ops|$delta|$tps|$reads|$read_fails|$writes|$write_fails\n", FILE_APPEND);
$log = '/data/vdc/bench/nginx-rw-concurrent.log';
file_put_contents($log, "$pid|$num_ops|$delta|$tps|$reads|$read_fails|$writes|$write_fails|$begin|$end\n", FILE_APPEND);
$db->close();

