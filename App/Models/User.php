<?php

namespace App\Models;
use EFW\DB\Table;

class User extends Table
{
	//Table name in database
	protected $table = 'efw_users';
	//Table columns in database with : on begining to work
	protected $params = [':user_email', ':user_pass', ':user_name'];
}