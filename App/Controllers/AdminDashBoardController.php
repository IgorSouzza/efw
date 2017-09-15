<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\DI\Container;

class AdminDashBoardController extends Action
{
	public function index()
	{
		$this->render('Admin.dashboard');
	}
}