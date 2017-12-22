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
	
	public static function getPageValues(string $index)
	{
		$values = new \App\Models\SiteBase(\App\Init::getDb());
		$valuesFinal = $values->getSiteValues();
		if(array_key_exists($index, $valuesFinal))
			return $valuesFinal[$index];
		else
			return NULL;
	}

	/**
	 * Save log in Database
	 * @param  string $type    Type of log, for example: Admin.
	 * @param  string $message Message of log
	 */
	public static function saveLog(string $type, string $message)
	{
		if(isset($_SESSION['userlogin']))
			$fullname = $_SESSION['userlogin']['user_name'] . " " . $_SESSION['userlogin']['user_lastname'];
		else
			$fullname = "N/A";

		//Change INPUT_SERVER to INPUT_ENV in production
		$class = self::getClass('Log');
		$class->insert(array(
			filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP), 
			filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT), 
			filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_DEFAULT), 
			$type,
			$message, 
			$fullname
		));
	}

	public static function addView(string $page)
	{
		$class = self::getClass('SeoPage');
		
		foreach ($class->fetchAll(false) as $key) {
			if($page == $key['page'])
				$class->updateSingle($page, 'page_views', $key['page_views'] + 1);
		}
	}
}