<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\DI\Container;

class AdminLoginController extends Action
{
	public function index()
	{
		$produto = Container::getClass("Product");
		//$produto->insert($_POST);
		$this->render('Admin.login');
	}
}