<?php

namespace Fliglio\Health\Behavior;

use Psr\Log\LogLevel;
use Fliglio\Health\Api\HealthStatus;

class LogFailuresBehavior extends Logger implements Behavior {

	public function act(HealthStatus $status) {
		return $this->process(
			$status, 
			HealthStatus::DOWN, 
			LogLevel::ERROR,
			'%s is failing'
		);
	}
}
