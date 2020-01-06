<?php

namespace Fliglio\Health\Behavior;

use Mockery as m;
use Psr\Log\LogLevel;
use Psr\Log\AbstractLogger;
use Fliglio\Health\AlwaysUp;
use Fliglio\Health\AlwaysDown;
use Fliglio\Health\AlwaysWarn;
use Fliglio\Health\HealthManager;
use Fliglio\Http\ResponseWriter;

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
		$logger = m::mock('Psr\Log\AbstractLogger');

		$manager = new HealthManager();
		$manager->addBehavior(new LogFailuresBehavior($logger));

		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysDown());

		// then
		$logger->shouldReceive('log')
			->with(LogLevel::ERROR, Logger::LOG_NS.' Fliglio\Health\AlwaysDown is failing', [])
			->once();

		$logger->shouldReceive('log')
			->with(LogLevel::ERROR, Logger::LOG_NS.' '.AlwaysDown::ERR_MSG, [])
			->once();

		// when
		$output = $manager->process();
	}

	public function test_LogWarnings() {
		// given
		$logger = m::mock('Psr\Log\AbstractLogger');

		$manager = new HealthManager();
		$manager->addBehavior(new LogWarningsBehavior($logger));

		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysWarn())
			->addCheck(new AlwaysDown());

		// then
		$logger->shouldReceive('log')
			->with(LogLevel::WARNING, Logger::LOG_NS.' Fliglio\Health\AlwaysWarn is warning', [])
			->once();

		$logger->shouldReceive('log')
			->with(LogLevel::WARNING, Logger::LOG_NS.' '.AlwaysWarn::ERR_MSG, [])
			->once();

		// when
		$output = $manager->process();
	}

	public function test_LogIssues() {
		// given
		$logger = m::mock('Psr\Log\AbstractLogger');

		$manager = new HealthManager();
		$manager->addBehavior(new LogIssuesBehavior($logger));

		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysWarn())
			->addCheck(new AlwaysDown());

		// then
		$logger->shouldReceive('log')
			->with(LogLevel::WARNING, Logger::LOG_NS.' Fliglio\Health\AlwaysWarn is warning', [])
			->once();

		$logger->shouldReceive('log')
			->with(LogLevel::WARNING, Logger::LOG_NS.' '.AlwaysWarn::ERR_MSG, [])
			->once();

		$logger->shouldReceive('log')
			->with(LogLevel::ERROR, Logger::LOG_NS.' Fliglio\Health\AlwaysDown is failing', [])
			->once();

		$logger->shouldReceive('log')
			->with(LogLevel::ERROR, Logger::LOG_NS.' '.AlwaysDown::ERR_MSG, [])
			->once();

		// when
		$output = $manager->process();
	}

	public function test_StatusCodes_Success() {
		// given
		$response = m::mock('Fliglio\Http\ResponseWriter');

		$manager = new HealthManager();
		$manager->addBehavior(new StatusCodeBehavior($response));

		$manager->addCheck(new AlwaysUp());

		// then
		$response->shouldReceive('setStatus')
			->with(200)
			->once();

		// when
		$output = $manager->process();
	}

	public function test_StatusCodes_Error() {
		// given
		$response = m::mock('Fliglio\Http\ResponseWriter');

		$manager = new HealthManager();
		$manager->addBehavior(new StatusCodeBehavior($response));

		$manager->addCheck(new AlwaysUp())
			->addCheck(new AlwaysDown());

		// then
		$response->shouldReceive('setStatus')
			->with(500)
			->once();

		// when
		$output = $manager->process();
	}

	// Non-optional warn is a "down", aka 500
	public function test_StatusCodes_Warn() {
		// given
		$response = m::mock('Fliglio\Http\ResponseWriter');

		$manager = new HealthManager();
		$manager->addBehavior(new StatusCodeBehavior($response));

		$manager->addCheck(new AlwaysWarn());

		// then
		$response->shouldReceive('setStatus')
			->with(500)
			->once();

		// when
		$output = $manager->process();
	}

}
