<?php

namespace Fliglio\Health\Api;

use Pdo;

class MysqlCheck implements HealthCheck, HealthCheckReport {

	private $host;
	private $user;
	private $pass;
	private $prefix;
	private $errMsg;

	public function __construct($host, $user, $pass, $prefix=null) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->prefix = $prefix;
	}

	public function getErrorMessage() {
		return $this->errMsg;
	}

	public function getKey() {
		return sprintf('%smysql::%s;%s', $this->prefix, $this->host, $this->user);
	}

	public function run() {
		$status = HealthStatus::UP;

		$options = [
			PDO::ATTR_TIMEOUT => "1", // timeout in seconds
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		];

		try {
			new PDO(
				sprintf("mysql:host=%s", $this->host), 
				$this->user, 
				$this->pass, 
				$options
			);

		} catch (\Exception $e) {
			$this->errMsg = $e->getMessage();
			$status = HealthStatus::DOWN;
		}

		return $status;
	}

}