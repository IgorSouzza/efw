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
	* This function get class action and execute in view.
	*/
	public function render($view)
	{
		$viewStr = str_replace(".", "/", $view);
		$path = '../App/Views/' . $viewStr . '.phtml';

		if(file_exists($path))
			include_once $path;
		else
			echo "View not found!";
	}
}