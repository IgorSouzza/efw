<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\Email\SendEmail;

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
		$this->render("index");
	}

	public function portfolio()
	{
		$this->render("portfolio");
	}
}