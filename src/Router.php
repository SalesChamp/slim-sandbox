<?php

namespace App;

use Slim;


class Router
{

	/**
	 * @var Slim\App
	 */
	private $app;



	public function __construct(Slim\App $app)
	{
		$this->app = $app;
	}



	public function registerRoutes()
	{
		$this->app->get('/hello/{name}', Controllers\Hello::class . ':getName');
	}

}
