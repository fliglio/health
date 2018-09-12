<?php

namespace Fliglio\Health\Behavior;

use Psr\Log\LogLevel;
use Fliglio\Health\Api\HealthStatus;

class LogWarningsBehavior extends Logger implements Behavior {

	public function act(HealthStatus $status) {
		foreach ($status->getChecks() as $key => $checkStatus) {
			if ($checkStatus == HealthStatus::WARN) {
				$this->log(
					sprintf(self::LOG_MSG_WARN, $key),
					LogLevel::WARNING
				);
			}
		}

		return $status;
	}
}
