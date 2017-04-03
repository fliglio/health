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
		$conn = new \mysqli($this->host, $this->user, $this->pass);

		return $conn->connect_error ? HealthStatus::DOWN : HealthStatus::UP;
	}

}