<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\DI\Container;

class AdminLoginController extends Action
{
	protected $pageLevel;
	private $email;
	private $pass;
	private $level;
	private $result;

	public function index()
	{
		$this->render('Admin.login');
	}

	public function login(array $userData = null)
	{
		$this->email = (string) strip_tags(trim($userData['user']));
		$this->pass  = (string) strip_tags(trim($userData['pass']));
		$this->setLogin();
	}

	private function setLogin()
	{
		if(!$this->email || !$this->pass){
			echo '<div class="alert alert-info col-xs-3 col-xs-offset-1">Informe seu usuário e senha para efetuar o login!</div>';
			$this->result = false;
		}
		elseif(!$this->getUser()){
			echo '<div class="alert alert-danger col-xs-3 col-xs-offset-1">Usuário ou senha incorretos!</div>';
			$this->result = false;
		}
		elseif($this->result['user_level'] < 3){
			echo "<div class='alert alert-danger col-xs-3 col-xs-offset-1'>Desculpe, {$this->result['user_name']}. Você não tem permissão para acessar esta área!</div>";
			$this->result = false;
		}
		else
			$this->execute();
	}

	private function getUser()
	{
		#$this->pass = md5($this->pass);

		$user = Container::getClass("User");
		$this->result = $user->checkLogin($this->email, $this->pass);

		if($this->result)
			return true;
		else
			return false;
	}

	private function execute()
	{
		//se nao tiver nenhuma sessão criada, cria uma
		if(!session_id())
			session_start();
		//depois de logado, passa todos os dados da variavel result para a sessão
		$_SESSION['userlogin'] = $this->result;
		//limpa a variável da memoria
		$this->result = true;

		header("Location: /admin/dash");
	}
}