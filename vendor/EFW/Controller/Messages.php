<?php

namespace EFW\Controller;

class Messages
{
	/*
	 *
	 */
	public static function getMessage()
	{
		if(!empty($_SESSION['message'])){
			return $_SESSION['message'];
			unset($_SESSION['message']);
		}
		else
			unset($_SESSION['message']);
	}

	public static function setMessage($message)
	{
		$_SESSION['message'] = $message;
	}
}