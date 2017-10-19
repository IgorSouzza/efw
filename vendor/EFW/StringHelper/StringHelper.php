<?php

namespace EFW\StringHelper;

class StringHelper
{
	/*
	 * Function used in Upload class.
	 * Replace bad characters from file name.
	 * @param string $name name of the file.
	 */
    public static function checkFileName(string $name)
    {
        $name = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($name))));
        
        return $name;
    }

    public static function checkEmail(string $email)
    {

    }
}