<?php

namespace Fliglio\Health\Api;

class HttpResolveCheck implements HealthCheck, HealthCheckReport {

	private $host;
	private $errMsg;

	public function __construct($host) {
		$parts = parse_url($host);

		$this->host = isset($parts['host']) ? $parts['host'] : $host;
	}

	public function getErrorMessage() {
		return $this->errMsg;
	}

	public function getKey() {
		return 'http_resolve::'.$this->host;
	}

	public function run() {
		$status = HealthStatus::UP;

		$ip = gethostbyname($this->host);

		if ($ip == $this->host) {
			$status = HealthStatus::DOWN;
			$this->errMsg = sprintf('Could not resolve %s', $this->host);
		}

		return $status;
	}

}