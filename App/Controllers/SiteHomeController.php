<?php

namespace App\Controllers;
use EFW\Controller\Action;

class SiteHomeController extends Action
{
	public function index()
	{
		$this->render('index');
	}
}