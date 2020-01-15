<?php

namespace Fliglio\Health\Api;

class SshCheck implements HealthCheck, HealthCheckReport {

	private $host;
	private $port;
	private $errMsg;

	public function __construct($host, $port=22, $key=null) {
		$this->host = $host;
		$this->port = $port;
		$this->key  = $key ? $key : $host;
	}

	public function getErrorMessage() {
		return $this->errMsg;
	}

	public function getKey() {
		return 'ssh::'.$this->key;
	} 

	public function run() {
		$status = HealthStatus::UP;

		exec("ssh -q -o BatchMode=yes -o ConnectTimeout=1 {$this->host} 'ls & exit'", $output);

		if (!$output) {
			$status = HealthStatus::DOWN;
			$this->errMsg = sprintf('ls return nothing for %s', $this->host);
		}

		return $status;
	}

}