<?php

namespace Fliglio\Health;

use Fliglio\Health\Api as api;

class HealthManagerTest extends \PHPUnit_Framework_TestCase { 

	public function test_TopLevelStatusReportsDown() {
		$manager = new HealthManager();
		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysDown());

		$this->assertTrue($manager->runAll()->isDown());
	}

	public function test_TopLevelStatusReportsDownWithWarn() {
		$manager = new HealthManager();
		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysWarn());

		$this->assertTrue($manager->runAll()->isDown());
	}

	public function test_TopLevelStatusReportsUp() {
		$manager = new HealthManager();
		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysUp())
			->addCheck(new AlwaysUp());

		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_HealthStatusObjectMapper() {
		$objMpr  = new HealthStatusObjectMapper();
		$manager = new HealthManager();
		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysWarn())
			->addCheck(new AlwaysDown());

		$statusVo = $objMpr->getEncoded($manager->runAll());

		$this->assertEquals($statusVo, [
			'status' => 'DOWN', 
			'Fliglio\Health\AlwaysUp'   => 'UP',
			'Fliglio\Health\AlwaysWarn' => 'WARN',
			'Fliglio\Health\AlwaysDown' => 'DOWN',
		]);
	}

}

class AlwaysUp implements api\HealthCheck {
	public function getKey() { return __CLASS__; }
	public function run() {
		return api\HealthStatus::UP;
	}
}

class AlwaysDown implements api\HealthCheck {
	public function getKey() { return __CLASS__; }
	public function run() {
		return api\HealthStatus::DOWN;
	}
}

class AlwaysWarn implements api\HealthCheck {
	public function getKey() { return __CLASS__; }
	public function run() {
		return api\HealthStatus::WARN;
	}
}