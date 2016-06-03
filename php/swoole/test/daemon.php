<?php

class AppServer {
	public $httpServer;
	protected $_workers;

	public function __construct() {
		$this->httpServer = new swoole_http_server('0.0.0.0', 9080);
		$this->httpServer->set(
			array(
				'worker_num' => 4,
				'daemonize' => false,
				'max_request' => 10,
				'dispatch_mode' => 1,
			)
		);
		$this->httpServer->on('workerStart', [$this, 'onWorkerStart']);
		$this->httpServer->on('request', function (swoole_http_request $httpRequest, swoole_http_response $response) {
//			$response->end('');
//			return;
			$this->_resetRequest($httpRequest);

//			$response->cookie('xx', 'abcd', 0, '/');
			ob_start();
			var_dump(password_hash(md5('123456'), PASSWORD_BCRYPT, array('cost' => 10)));
			var_dump($_SERVER, 'G', $_GET, 'P', $_POST, 'C', $_COOKIE, 'R', $_REQUEST, 'F', $_FILES, Registry::get('x'));
			$response->end(ob_get_clean());
		});

		$this->httpServer->start();
	}

	protected function _resetRequest(swoole_http_request $httpRequest) {
		isset($httpRequest->header) or $httpRequest->header = array();
		$_SERVER = array_change_key_case($httpRequest->server, CASE_UPPER);
		$_SERVER['SCRIPT_NAME'] = $_SERVER['PHP_SELF'] = '/index.php';
		$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';
		$_SERVER['SCRIPT_FILENAME'] = $_SERVER['DOCUMENT_ROOT'] . '/index.php';
		isset($_SERVER['PATH_INFO']) && strpos($_SERVER['PATH_INFO'], $_SERVER['PHP_SELF']) === 0 and
		$_SERVER['PATH_INFO'] = substr($_SERVER['PATH_INFO'], 10);
		foreach ($httpRequest->header as $k => $v) {
			$_SERVER['HTTP_' . strtoupper(strtr($k, '-', '_'))] = $v;
		}
		$_GET = isset($httpRequest->get) ? $httpRequest->get : array();
		$_POST = isset($httpRequest->post) ? $httpRequest->post : array();
		$_COOKIE = isset($httpRequest->cookie) ? $httpRequest->cookie : array();
		$_FILES = isset($httpRequest->files) ? $httpRequest->files : array();
		$_REQUEST = array_merge($_GET, $_POST);
	}

	public function onWorkerStart(swoole_server $server, $workerId) {
		ini_set('html_errors', 1);
		Registry::set('x', Registry::get('x') . $workerId . ', ');
		sleep(1);
	}
}

new AppServer();

class Registry {
	protected static $_registry = array();

	public static function set($k, $v) {
		static::$_registry[$k] = $v;
	}

	public static function get($k) {
		return isset(static::$_registry[$k]) ? static::$_registry[$k] : null;
	}
}
