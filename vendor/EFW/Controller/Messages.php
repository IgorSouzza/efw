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
		}
		else{
			return $_SESSION['message'] = null;
		}
	}

	public static function setMessage(string $message, string $type = null)
	{
		if($type === 'SUCCESS' || $type === 'success')
			$_SESSION['message'] = "<div class='alert alert-success col-12' style='margin-bottom:0;'>{$message}</div>";
		elseif($type === 'DANGER' || $type === 'danger')
			$_SESSION['message'] = "<div class='alert alert-danger col-12' style='margin-bottom:0;'>{$message}</div>";
		elseif($type === 'INFO' || $type === 'info')
			$_SESSION['message'] = "<div class='alert alert-danger col-12' style='margin-bottom:0;'>{$message}</div>";
		elseif($type === 'WARNING' || $type === 'warning')
			$_SESSION['message'] = "<div class='alert alert-warning col-12' style='margin-bottom:0;'>{$message}</div>";
		else
			$_SESSION['message'] = "<div class='alert col-12' style='margin-bottom:0;'>{$message}</div>";
	}
}