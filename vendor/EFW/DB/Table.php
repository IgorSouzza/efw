<?php

namespace EFW\DB;
use \EFW\Auth\Bcrypt;

abstract class Table
{
	//Variable to database connection
	protected $db;
	//Database name
	protected $table;
	//Database columns with same name and : on word start
	protected $params;

	public function __construct(\PDO $db)
	{
		$this->db = $db;
	}

	/*
	* @param array $values Array in exacly order of your database,
	* if you dont respect the order, insert dont work.
	* This method trata every string and array to mount
	* a correctly query.
	*/
	public function insert(array $values, string $columUnique = null)
	{
		$row = 0;

		if(!empty($columUnique)){
			$url = $values["{$columUnique}"];
			$query = "SELECT * FROM {$this->table} WHERE post_url = :url";
			$st = $this->db->prepare($query);
			$st->bindParam(':url', $url);
			$st->execute();
			$row = $st->rowCount();
		}
		else{
			$row = 0;
		}

		if($row < 1){
			$str = str_replace(":", "", implode(',',$this->params));
			$str2 = implode(",", $this->params);
			$finalValues = array_values($values);
			$sql = "INSERT INTO {$this->table} ({$str}) VALUES ({$str2})";
			$stmt = $this->db->prepare($sql);
			foreach ($this->params as $i => $param) {
				$stmt->bindParam($param, $finalValues[$i]);
			}
			$stmt->execute();
			return true;
		}
		else{
			return false;
		}
	}

	public function addPageView($colum, $value, $url)
	{
		$sql = "UPDATE {$this->table} SET {$colum} = :value WHERE post_url = :url";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':value', $value);
		$stmt->bindParam(':url', $url);
		$stmt->execute();
		return true;
	}

	/**
	 * Return all values from table, in desc.
	 * @param  bool        $paginate if true, return with paginate logic
	 * @param  int         $limit items per page
	 * @param  string|null $colum    Database colum to compare with $word paramter
	 * @param  string|null $word     Word to compare, if exists, return all values with this word
	 * @return PDO                
	 */
	public function fetchAll(bool $paginate, int $limit = 10, string $colum = null, string $word = null)
	{
		if($paginate === false){
			if($word == null || $colum == null){
				return $this->fetchWithoutPaginate("SELECT * FROM {$this->table}");
			}
			else{
				return $this->fetchWithoutPaginate("SELECT * FROM {$this->table} WHERE {$colum} LIKE '%{$word}%'");
			}
		}
		else{
			if($word == null || $colum == null){
				return $this->fetchWithPaginate("SELECT * FROM {$this->table}", $limit);
			}
			else{
				return $this->fetchWithPaginate("SELECT * FROM {$this->table} WHERE {$colum} LIKE '%{$word}%'", $limit, $colum,$word);
			}
		}
	}

	/*
	 * Find a value from DB
	 */
	public function find(int $id)
	{
		$stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$res = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $res;
	}

	/*
	 * Find a value from DB
	 */
	public function findUrl(string $url)
	{
		$stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE post_url = :url");
		$stmt->bindParam(":url", $url);
		$stmt->execute();

		$res = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $res;
	}

	/*
	 * Find a value from DB
	 */
	public function findRelated(string $cat)
	{
		$stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE post_category = :cat");
		$stmt->bindParam(":cat", $cat);
		$stmt->execute();

		$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $res;
	}

	/*
	 * Find a value from DB
	 */
	public function findView()
	{
		$stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY post_pageview DESC LIMIT 3");
		$stmt->execute();

		$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $res;
	}

	/*
	 * Update a table from DB.
	 * @param int $id entity id
	 * @param array $values values to be updated.
	 */
	public function update(int $id, array $values)
	{
		//String handle to build a flexible query.
		$binds = array_keys($values);
		$dbParams = str_replace(":", "", array_values($this->params));
		$finalSetValues = null;
		for ($i=0; $i < count($values); $i++) { 
			$finalSetValues .= "," . $dbParams[$i] . "=:" . $binds[$i];
		}
		$finalQuerySetValues = ltrim($finalSetValues, ",");
		$finalValues = array_values($values);

		//PDO
		$sql = "UPDATE {$this->table} SET {$finalQuerySetValues} WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":id", $id);
		foreach ($binds as $i => $bind) {
			$stmt->bindParam(":".$bind, $finalValues[$i]);
		}
		$stmt->execute();
		return true;
	}

	public function updateSingle(string $page, $colum, $value)
	{
		$sql = "UPDATE {$this->table} SET {$colum} = :value WHERE page = :page";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":page", $page);
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		return true;
	}

	/*
	 * Delete a value from DB.
	 * @param int $id entity id
	 */
	public function delete(int $id)
	{
		$sql = "DELETE FROM {$this->table} WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();
	}

	/*
	 * Check if entered user and pass matches with Database.
	 * Class used in Login Controller.
	 * @param string $user form informed user, to check in DB.
	 * @param string $pass form informed pass, to check in DB.
	 */
	public function checkLogin(string $user, string $pass)
	{
		$stmt = $this->db->prepare("SELECT user_pass FROM {$this->table} WHERE user_email = :email");
		$stmt->bindParam(":email", $user);
		$stmt->execute();
		$hash = $stmt->fetch(\PDO::FETCH_ASSOC)['user_pass'];

		//60 is the crypt password lenght
		if(strlen($pass) != 60)
		{
			if(Bcrypt::check($pass, $hash))
			{
				$stmt2 = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_email = :email AND user_pass = :pass");
				$stmt2->bindParam(":email", $user);
				$stmt2->bindParam(":pass", $hash);
				$stmt2->execute();
				$res = $stmt2->fetch(\PDO::FETCH_ASSOC);
				return $res;
			} 
			else 
			{
				return null;
			}
		}
		elseif(!empty($_COOKIE['is_l']) && strlen($pass) == 60)
		{
			$stmt2 = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_email = :email AND user_pass = :pass");
			$stmt2->bindParam(":email", $user);
			$stmt2->bindParam(":pass", $pass);
			$stmt2->execute();
			$res = $stmt2->fetch(\PDO::FETCH_ASSOC);
			return $res;
		}
		
	}

	/*
	 * Function to get user level mainly. But it can be used to get other values.
	 * You need to pass user and pass to get value.
	 */
	public function getValueFromDb(string $value, string $user, string $pass)
	{
		$stmt = $this->db->prepare("SELECT {$value} FROM {$this->table} WHERE user_email = :email AND user_pass = :pass");
		$stmt->bindParam(":email", $user);
		$stmt->bindParam(":pass", $pass);
		$stmt->execute();

		$res = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $res;
	}

	private function fetchWithoutPaginate(string $query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $res;
	}

	private function fetchWithPaginate(string $query, int $limit, string $colum = null, string $word = null)
	{
		if($colum == null || $word == null)
			$stmt = $this->db->prepare($query);
		else
			$stmt = $this->db->prepare($query);

		$stmt->execute();
		$total = $stmt->rowCount();
		$pages = ceil($total / $limit);
		
		// What page are we currently on?
	    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
	        'options' => array(
	            'default'   => 1,
	            'min_range' => 1,
	        ),
	    )));

	    // Calculate the offset for the query
	    $offset = ($page - 1)  * $limit;

	    // Some information to display to the user
	    $start = $offset + 1;
	    $end = min(($offset + $limit), $total);

	    // The "back" link
	    $prevlink = ($page > 1) ? "<li class='page-item'><a class='page-link' href='?page=" . ($page-1) . "' tabindex='-1'>Anterior</a></li>" : "<li class='page-item disabled'><a class='page-link' href='#' style='color: #3d3d3d !important;' tabindex='-1'>Anterior</a></li>";

	    // The "forward" link
	    $nextlink = ($page < $pages) ? "<li class='page-item'>
	          <a class='page-link' href='?page=" . ($page + 1) . "'>Próxima</a>
	        </li>" : "<li class='page-item disabled'><a class='page-link' style='color: #3d3d3d !important;' href='#'>Próxima</a></li>";

	    // Display the paging information
	    $_SESSION['paginator'] = "
	    <nav aria-label='Page navigation example'>
	      <ul class='pagination justify-content-center'>
	        {$prevlink}
	        Página {$page} de {$pages}
	        {$nextlink}
	      </ul>
	    </nav>
	    ";

	    // Prepare the paged query
	    $stmt = $this->db->prepare($query . " ORDER BY id DESC LIMIT :limit OFFSET :offset");

	    // Bind the query params
	    $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
	    $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
	    $stmt->execute();

	    // Do we have any results?
	    if ($stmt->rowCount() > 0) {
	        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $res;
	    } 
	    else {
	        return null;
	    }
	}
}