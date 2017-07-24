<?php

namespace Fliglio\Health\Api;

use PhpAmqpLib\Connection\AMQPConnection;

class AMQPConnectionCheck implements HealthCheck {

	private $connection;
    private $subkey;

	public function __construct(AMQPConnection $connection, $subkey = "") {
		$this->connection = $connection;
        $this->subkey = $subkey;
    }

	public function getKey() {
		return 'rabbit::'.$this->subkey;
	}

	public function run() {
        if (!is_null($this->connection)) {
            return HealthStatus::UP;
        } else {
            return HealthStatus::DOWN;
        }
	}
}
