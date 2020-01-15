<?php

namespace Fliglio\Health;

use Fliglio\Health\Api;

class HealthStatusObjectMapper {

	public function getEncoded(api\HealthStatus $status) {
		$statuses = [];

		$statuses['status'] = $status->getStatus();

		foreach ($status->getChecks() as $key => $value) {
			$statuses[$key] = $value;
		}

		return $statuses;
	}

}