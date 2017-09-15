<?php

namespace EFW\Init;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define("DB_HOST", "localhost");
define("DB_NAME", "efw");
define("DB_LOGIN", "root");
define("DB_PASS", "root");

abstract class Bootstrap
{
	private $routes;

	public function __construct()
	{
		$this->initRoutes();
		$this->run($this->getUrl());
	}

	/*
	* Master function inherited in Init file.
	*/
	abstract protected function initRoutes();

	/*
	* Check if entered URL exists in route array.
	* if exists = 200 OK
	* else = 404 NOT FOUND
	*/
	protected function run($url)
	{
		//Check if the URL ends with '/' and remove the character to works correctly!
		if(strlen($url) > 1){
			if(substr($url, -1) === "/")
				$url = substr($url, 0, -1);
		}

		//If URL exists in routes array, call the action.
		array_walk($this->routes, function($route) use($url){
			if($url == $route['route'])
			{
				$class = "App\\Controllers\\" . $route['controller'];
				$action = $route['action'];
				$controller = new $class;
				$controller->{$route['action']}();
			}
		});
	}

	/*
	* Set routes in Init file and bring here to work on it.
	*/
	protected function setRoutes(array $routes)
	{
		$this->routes = $routes;
	}

	/*
	* Parse URL to use run function
	*/
	protected function getUrl()
	{
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}
}