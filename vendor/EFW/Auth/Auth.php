<?php

namespace EFW\Auth;
use EFW\DI\Container;

class Auth
{
	/*
	* Check if user have level to access the page.
	*/
	public static function authCheck()
	{
		if(!empty($_SESSION['userlogin'])){
			$user = Container::getClass("User");
			$level = $user->getValueFromDb("user_level", $_SESSION['userlogin']['user_email'], $_SESSION['userlogin']['user_pass']);
			if($level >= ADMIN_LEVEL)
				return;
			else
				die("Acesso negado");
		}
		else{
			die("<b>Acesso negado!</b> Faça login para acessar!");
		}
	}

	public static function getId()
	{
		if(!empty($_SESSION['userlogin'])){
			$user = Container::getClass("User");
			$id = $user->getValueFromDb("id", $_SESSION['userlogin']['user_email'], $_SESSION['userlogin']['user_pass']);

			return $id['id'];
		}
	}
}