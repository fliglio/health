<?php

namespace Fliglio\Health\Behavior;

use Psr\Log\LogLevel;
use Fliglio\Health\Api\HealthStatus;

class LogIssuesBehavior extends Logger implements Behavior {

	public function act(HealthStatus $status) {
		$this->process(
			$status, 
			HealthStatus::WARN, 
			LogLevel::WARNING,
			'%s is warning'
		);

		$this->process(
			$status, 
			HealthStatus::DOWN, 
			LogLevel::ERROR,
			'%s is failing'
		);

		return $status;
	}
}
