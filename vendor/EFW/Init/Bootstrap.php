<?php

namespace EFW\Init;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("DB_HOST", "localhost");
define("DB_NAME", "igorsouz_site");
define("DB_LOGIN", "root");
define("DB_PASS", "root");
define("ADMIN_LEVEL", 3);
define("BASE_PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
define("BASE_VIEW", $_SERVER['DOCUMENT_ROOT'] . "/App/Views/");

abstract class Bootstrap
{
	private $routes;
	private $siteData;
	private $url;

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
		$this->url = $url;
		//Check if the URL ends with '/' and remove the character to works correctly!
		if(strlen($url) > 1){
			if(substr($url, -1) === "/")
				$url = substr($url, 0, -1);
		}
		
		//Variable to get URL ID, in case of delete and update function.
		$id = null;

		//If URL exists in routes array, call the controller action.
		if($this->response($url) === 200){
			array_walk($this->routes, function($route) use($url){
				//If exists word 'delete' in route array, execute this
				if(strpos($route['route'], 'delete') !== false ||
					strpos($route['route'], 'excluir') !== false ||
					strpos($route['route'], 'update') !== false ||
					strpos($route['route'], 'atualizar') !== false){
					//Get numbers in url and put in final route delete array
					$id = filter_var($url, FILTER_SANITIZE_NUMBER_INT);
					$route['route'] .= $id;
				}

				if($url === $route['route'])
				{
					//If exists a id in URL and in route, put this id in action parameter 
					if(!empty($id) && strpos($route['route'], $id) !== false){
						$class = "App\\Controllers\\" . $route['controller'];
						$controller = new $class;
						$controller->{$route['action']}((int)$id);
					}
					else{
						$class = "App\\Controllers\\" . $route['controller'];
						$controller = new $class;
						$controller->{$route['action']}();
					}
				}

				if(strpos($url, 'logout') !== false){
					session_start();
					session_destroy();
					// unset cookies
					if (isset($_SERVER['HTTP_COOKIE'])) {
					    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
					    foreach($cookies as $cookie) {
					        $parts = explode('=', $cookie);
					        $name = trim($parts[0]);
					        setcookie($name, '', time()-1000);
					        setcookie($name, '', time()-1000, '/');
					    }
					}
					header("Location: /");
				}
			});
		}
		else{
			header("Location: /404");
		}
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

	/*
	 * Check if URL exists in route array.
	 */
	private function response($url)
	{
		foreach ($this->routes as $route) {
			if($url === $route['route'] || $url === $route['route'] . filter_var($url, FILTER_SANITIZE_NUMBER_INT) || $url === '/admin/logout'){
				return 200;
				break;
			}
		}
	}
}