<?php

namespace EFW\Controller;

class Required
{
	private $values;
	private $result;

	/*
	 * Only insert in database, for example, if all required fields are complete.
	 * @param array $required Form fields you want required.
	 */
	public function require(array $required)
	{
		$this->values = filter_input_array(INPUT_POST);

		if($this->values){
			$this->setToNullUnusedValues();
			foreach ($required as $field) {
				if(empty($this->values[$field])){
					return false;
				}
				else{
					$this->result = $this->values;
					return true;
				}
			}
		}
	}

	/*
	* Replace empty string to null value
	*/
	private function setToNullUnusedValues()
	{
		foreach (array_keys($this->values) as $key) {
			if($this->values[$key] == '')
				$this->values[$key] = NULL;
			if($this->values[$key] == 'false')
				$this->values[$key] = 0;
			elseif($this->values[$key] == 'true')
				$this->values[$key] = 1;
		}
	}

	/*
	 * Return a $_POST with NULL values, no '' values.
	 */
	public function getResult(){
		return $this->result;
	}
}