<?php

namespace Fliglio\Health;

use Fliglio\Health\Api as api;

class AlwaysWarn implements api\HealthCheck {
	public function getKey() { return __CLASS__; }
	public function run() {
		return api\HealthStatus::WARN;
	}
}