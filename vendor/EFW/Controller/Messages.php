<?php

namespace EFW\Controller;

class Messages
{
	public static function getSystemMessage()
	{
		if(!empty($_SESSION['message']))
			return $_SESSION['message'];
		else
			return "";
	}

	public static function setSuccessSystemMessage($message)
	{
		if(!empty($_SESSION['message']))
			return $_SESSION['message'];
		else
			return "";
	}
}