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
    WebServer::log($message);
}







