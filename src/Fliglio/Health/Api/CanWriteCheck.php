<?php

namespace Fliglio\Health\Api;

class CanWriteCheck implements HealthCheck {

	private $dest;

	public function __construct($dest) {
		$this->dest = $dest;
	}

	public function getKey() {
		return 'can_write::'.$this->dest;
	}

	public function run() {
		return is_writable($this->dest) ? HealthStatus::UP : HealthStatus::DOWN;
	}

}