<?php

namespace Fliglio\Health\Api;

use Fliglio\Health\HealthManager;

class SshCheckTest extends \PHPUnit_Framework_TestCase { 

	public function test_CheckUp() {
		// given
		$iam = exec('whoami');

		// when
		$manager = new HealthManager();
		$manager->addCheck(new SshCheck($iam.'@localhost'));

		// then
		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_CheckDown() {
		// given
		$manager = new HealthManager();
		$manager->addCheck(new SshCheck('nope@google.com'));

		// then
		$this->assertTrue($manager->runAll()->isDown());
	}

}
