<?php

namespace EFW\DB;

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
	* @Values array in exacly order of your database,
	* if you dont respect the order, insert dont work.
	* This method trata every string and array to mount
	* a correctly query.
	*/
	public function insert(array $values)
	{
		try {
			$str = str_replace(":", "", implode(',',$this->params));
			$str2 = implode(",", $this->params);
			$finalValues = array_values($values);
			$sql = "INSERT INTO {$this->table} ({$str}) VALUES ({$str2})";
			$stmt = $this->db->prepare($sql);
			foreach ($this->params as $i => $param) {
				$stmt->bindParam($param, $finalValues[$i]);
			}
			$stmt->execute();
		} catch (\PDOException $e) {
			echo $e;
		}
		
	}

	/*
	* Return every value from table.
	*/
	public function fetchAll()
	{
		$query = "SELECT * FROM {$this->table}";
		return $this->db->query($query);
	}

	/*
	* Find a value from DB
	*/
	public function find($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$res = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $res;
	}

	/*
	* Update a value from DB.
	*/
	public function update($id, array $values)
	{
		//String handle to build a flexible query.
		$binds = array_keys($values);
		$dbParams = str_replace(":", "", array_values($this->params));
		$finalSetValues = null;
		for ($i=0; $i < 3; $i++) { 
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
	}

	/*
	* Delete a value from DB.
	*/
	public function delete($id)
	{
		$sql = "DELETE FROM {$this->table} WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();
	}

	/*
	* Check if entered user and pass matches with Database
	*/
	public function checkLogin(string $user, string $pass)
	{
		$stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_email = :email AND user_pass = :pass");
		$stmt->bindParam(":email", $user);
		$stmt->bindParam(":pass", $pass);
		$stmt->execute();

		$res = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $res;
	}

	/*
	* Function to get user level mainly. But it can be used to get other values
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
}