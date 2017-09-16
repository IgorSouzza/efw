<?php

namespace App\Models;
use EFW\DB\Table;

class User extends Table
{
	//Table name in database
	protected $table = 'efw_usuarios';
	//Table columns in database with : on begining to work
	//protected $params = [':product_name', ':product_price', ':product_description'];
}