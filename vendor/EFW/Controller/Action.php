<?php

namespace EFW\Controller;
use EFW\Controller\Messages;
use EFW\DI\Container;

class Action
{
	public function __construct()
	{
		session_start();
	}

	/*
	 * Call Twig Engine loader and return the view.
	 * @param string $view path to .html.twig view file.
	 * @param array $data values to send to view.
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
		$twig->addGlobal('title', SITE_INFO['title']);
		$twig->addGlobal('title_port', SITE_INFO['title_port']);
		$twig->addGlobal('site_name', SITE_INFO['site_name']);
		$twig->addGlobal('site_desc', SITE_INFO['site_desc']);
		$twig->addGlobal('logo', SITE_INFO['logo']);
		$twig->addGlobal('logo2', SITE_INFO['logo2']);
		$twig->addGlobal('url', SITE_INFO['url']);
		$twig->addGlobal('google_author', SITE_INFO['google_author']);
		$twig->addGlobal('google_publisher', SITE_INFO['google_publisher']);
		$twig->addGlobal('fb_app', SITE_INFO['fb_app']);
		$twig->addGlobal('fb_author', SITE_INFO['fb_author']);
		$twig->addGlobal('fb_publisher', SITE_INFO['fb_publisher']);

		//String handling
		$newStringView = str_replace(".", "/", $view);
		$newStringView .= '.html.twig';

		if(!empty($data))
			echo $twig->render($newStringView, $data);
		else
			echo $twig->render($newStringView, array('' => ''));
	}
}