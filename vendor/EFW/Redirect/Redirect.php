<?php

namespace EFW\Redirect;

class Redirect
{
    /*
     * Function to redirect user after some action.
     * @param string $path Path to redirect user.
     * @param string $message Redirect and show message.
     */
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