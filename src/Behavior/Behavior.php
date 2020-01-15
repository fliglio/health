<?php

namespace Fliglio\Health\Behavior;

use Fliglio\Health\Api\HealthStatus;

interface Behavior {

	/**
	 * @return HealthStatus
	 */
	public function act(HealthStatus $status);
}