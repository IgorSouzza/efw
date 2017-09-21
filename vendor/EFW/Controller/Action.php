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

		//String handling
		$newStringView = str_replace(".", "/", $view);
		$newStringView .= '.html.twig';

		if(!empty($data))
			echo $twig->render($newStringView, $data);
		else
			echo $twig->render($newStringView, array('' => ''));
	}
}