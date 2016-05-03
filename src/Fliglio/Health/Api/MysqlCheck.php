<?php

namespace Fliglio\Health\Api;

class MysqlCheck implements HealthCheck {

	private $host;
	private $user;
	private $pass;

	public function __construct($host, $user, $pass) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
	}

	public function getKey() {
		return 'mysql::'.$this->host.';'.$this->user;
	}

	public function run() {
		$conn = new \mysqli($this->host, $this->user, $this->pass);

		return $conn->connect_error ? HealthStatus::DOWN : HealthStatus::UP;
	}

}