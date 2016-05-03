<?php

namespace Fliglio\Health\Api;

use Fliglio\Health\HealthManager;

class MysqlCheckTest extends \PHPUnit_Framework_TestCase { 

	public function test_CheckUp() {
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('localhost', 'root', ''));

		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_CheckDown() {
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('localhost', 'root', 'badpasswordandstuff'));

		$this->assertTrue($manager->runAll()->isDown());
	}

}
