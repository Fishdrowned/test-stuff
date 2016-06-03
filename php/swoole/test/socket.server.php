<?php

class SocketServer {
	public $socketServer;
	protected $_workers;
	protected $_data = array();

	public function __construct() {
		ini_set('html_errors', 1);
		$this->socketServer = new swoole_server('0.0.0.0', 9080);
		$this->socketServer->set(
			array(
				'worker_num' => 4,
				'daemonize' => false,
				'max_request' => 1000,
				'dispatch_mode' => 2,
				'open_eof_check' => true,   //打开EOF检测
				'package_eof' => "\r\n",    //设置EOF
			)
		);
		$this->socketServer->on('workerStart', [$this, 'onWorkerStart']);
		$this->socketServer->on('receive', function (swoole_server $server, $fd, $fromId, $data) {
//			ob_start();
			echo $data;
//			$server->send($fd, ob_get_clean(), $fromId);
		});

		$this->socketServer->start();
	}

	public function onWorkerStart(swoole_server $server, $workerId) {
	}
}

new SocketServer();
