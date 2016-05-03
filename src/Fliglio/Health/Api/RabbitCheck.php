<?php

namespace Fliglio\Health\Api;

use PhpAmqpLib\Connection\AMQPConnection;

class RabbitCheck implements HealthCheck {

	private $host;
	private $virtualHost;
	private $user;
	private $password;
	private $port;

	public function __construct($host, $virtualHost, $user, $password, $port) {
		$this->host        = $host;
		$this->virtualHost = $virtualHost;
		$this->user        = $user;
		$this->password    = $password;
		$this->port        = $port;
	}

	public function getKey() {
		return 'rabbit::'.$this->host.';'.$this->user;
	}

	public function run() {
		try {
			$conn = new AMQPConnection(
					$this->host,
					$this->port,
					$this->user,
					$this->password,
					$this->virtualHost
				);	
			return HealthStatus::UP;

		} catch (\Exception $e) {
			return HealthStatus::DOWN;
		}
	}

}