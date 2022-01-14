<?php

namespace Fliglio\Health\Api;

use PHPUnit\Framework\TestCase;
use Fliglio\Health\HealthManager;

class RabbitTest extends TestCase { 

	public function test_CheckUp() {
		$manager = new HealthManager();

		$manager->addCheck(new RabbitCheck(
			getenv('RABBITMQ_HOST'), 
			getenv('RABBITMQ_VHOST'), 
			getenv('RABBITMQ_USER'), 
			getenv('RABBITMQ_PASSWORD'), 
			getenv('RABBITMQ_PORT')
		));

		$this->assertTrue($manager->runAll()->isUp());
	}

	public function test_CheckDown() {
		$manager = new HealthManager();

		$manager->addCheck(new RabbitCheck(
			getenv('RABBITMQ_HOST'), 
			getenv('RABBITMQ_VHOST'), 
			getenv('RABBITMQ_USER'), 
			'baddpassword', 
			getenv('RABBITMQ_PORT')
		));

		$this->assertFalse($manager->runAll()->isUp());
	}

}
