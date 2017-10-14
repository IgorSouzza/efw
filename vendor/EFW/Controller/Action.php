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
		
		//Twig global variables
		if(!empty($_SESSION['userlogin'])){
			//Admin
			$twig->addGlobal('nome', $_SESSION['userlogin']['user_name'] . " " . $_SESSION['userlogin']['user_lastname']);
			$twig->addGlobal('message', Messages::getSystemMessage());
			$twig->addGlobal('current_page', '');
		}
		//SEO
		$twig->addGlobal('page_title', Container::getPageValues('site_nome'));
		$twig->addGlobal('page_simple_desc', Container::getPageValues('site_descricao'));
		$twig->addGlobal('page_detail_desc', Container::getPageValues('site_descricao_detalhada'));
		$twig->addGlobal('page_facebook', Container::getPageValues('social_facebook'));
		$twig->addGlobal('page_googleplus', Container::getPageValues('social_googleplus'));
		$twig->addGlobal('page_twitter', Container::getPageValues('social_twitter'));

		//String handling
		$newStringView = str_replace(".", "/", $view);
		$newStringView .= '.html.twig';

		if(!empty($data))
			echo $twig->render($newStringView, $data);
		else
			echo $twig->render($newStringView, array('' => ''));
	}
}