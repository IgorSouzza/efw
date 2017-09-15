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
			$sql = "INSERT INTO efw_products ({$str}) VALUES ({$str2})";
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

		$res = $stmt->fetch();
		return $res;
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
}