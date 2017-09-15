<?php

namespace EFW\DI;

class Container
{
	/*
	* Dependency Injection. Helper to instantiate a model Class. 
	*/
	public static function getClass($name)
	{
		$str_class = "\\App\\Models\\" . ucfirst($name);
		$class = new $str_class(\App\Init::getDb());
		return $class;
	}
}