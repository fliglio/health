<?php

namespace Fliglio\Health;

use Fliglio\Health\Api as api;

class AlwaysDown implements api\HealthCheck, api\HealthCheckReport {

	const ERR_MSG = "Im always down";

	public function getErrorMessage() {
		return self::ERR_MSG;
	}

	public function getKey() { 
		return __CLASS__; 
	}

	public function run() {
		return api\HealthStatus::DOWN;
	}
}
