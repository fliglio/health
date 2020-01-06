<?php

namespace Fliglio\Health\Api;

class CanWriteCheck implements HealthCheck, HealthCheckReport {

	private $dest;
	private $errMsg;

	public function __construct($dest) {
		$this->dest = $dest;
	}

	public function getErrorMessage() {
		return $this->errMsg;
	}

	public function getKey() {
		return 'can_write::'.$this->dest;
	}

	public function run() {
		$status = HealthStatus::UP;

		if (!is_writable($this->dest)) {
			$this->errMsg = sprintf('%s is not writable', $this->dest);
			$status = HealthStatus::DOWN;
		}

		return $status;
	}

}