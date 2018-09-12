<?php

namespace Fliglio\Health\Behavior;

use Fliglio\Http\Http;
use Fliglio\Http\ResponseWriter;
use Fliglio\Health\Api\HealthStatus;

class StatusCodeBehavior implements Behavior {

	private $response;

	public function __construct(ResponseWriter $response) {
		$this->response = $response;
	}

	public function act(HealthStatus $status) {
		if ($status->isUp()) {
			$this->response->setStatus(Http::STATUS_OK);

		} else if ($status->isDown()) {
			$this->response->setStatus(Http::STATUS_INTERNAL_SERVER_ERROR);

		} else if ($status->isWarn()) {
			$this->response->setStatus(Http::STATUS_ACCEPTED);
		}

		return $status;
	}

}