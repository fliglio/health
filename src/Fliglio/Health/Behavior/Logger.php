<?php

namespace Fliglio\Health\Behavior;

use Psr\Log\LogLevel;
use Psr\Log\AbstractLogger;

class Logger {

	const LOG_MSG_DOWN = '%s is failing';
	const LOG_MSG_WARN = '%s is warning';

	private $logger;

	public function __construct(AbstractLogger $logger = null) {
		$this->logger = $logger;
	}

	protected function log($msg, $level) {
		if (!is_null($this->logger)) {
			$this->logger->log($level, $msg, []);

		} else {
			error_log($msg);
		}
	}
}
