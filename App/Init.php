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
	private $urlDbRows;
	protected function initRoutes()
	{
		/*INSTITUCIONAL*/
		$ar['home'] = array('route' => '/', 'controller' => 'HomeController', 'action' => 'index');
		$ar['portfolio'] = array('route' => '/portfolio', 'controller' => 'HomeController', 'action' => 'portfolio');
		$ar['blog'] = array('route' => '/blog', 'controller' => 'BlogController', 'action' => 'index');
		$ar['notfound'] = array('route' => '/404', 'controller' => 'NotFound', 'action' => 'index');

		/*ADMIN*/
		$ar['admin'] = array('route' => '/admin', 'controller' => 'AdminLoginController', 'action' => 'index');
		$ar['admin/dash'] = array('route' => '/admin/dash', 'controller' => 'AdminDashController', 'action' => 'index');
		$ar['admin/seo'] = array('route' => '/admin/seo', 'controller' => 'AdminInstitucionalController', 'action' => 'seo');

		/*ADMIN INSTITUCIONAL*/
		$ar['admin/institucional'] = array('route' => '/admin/institucional', 'controller' => 'AdminInstitucionalController', 'action' => 'index');
		$ar['admin/institucional/atualizar'] = array('route' => '/admin/institucional/atualizar/', 'controller' => 'AdminInstitucionalController', 'action' => 'update');

		/*ADMIN CLIENTES*/
		$ar['admin/clientes'] = array('route' => '/admin/clientes', 'controller' => 'AdminClientesController', 'action' => 'index');
		$ar['admin/clientes/adicionar'] = array('route' => '/admin/clientes/adicionar', 'controller' => 'AdminClientesController', 'action' => 'create');
		$ar['admin/clientes/atualizar'] = array('route' => '/admin/clientes/atualizar/', 'controller' => 'AdminClientesController', 'action' => 'update');
		$ar['admin/clientes/excluir'] = array('route' => '/admin/clientes/excluir/', 'controller' => 'AdminClientesController', 'action' => 'delete');

		/*ADMIN LOGS*/
		$ar['admin/logs-acesso'] = array('route' => '/admin/logs-painel', 'controller' => 'AdminLogsController', 'action' => 'painel');
		$ar['admin/logs-login'] = array('route' => '/admin/logs-login', 'controller' => 'AdminLogsController', 'action' => 'login');
		
		/*ADMIN BLOG*/
		$ar['admin/dashblog'] = array('route' => '/admin/dashblog', 'controller' => 'AdminBlogController', 'action' => 'index');
		$ar['admin/dashblog/adicionar'] = array('route' => '/admin/dashblog/adicionar', 'controller' => 'AdminBlogController', 'action' => 'create');
		$ar['admin/dashblog/atualizar'] = array('route' => '/admin/dashblog/atualizar/', 'controller' => 'AdminBlogController', 'action' => 'update');
		$ar['admin/dashblog/excluir'] = array('route' => '/admin/dashblog/excluir/', 'controller' => 'AdminBlogController', 'action' => 'delete');

		//Get dynamics url's from post db
		foreach ($this->getDbRoutes() as $key) {
			$teste = array_values($key)[0];
			$ar['blog/' . $teste] = array('route' => '/blog/' . $teste, 'controller' => 'BlogController', 'action' => 'readPost');

		}

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

	private function getDbRoutes()
	{
		$stmt = self::getDb()->prepare("SELECT post_url FROM blog_posts");
		$stmt->execute();

		$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $res;
	}
}