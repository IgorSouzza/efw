<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\DI\Container;
use \EFW\Auth\Auth;

class AdminDashBoardController extends Action
{
	public function __construct()
	{
		parent::__construct();
		Auth::authCheck();
	}
	
	public function index()
	{
		$u = Container::getClass("User");
		$user = $u->find(Auth::getId());

		$this->render("Admin.dashboard", array("nome" => $user));
	}
}