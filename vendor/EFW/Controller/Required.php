<?php

namespace EFW\Controller;
use \EFW\Redirect\Redirect;

class Required
{
	private $values;
	private $result;

	/*
	 * Only insert in database, for example, if all required fields are complete.
	 * @param array $required Form fields you want required.
	 */
	public function require(array $required, $destination = null)
	{
		$this->values = filter_input_array(INPUT_POST);
		$error = false;

		if($this->values){
			$this->setToNullUnusedValues();
			foreach ($required as $field) {
				if(empty($this->values[$field])){
					$error = true;
				}
			}
			if($error == true){
				  Redirect::redirect(null, 'Sucesso!');
			}
			else{
				$this->result = $this->values;
				if(Redirect::redirect($destination, 'Sucesso!')){
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