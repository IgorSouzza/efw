<?php

namespace EFW\Controller;

class Action
{
	protected $view;

	public function __construct()
	{
		$this->view = new \stdClass;
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