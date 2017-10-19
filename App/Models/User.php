<?php

namespace App\Models;
use EFW\DB\Table;

class User extends Table
{
	//Table name in database
	protected $table = 'site_users';
	protected $params = [':user_email', ':user_pass', ':user_level'];	
}