<?php

namespace App\Models;
use EFW\DB\Table;

class Product extends Table
{
	//Table name in database
	protected $table = 'efw_produtos';
	//Table columns in database with : on begining to work
	protected $params = [':produto_nome', ':produto_preco', ':produto_desc'];
}