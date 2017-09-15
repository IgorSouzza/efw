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
		$ar['home']      = array('route' => '/', 'controller' => 'SiteHomeController', 'action' => 'index');
		$ar['admin']     = array('route' => '/admin', 'controller' => 'AdminLoginController', 'action' => 'index');
		$ar['admin_dash']  = array('route' => '/admin/dash', 'controller' => 'AdminDashBoardController', 'action' => 'index');
		$this->setRoutes($ar);
	}

	/*
	* Init new connection with Database using PDO.
	*/
	public static function getDb()
	{
		$db = new \PDO("mysql:host=localhost;dbname=efw;", "root", "root");
		return $db;
	}
}