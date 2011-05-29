<?php

/**
* Debugging shortcut function
*
**/
function d($message)
{
    if (!is_string($message))
    {
        $message = print_r($message, true);
    }
    if ( class_exists("WebServer", false) )
    {
        WebServer::log($message);
    }
    else
    {
        error_log($message);
    }
}







