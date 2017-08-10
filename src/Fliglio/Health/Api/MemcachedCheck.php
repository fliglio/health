<?php

namespace Fliglio\Health\Api;

use Memcached;

class MemcachedCheck implements HealthCheck {

	private $host;
	private $port;
	private $namespace;
	private $isDiscoverable;
	private $expire = 0;
	private $namespacePattern = "%s_%s";

	public function __construct($host, $port, $namespace, $isDiscoverable=false) {
		$this->host           = $host;
		$this->port           = $port;
		$this->namespace      = $namespace;
		$this->isDiscoverable = $isDiscoverable;
	}

	public function getKey() {
		return 'memcached::'.$this->host;
	}

	public function run() {
		try {
			$result = HealthStatus::DOWN;

			$store = new Memcached();
			if ($this->isDiscoverable) {
				// Specific to AWS Elasticache Autodiscovery (Constants do not exist elsewhere)
				$store->setOption(Memcached::OPT_CLIENT_MODE, Memcached::DYNAMIC_CLIENT_MODE);
			}
			$store->addServer($this->host, $this->port);

			$key    = "key_".uniqid();
			$string = "str_".uniqid();
			$nsKey  = sprintf("%s_%s", $this->namespace, $key);

			$storedString = $store->get($nsKey);
			if (!$storedString) {
				$store->add($nsKey, $string, $this->expire);
			}

			if ($store->get($nsKey) == $string) {
				$result = HealthStatus::UP;
			}
		} catch (\Exception $e) {
			// Catch and allow healthstatus of down to be returned
		}

		return $result;
	}

}