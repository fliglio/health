<?php

namespace Fliglio\Health\Api;

class HealthStatus {

	const UP   = 'UP';
	const DOWN = 'DOWN';
	const WARN = 'WARN';

	private $status;
	private $checks = [];
	private $checkObjects = [];

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
	public function getCheckObjects() {
		return $this->checkObjects;
	}
	public function getCheckObject($key) {
		return isset($this->checkObjects[$key]) ? $this->checkObjects[$key] : null;
	}

	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function setChecks(array $checks) {
		$this->checks = $checks;
		return $this;
	}
	public function addCheck($key, $status, HealthCheck $object = null) {
		$this->checks[$key] = $status;

		if (!is_null($object)) {
			$this->checkObjects[$key] = $object;
		}
	}

}