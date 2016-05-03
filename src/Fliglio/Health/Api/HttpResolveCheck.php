<?php

namespace Fliglio\Health\Api;

class HttpResolveCheck implements HealthCheck {

	private $host;

	public function __construct($host) {
		$parts = parse_url($host);

		$this->host = isset($parts['host']) ? $parts['host'] : $host;
	}

	public function getKey() {
		return 'http_resolve::'.$this->host;
	}

	public function run() {
		$ip = gethostbyname($this->host);

		return $ip == $this->host ? HealthStatus::DOWN : HealthStatus::UP;
	}

}