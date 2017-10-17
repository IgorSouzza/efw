<?php

namespace App;
use \EFW\Init\Bootstrap;

/*
* Class for register routes, controllers and actions.
* Routes = URL
* Controller = File in App/Controllers 
* Action = Method inside controller class.
*/
class Init extends Bootstrap
{
	protected function initRoutes()
	{
		$ar['home'] = array('route' => '/', 'controller' => 'HomeController', 'action' => 'index');
		$ar['portfolio'] = array('route' => '/portfolio', 'controller' => 'HomeController', 'action' => 'portfolio');
		$ar['notfound'] = array('route' => '/404', 'controller' => 'NotFound', 'action' => 'index');
		$ar['admin'] = array('route' => '/admin', 'controller' => 'LoginController', 'action' => 'index');
		$this->setRoutes($ar);
	}

	/*
	* Init new connection with Database using PDO.
	*/
	public static function getDb()
	{
		try{
			$db = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_LOGIN, DB_PASS);
			return $db;
		}catch(\PDOException $e){
			echo "Impossivel conectar com o banco de dados!";
		}
		
	}
}