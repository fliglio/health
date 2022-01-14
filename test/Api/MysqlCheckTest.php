<?php

namespace Fliglio\Health\Api;

use PHPUnit\Framework\TestCase;
use Fliglio\Health\HealthManager;

class MysqlCheckTest extends TestCase { 

	public function test_CheckUp() {
		$manager = new HealthManager();

		$manager->addCheck(new MysqlCheck(
			getenv('DB_HOST'), 
			getenv('DB_USERNAME'), 
			getenv('DB_PASSWORD')
		));

		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_CheckDown() {
		$manager = new HealthManager();

		$manager->addCheck(new MysqlCheck(
			getenv('DB_HOST'), 
			getenv('DB_USERNAME'), 
			'badpassword'
		));

		$this->assertTrue($manager->runAll()->isDown());
	}

	public function test_BadHost() {
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('foobar', 'root', ''));

		$this->assertTrue($manager->runAll()->isDown());
	}

}
