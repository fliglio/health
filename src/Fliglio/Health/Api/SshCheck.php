<?php

namespace Fliglio\Health\Api;

class SshCheck implements HealthCheck {

	private $host;
	private $port;

	public function __construct($host, $port=22, $key=null) {
		$this->host = $host;
		$this->port = $port;
		$this->key  = $key ? $key : $host;
	}

	public function getKey() {
		return 'ssh::'.$this->key;
	} 

	public function run() {
		exec("ssh -q -o BatchMode=yes -o ConnectTimeout=1 {$this->host} 'ls & exit'", $output);

		return !$output ? HealthStatus::DOWN : HealthStatus::UP;
	}

}