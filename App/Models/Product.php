<?php

namespace App\Models;
use EFW\DB\Table;

class Product extends Table
{
	//Table name in database
	protected $table = 'efw_products';
	//Table columns in database with : on begining to work
	protected $params = [':product_name', ':product_price', ':product_description'];
}