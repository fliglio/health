<?php

namespace Fliglio\Health\Behavior;

use Psr\Log\LoggerInterface;
use Fliglio\Health\Api\HealthStatus;
use Fliglio\Health\Api\HealthCheckReport;

class Logger {

	const LOG_NS = '[FliglioHealth]';

	private $logger;

	public function __construct(LoggerInterface $logger = null) {
		$this->logger = $logger;
	}

	protected function process(HealthStatus $status, $healthStatus, $logLevel, $defaultLogMsg) {
		foreach ($status->getChecks() as $key => $checkStatus) {
			if ($checkStatus == $healthStatus) {
				$this->log(
					$logLevel, 
					sprintf($defaultLogMsg, $key)
				);

				// Additional information if healthcheck implements HealthCheckReport
				$check = $status->getCheckObject($key);
				if (!is_null($check) && $check instanceof HealthCheckReport) {
					$this->log(
						$logLevel,
						$check->getErrorMessage()
					);
				}
			}
		}

		return $status;
	}

	protected function log($level, $msg) {
		$msg = self::LOG_NS.' '.$msg;

		if (!is_null($this->logger)) {
			$this->logger->log($level, $msg, []);

		} else {
			error_log($msg);
		}
	}
}
