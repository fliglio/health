<?php

namespace Fliglio\Health;

use Fliglio\Health\Api as api;

class AlwaysUp implements api\HealthCheck {
	public function getKey() { return __CLASS__; }
	public function run() {
		return api\HealthStatus::UP;
	}
}