<?php

namespace App\Controllers;
use EFW\Controller\Action;

class HomeController extends Action
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->render("index", array('name' => 'friend'));
	}
}