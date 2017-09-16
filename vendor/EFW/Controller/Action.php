<?php

namespace EFW\Controller;

class Action
{
	protected $view;
	protected $pageLevel;

	public function __construct()
	{
		$this->view = new \stdClass;
	}

	/*
	* This function get class action and execute in view.
	*/
	public function render($view)
	{		
		session_start();
		$viewStr = str_replace(".", "/", $view);
		$path = '../App/Views/' . $viewStr . '.phtml';

		if(file_exists($path))
			include_once $path;
		else
			echo "View not found!";
	}

	public function checkPermission($level)
	{
		if($level){
			if($level['userlogin']['user_level'] >= 3)
				echo "Tem permissão";
			else
				die("Acesso negado.");
		}
		else
			die("Acesso negado.");
	}
}