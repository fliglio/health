<?php

namespace Fliglio\Health\Api;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitCheck implements HealthCheck, HealthCheckReport {

	private $host;
	private $virtualHost;
	private $user;
	private $password;
	private $port;
	private $errMsg;

	public function __construct($host, $virtualHost, $user, $password, $port) {
		$this->host        = $host;
		$this->virtualHost = $virtualHost;
		$this->user        = $user;
		$this->password    = $password;
		$this->port        = $port;
	}

	public function getErrorMessage() {
		return $this->errMsg;
	}

	public function getKey() {
		return 'rabbit::'.$this->host.';'.$this->user;
	}

	public function run() {
		try {
			$conn = new AMQPStreamConnection(
				$this->host,
				$this->port,
				$this->user,
				$this->password,
				$this->virtualHost
			);
			return HealthStatus::UP;

		} catch (\Exception $e) {
			$this->errMsg = $e->getMessage();
			return HealthStatus::DOWN;
		}
	}

}
