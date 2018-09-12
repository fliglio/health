<?php

namespace Fliglio\Health\Behavior;

use Fliglio\Health\Api\HealthStatus;

class SilentOutputBehavior implements Behavior {

	public function act(HealthStatus $status) {
		$status->setChecks([]);
		return $status;
	}

}