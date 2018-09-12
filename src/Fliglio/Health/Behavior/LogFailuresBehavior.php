<?php

namespace Fliglio\Health\Behavior;

use Psr\Log\LogLevel;
use Psr\Log\AbstractLogger;
use Fliglio\Health\Api\HealthStatus;

class LogFailuresBehavior extends Logger implements Behavior {

	public function act(HealthStatus $status) {
		foreach ($status->getChecks() as $key => $checkStatus) {
			if ($checkStatus == HealthStatus::DOWN) {
				$this->log(
					sprintf(self::LOG_MSG_DOWN, $key),
					LogLevel::ERROR
				);
			}
		}

		return $status;
	}

}
