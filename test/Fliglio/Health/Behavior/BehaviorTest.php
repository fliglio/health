<?php

namespace Fliglio\Health\Behavior;

use Mockery as m;
use Psr\Log\LogLevel;
use Psr\Log\AbstractLogger;
use Fliglio\Health\AlwaysUp;
use Fliglio\Health\AlwaysDown;
use Fliglio\Health\AlwaysWarn;
use Fliglio\Health\HealthManager;

class BehaviorTest extends \PHPUnit_Framework_TestCase { 

	public function test_SilentOutput() {
		// given
		$manager = new HealthManager();
		$manager->addBehavior(new SilentOutputBehavior());

		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysDown());

		// when
		$output = $manager->process();

		// then
		$this->assertEquals($output, ['status' => 'DOWN']);
	}

	public function test_LogFailures() {
		// given
		$logger = m::mock(AbstractLogger::class);

		$manager = new HealthManager($logger);
		$manager->addBehavior(new LogFailuresBehavior($logger));

		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysDown());

		// then
		$logger->shouldReceive('log')
			->with(LogLevel::ERROR, 'Fliglio\Health\AlwaysDown is failing', []);

		// when
		$output = $manager->process();
	}

	public function test_LogWarnings() {
		// given
		$logger = m::mock(AbstractLogger::class);

		$manager = new HealthManager($logger);
		$manager->addBehavior(new LogWarningsBehavior($logger));

		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysWarn())
			->addCheck(new AlwaysDown());

		// then
		$logger->shouldReceive('log')
			->with(LogLevel::WARNING, 'Fliglio\Health\AlwaysWarn is warning', []);

		// when
		$output = $manager->process();
	}
}