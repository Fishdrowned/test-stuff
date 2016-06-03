<?php

class UnixSocketServer {
	public $socketServer;
	protected $_workers;
	protected $_data = array();

	public function __construct() {
		ini_set('html_errors', 1);
		$sockFile = __DIR__ . '/service.sock';
//		is_file($sockFile) or touch($sockFile);
		$this->socketServer = new swoole_server($sockFile, 0, SWOOLE_PROCESS, SWOOLE_UNIX_STREAM);
		$this->socketServer->set(
			array(
				'worker_num' => 4,
				'daemonize' => false,
				'max_request' => 1000,
				'dispatch_mode' => 2,
//				'open_eof_check' => true,   //打开EOF检测
//				'package_eof' => "\r\n",    //设置EOF

				'open_length_check' => true,
				'package_max_length' => 262144,
				'package_length_type' => 'N', //see php pack()
				'package_length_offset' => 0,
				'package_body_offset' => 4,
			)
		);
		$this->socketServer->on('workerStart', [$this, 'onWorkerStart']);
		$this->socketServer->on('receive', [$this, 'onReceive']);
		$this->socketServer->on('start', [$this, 'onStart']);
		$this->socketServer->on('ManagerStart', [$this, 'onManagerStart']);
		/*$this->socketServer->on('receive', function (swoole_server $server, $fd, $fromId, $data) {
			static $packages;
			$packages === null and $packages = array();
			if (isset($packages[$fd])) {
				$packages[$fd] and $packages[$fd]['content'] .= $data;
			} else {
				$data = explode('|', $data, 2);
				if (count($data) == 2 && is_numeric($data[0])) {
					$packages[$fd] = array(
						'length' => $data[0],
						'content' => $data[1],
					);
				} else {
					$packages[$fd] = false;
					$server->close($fd);
					return;
				}
			}
			if (strlen($request = $packages[$fd]['content']) >= $length = $packages[$fd]['length']) {
//				file_put_contents(__DIR__ . '/requests.log', var_export($packages, 1), FILE_APPEND);
				unset($packages[$fd]);
				ob_start();
				var_dump('Server PID: ' . $server->master_pid, strlen($request), $length, $request);
				$response = ob_get_clean();
				$server->send($fd, $response, $fromId);
			}
		});*/
//		file_put_contents(__DIR__ . '/requests.log', '');

		$this->socketServer->start();
	}

	public function onWorkerStart(swoole_server $server, $workerId) {
		@cli_set_process_title('server: worker process');
//		echo "Worker {$workerId} started.\n";
	}

	public function onReceive(swoole_server $server, $fd, $fromId, $data) {
		$length = unpack('N', $data)[1];
		$data = unserialize(substr($data, -$length));
		ob_start();
		var_dump('Got:');
		var_dump($data);
		$responseBody = ob_get_clean();
		$response = serialize(array(
			'header' => array('xx' => 'oo'),
			'body' => $responseBody,
		));
		$response = pack('N', strlen($response)) . $response;
		$server->send($fd, $response, $fromId);
	}

	public function onStart(swoole_server $server) {
		@cli_set_process_title('server: master process');

		$sockFile = __DIR__ . '/command.sock';
		if (file_exists($sockFile)) {
			unlink($sockFile);
		}
		ini_set('html_errors', 0);
		if (!$commandServer = stream_socket_server('unix://' . $sockFile, $errNo, $errStr)) {
			echo "Command handler start failed: $errStr ($errNo)\n";
		} else {
			swoole_event_add($commandServer, function($commandServer) {
				$conn = stream_socket_accept($commandServer, 0);
				swoole_event_add($conn, function($conn) {
					$command = fread($conn, 8192);
					swoole_event_set($conn, null, function ($conn) use ($command) {
						$server = $this->socketServer;
						switch ($command) {
							case 'status':
								$labels = array (
									'start_time' => 'Server started at',
									'connection_num' => 'Current connections',
									'request_count' => 'Total requests',
								);
								$stats = $server->stats();
								$data = "Service is running. PID: {$server->master_pid}\n";
								foreach ($labels as $k => $label) {
									$v = $stats[$k];
									$k == 'start_time' and $v = date('Y-n-j H:i:s', $v);
									$data .= "$label: $v\n";
								}
								break;
							case 'shutdown':
								$data = 'Shutting down...';
								$server->shutdown();
								break;
							default:
								$data = 'Bad command';
						}
						fwrite($conn, $data, strlen($data));
						swoole_event_del($conn);
					}, SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE);
				});
			});
			echo 'Command handler started.', "\n";
		}

		echo 'Server started.', "\n";
	}

	public function onManagerStart(swoole_server $server) {
		@cli_set_process_title('server: manager process');
	}
}

new UnixSocketServer();
