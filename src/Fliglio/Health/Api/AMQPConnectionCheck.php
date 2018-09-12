<?php

namespace Fliglio\Health\Api;

use PhpAmqpLib\Connection\AMQPConnection;

class AMQPConnectionCheck implements HealthCheck, HealthCheckReport {

	private $subkey;
	private $connection;
	private $errMsg;

	public function __construct(AMQPConnection $connection, $subkey = "") {
		$this->connection = $connection;
		$this->subkey = $subkey;
	}

	public function getErrorMessage() {
		return $this->errMsg;
	}

	public function getKey() {
		return 'rabbit::'.$this->subkey;
	}

	public function run() {
		if (!is_null($this->connection)) {
			return HealthStatus::UP;
		} else {
			$this->errMsg = 'Connection was null';
			return HealthStatus::DOWN;
		}
	}
}
