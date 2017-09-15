<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\DI\Container;

class AdminProdutosController extends Action
{
	public function index()
	{
		$this->render('Admin.produtos');
	}

	public function create()
	{
		$produto = Container::getClass("Product");
		if(!empty($_POST)){
			$this->view->cadastraProduto = filter_input_array(INPUT_POST);
			$produto->insert($this->view->cadastraProduto);
			echo "cadastrou";
		}
		$this->render('Admin.produtos-create');
	}
}