[![Build Status](https://travis-ci.org/fliglio/health.svg?branch=master)](https://travis-ci.org/fliglio/health)
[![Latest Stable Version](https://poser.pugx.org/fliglio/health/v/stable.svg)](https://packagist.org/packages/fliglio/health)


# fliglio-healthcheck
Extensible suite of health checks for PHP services, complete with custom behaviors to suit your health check consumer's needs. Default health checks include Mysql, Rabbit, Memcache, Can Write File, SSH and HttpResolver.


# Example One:
```
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('localhost', 'myuser', 'password'));

		echo json_encode($manager->process());
```
If your connection information is good, you should see:
```
		{"status":"UP", "mysql::localhost;myuser":"UP"}
```

If the connection is not good, for whatever reason, you'll get:
```
		{"status":"DOWN", "mysql::localhost;myuser":"DOWN"}
```


# Example Two:
```
		$manager = new HealthManager();
		$manager->addCheck(new MysqlCheck('localhost', 'myuser', 'password'))
			->addOptionalCheck(new RabbitCheck('localhost', '/'', 'myuser', 'password'));

		echo json_encode($manager->process());
```
If the optional check is down, the status will remain "UP". Example:
```
		{"status":"UP", "mysql::localhost;myuser":"UP", "rabbit::localhost;myuser":"WARN"}
```


# Behavior Example:
Depending on your apps health check reporting needs, you can add behaviors. 
```
		$response = new fliglio\Response();

		$manager = new HealthManager();
		$manager->addBehavior(new SilentOutputBehavior())
			->addBehavior(new LogFailuresBehavior())
			->addBehavior(new StatusCodeBehavior($response);

		$manager->addCheck(new MysqlCheck('localhost', 'myuser', 'password'));

		echo json_encode($manager->process());
```
If the check is up, you will get HTTP 200 and a single json property. Example:
```
		{"status":"UP"}
```
If the check is down, you will get HTTP 500, a message in the php log and a single json property. Example:
```
		{"status":"DOWN"}
```

# Public AWS ALB Behavior Example:
```
		$response = new fliglio\Response();

		$manager = new HealthManager();
		$manager->addBehavior(new SilentOutputBehavior())
			->addBehavior(new StatusCodeBehavior($response);

```

# Custom Health Checks:
You can add your own custom health checks, just implement the interface Fliglio\Health\Api\HealthCheck. If you want that health check to log, you'll need to implement the HealthCheckReport interface in addition to adding the LogFailuresBehavior/LogWarningsBehavior behavior.


