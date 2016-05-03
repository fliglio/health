<?php

namespace Fliglio\Health\Api;

interface HealthCheck {
	public function getKey();
	public function run();
}