<?php

namespace EFW\Controller;
use EFW\Controller\Messages;
use EFW\DI\Container;

class Action
{
	protected $view;

	public function __construct()
	{
		$this->view = new \stdClass;
		session_start();
	}

	/*
	* Call Twig Engine loader and return the view
	*/
	public function render(string $view, array $data = null)
	{
		$loader = new \Twig_Loader_Filesystem(BASE_VIEW);
		$twig = new \Twig_Environment($loader);
		
		//Session global variables
		if(!empty($_SESSION['userlogin'])){
			$twig->addGlobal('nome', $_SESSION['userlogin']['user_name'] . " " . $_SESSION['userlogin']['user_lastname']);
			$twig->addGlobal('message', Messages::getSystemMessage());
		}

		//String handling
		$newStringView = str_replace(".", "/", $view);
		$newStringView .= '.html.twig';

		if(!empty($data))
			echo $twig->render($newStringView, $data);
		else
			echo $twig->render($newStringView, array('' => ''));
	}
}