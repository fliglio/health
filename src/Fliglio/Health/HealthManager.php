<?php

namespace Fliglio\Health;

use Fliglio\Health\Api as api;
use Fliglio\Health\Behavior\Behavior;

class HealthManager {

	private $checks = [];
	private $behaviors = [];
	private $optionalChecks = [];

	public function addBehavior(Behavior $behavior) {
		$this->behaviors[] = $behavior;
		return $this;
	}

	public function addCheck(api\HealthCheck $check, $optional=false) {
		if ($optional) {
			$this->optionalChecks[] = $check;
		} else {
			$this->checks[] = $check;
		}
		return $this;
	}

	public function runAll() {
		$status = new api\HealthStatus();
		$status->setStatus(api\HealthStatus::UP);

		foreach ($this->checks as $check) {
			$result = api\HealthStatus::DOWN;

			try {
				$result = $check->run();
			} catch (\Exception $e) {}

			$status->addCheck($check->getKey(), $result);

			if ($result != api\HealthStatus::UP) {
				$status->setStatus(api\HealthStatus::DOWN);
			}
		}

		foreach ($this->optionalChecks as $check) {
			try {
				$result = $check->run();
			} catch (\Exception $e) {}

			if ($result != api\HealthStatus::UP) {
				$result = api\HealthStatus::WARN;
			}

			$status->addCheck($check->getKey(), $result);
		}

		return $status;
	}

	public function process() {
		$status = $this->runAll();

		foreach ($this->behaviors as $behavior) {
			$status = $behavior->act($status);
		}

		return (new HealthStatusObjectMapper())->getEncoded($status);
	}

}
