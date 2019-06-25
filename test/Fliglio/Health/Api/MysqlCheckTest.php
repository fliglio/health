<?php

namespace Fliglio\Health\Api;

use Fliglio\Health\HealthManager;

class MysqlCheckTest extends \PHPUnit_Framework_TestCase { 

	public function test_CheckUp() {
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('127.0.0.1', 'root', ''));

		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_CheckDown() {
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('127.0.0.1', 'root', 'badpasswordandstuff'));

		$this->assertTrue($manager->runAll()->isDown());
	}

	public function test_BadHost() {
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('foobar', 'root', ''));

		$this->assertTrue($manager->runAll()->isDown());
	}

}
