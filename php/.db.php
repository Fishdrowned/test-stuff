<?php

class Db {
	/**
	 * @var PDO
	 */
	protected static $_pdo;

	public static function init($host, $dbName, $dbUser, $dbPassword, $persistent = false, $port = 3306) {
		if (static::$_pdo === null) {
			$pdo = new PDO(sprintf('mysql:host=%s;port=%s;dbname=%s', $host, $port, $dbName), $dbUser, $dbPassword, array(
				PDO::ATTR_PERSISTENT => $persistent,
			));
			static::$_pdo = $pdo;
		}
		return static::$_pdo;
	}

	public static function getPdo() {
		return static::$_pdo;
	}

	public static function close() {
		static::$_pdo = null;
	}
}
