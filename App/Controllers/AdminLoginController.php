<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\Controller\Messages;
use \EFW\DI\Container;

class AdminLoginController extends Action
{
	private $email;
	private $pass;
	private $result;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->render('Admin.login');
		$this->checkLogin();
	}

	public function login(array $userData = null)
	{
		$this->email = (string) strip_tags(trim($userData['user']));
		$this->pass  = (string) strip_tags(trim($userData['pass']));
		$this->setLogin();
	}

	/*
	* Check if user put email and password or user typed the user/pass correct.
	* If yes, call execute() function.
	*/
	private function setLogin()
	{
		if(!$this->email || !$this->pass){
			echo '<div class="alert alert-info col-xs-3 col-xs-offset-1">Informe seu usuário e senha para efetuar o login!</div>';
			$this->result = false;
		}
		elseif(!$this->getUser()){
			echo "<div class='alert alert-danger col-xs-3 col-xs-offset-1'>Usuário ou senha incorretos!</div>";
			$this->result = false;
		}
		elseif($this->result['user_level'] < ADMIN_LEVEL){
			echo "<div class='alert alert-danger col-xs-3 col-xs-offset-1'>Desculpe, {$this->result['user_name']}. Você não tem permissão para acessar esta área!</div>";
			$this->result = false;
		}
		else
			$this->execute();
	}

	/*
	* Call model function checklogin to authenticate login and password.
	*/
	private function getUser()
	{
		$this->pass = md5($this->pass);

		$user = Container::getClass("User");
		$this->result = $user->checkLogin($this->email, $this->pass);

		if($this->result)
			return true;
		else
			return false;
	}

	private function execute()
	{
		//if do not have any session created, create a session
		if(!session_id())
			session_start();
		//after logging in, transfers all data from the variable result to the session
		$_SESSION['userlogin'] = $this->result;
		//clear variable from memory
		$this->result = true;
		//redirect to admin panel
		header("Location: /admin/dash");
	}

	/*
	* Check if user is already logged-in, case yes, redirect to admin panel
	*/
	public function checkLogin()
	{
		if(empty($_SESSION['userlogin']) && !empty($_POST))
			$this->login(filter_input_array(INPUT_POST));
		elseif(!empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_level'] >= 3)
			header("Location: /admin/dash");
	}
}