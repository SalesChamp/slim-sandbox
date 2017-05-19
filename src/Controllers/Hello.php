<?php

namespace App\Controllers;

use Monolog;
use Slim\Http\Request;
use Slim\Http\Response;


class Hello
{

	private $logger;



	public function __construct(Monolog\Logger $logger)
	{
		$this->logger = $logger;
	}



	public function getName(Request $request, Response $response, $args)
	{
		$this->logger->info("Slim-Skeleton '/' route");

		return $response->withJson(['status' => "Hello {$args['name']}"]);
	}

}
