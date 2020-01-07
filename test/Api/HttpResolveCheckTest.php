<?php

namespace Fliglio\Health\Api;

use Fliglio\Health\HealthManager;

class HttpResolveCheckTest extends \PHPUnit_Framework_TestCase { 

	public function test_CheckUpWithProtocol() {
		$manager = new HealthManager();
		$manager->addCheck(new HttpResolveCheck('http://google.com'));

		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_CheckUpWithOutProtocol() {
		$manager = new HealthManager();
		$manager->addCheck(new HttpResolveCheck('www.google.com'));

		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_CheckDown() {
		$manager = new HealthManager();
		$manager->addCheck(new HttpResolveCheck('http://badhostname'));

		$this->assertTrue($manager->runAll()->isDown());
	}


	public function test_CheckUpWithOptional() {
		$manager = new HealthManager();
		$manager->addCheck(new HttpResolveCheck('http://google.com'));
		$manager->addOptionalCheck(new HttpResolveCheck('http://badhostname'));

		$this->assertTrue($manager->runAll()->isUp());
	}

}
