<?php

namespace EFW\Redirect;
use \EFW\Controller\Messages;

class Redirect
{
    /*
     * Function to redirect user after some action.
     * @param string $path Path to redirect user.
     * @param string $message Redirect and show message.
     */
    public static function redirect(string $path = null, $message = null)
    {
        if(!empty($_SESSION['canRedirect']) && $_SESSION['canRedirect'] === false){
            unset($_SESSION['message']);
            return false;
        }
        else{
            Messages::setMessage($message, 'success');
            header("Location: {$path}");
            return true;
        }
    }
}