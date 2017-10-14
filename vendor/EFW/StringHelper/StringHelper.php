<?php

namespace EFW\StringHelper;

class StringHelper
{
    public static function checkFileName(string $name)
    {
        $name = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($name))));
        
        return $name;
    }

    public static function checkEmail(string $email)
    {

    }
}