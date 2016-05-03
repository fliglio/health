<?php

namespace Fliglio\Health\Api;

class HealthStatus {

	const UP   = 'UP';
	const DOWN = 'DOWN';
	const WARN = 'WARN';

	private $status;
	private $checks = [];

	public function isUp() {
		return $this->status == self::UP;
	}
	public function isDown() {
		return $this->status == self::DOWN;
	}
	public function isWarn() {
		return $this->status == self::WARN;
	}

	public function getStatus() {
		return $this->status;
	}
	public function getChecks() {
		return $this->checks;
	}

	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function addCheck($key, $status) {
		$this->checks[$key] = $status;
	}

}