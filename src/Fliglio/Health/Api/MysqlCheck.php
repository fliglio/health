<?php

namespace Fliglio\Health\Api;

class MysqlCheck implements HealthCheck {

	private $host;
	private $user;
	private $pass;
	private $prefix;

	public function __construct($host, $user, $pass, $prefix=null) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->prefix = $prefix;
	}

	public function getKey() {
		return sprintf('%smysql::%s;%s', $this->prefix, $this->host, $this->user);
	}

	public function run() {
		$status = HealthStatus::UP;

		$options = [
			\PDO::ATTR_TIMEOUT => "1",
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
		];

		try {
			new \PDO(
				sprintf("mysql:host=%s", $this->host), 
				$this->user, 
				$this->pass, 
				$options
			);

		} catch (\Exception $e) {
			$status = HealthStatus::DOWN;
		}

		return $status;
	}

}