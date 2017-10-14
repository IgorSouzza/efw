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
		$ar['admin'] = array('route' => '/admin', 'controller' => 'AdminLoginController', 'action' => 'index');
		$ar['admin-dash'] = array('route' => '/admin/dash', 'controller' => 'AdminDashBoardController', 'action' => 'index');
		$ar['admin-dash-produtos'] = array('route' => '/admin/dash/produtos', 'controller' => 'AdminProdutosController', 'action' => 'index');
		$ar['admin-dash-produtos-create'] = array('route' => '/admin/dash/produtos/create', 'controller' => 'AdminProdutosController', 'action' => 'create');
		$ar['admin-dash-produtos-delete'] = array('route' => '/admin/dash/produtos/delete/', 'controller' => 'AdminProdutosController', 'action' => 'delete');
		$ar['admin-dash-produtos-update'] = array('route' => '/admin/dash/produtos/update/', 'controller' => 'AdminProdutosController', 'action' => 'update');
		$ar['admin-dash-settings'] = array('route' => '/admin/dash/settings', 'controller' => 'AdminSettingsController', 'action' => 'index');
		$ar['admin-dash-settings-seo'] = array('route' => '/admin/dash/settings-seo', 'controller' => 'AdminSettingsController', 'action' => 'indexSEO');
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