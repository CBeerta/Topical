<?php

function todo_save()
{
    WebServer::log(print_r($_POST,true));
    
    if ( !isset($_POST['value']) ) return;

    if (!isset($_POST['id']) || empty($_POST['id']))
    {
        # new todo
    }
    else
    {
        # edit existing
    }
    
    
    return partial($_POST['value']);
}

function todo_load()
{
    if (!isset($_POST['id']) || empty($_POST['id']))
    {
        return;
    }
    
    return json("blahfasel");
}

function todo_complete()
{
    

    return json("ok");
}
