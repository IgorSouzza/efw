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
		$this->render('Admin.dashboard');
	}
}