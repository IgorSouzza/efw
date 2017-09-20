<?php

namespace App\Controllers;
use \EFW\Controller\Action;
use \EFW\DI\Container;
use \EFW\Auth\Auth;

class AdminProdutosController extends Action
{
	public function __construct()
	{
		parent::__construct();
		Auth::authCheck();
	}

	public function index()
	{
		$prod = Container::getClass("Product");
		$prods = $prod->fetchAll();
		
		$this->render('Admin.produtos', array("prods" => $prods));
	}

	public function create()
	{
		$this->render('Admin.produtos-create');
		if(!empty($_POST)){
			$produto = Container::getClass("Product");
			$this->view->insertProduct = filter_input_array(INPUT_POST);
			$produto->insert($this->view->insertProduct);
			echo "cadastrou";
        }
	}

	public function delete($id)
	{	
		$prod = Container::getClass("Product");
		$prod->delete($id);
	}
}