<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\Email\SendEmail;
use \EFW\DI\Container;

class HomeController extends Action
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if(!empty($_POST['BTEnvia'])){
			$email = new SendEmail;
			$email->send();
		}
		
		Container::addView('home');
		$this->render("Institucional.index", null, 'home');
	}

	public function portfolio()
	{
		Container::addView('portfolio');
		$this->render("Institucional.portfolio", null, 'portfolio');
	}
}