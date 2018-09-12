<?php

namespace Fliglio\Health\Behavior;

use Psr\Log\LogLevel;
use Fliglio\Health\Api\HealthStatus;

class LogWarningsBehavior extends Logger implements Behavior {

	public function act(HealthStatus $status) {
		return $this->process(
			$status, 
			HealthStatus::WARN, 
			LogLevel::WARNING,
			'%s is warning'
		);
	}
}
