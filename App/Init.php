<?php

namespace App;
use \EFW\Init\Bootstrap;

class Init extends Bootstrap
{
	/*
	* Class for register routes, controllers and actions.
	* Routes = URL
	* Controller = File in App/Controllers 
	* Action = Method inside controller class.
	*/
	protected function initRoutes()
	{
		$ar['home'] = array('route' => '/', 'controller' => 'HomeController', 'action' => 'index');
		$this->setRoutes($ar);
	}

	/*
	* Init new connection with Database using PDO.
	*/
	public static function getDb()
	{
		$db = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_LOGIN, DB_PASS);
		return $db;
	}
}