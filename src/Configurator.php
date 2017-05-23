<?php

namespace App;

use Slim;
use Monolog;


class Configurator
{

	/**
	 * @var array
	 */
	private $settings;



	public function __construct(array $settings)
	{
		$this->settings = $settings;
	}



	public function configure()
	{
		$app = new Slim\App($this->settings);
		$app = $this->configureContainer($app);

		$router = new Router($app);
		$router->registerRoutes();

		return $app;
	}



	public function configureContainer(Slim\App $app)
	{
		$container = $app->getContainer();

		$container[Monolog\Logger::class] = function ($c) {
			$settings = $c->get('settings')[Monolog\Logger::class];
			$logger = new Monolog\Logger($settings['name']);
			$logger->pushProcessor(new Monolog\Processor\UidProcessor());
			$path = isset($_ENV['docker']) ? 'php://stderr' : __DIR__ . '/../logs/app.log';
			$logger->pushHandler(new Monolog\Handler\StreamHandler($path, $settings['level']));
			return $logger;
		};

		$container[Controllers\Hello::class] = function ($c) {
			return new Controllers\Hello($c->get(Monolog\Logger::class));
		};

		return $app;
	}

}
