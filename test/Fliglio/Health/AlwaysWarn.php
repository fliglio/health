<?php

namespace Fliglio\Health;

use Fliglio\Health\Api as api;

class AlwaysWarn implements api\HealthCheck, api\HealthCheckReport {

	const ERR_MSG = "Im always warn";

	public function getErrorMessage() {
		return self::ERR_MSG;
	}

	public function getKey() {
		return __CLASS__;
	}

	public function run() {
		return api\HealthStatus::WARN;
	}
}