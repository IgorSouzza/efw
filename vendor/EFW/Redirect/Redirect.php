<?php

namespace EFW\Redirect;

class Redirect
{
    public static function canRedirect(string $path = null, $message = null)
    {
        if($_SESSION['canRedirect'] === false){
            return false;
        }
        else{
            header("Location: {$path}");
            return true;
        }
    }
}