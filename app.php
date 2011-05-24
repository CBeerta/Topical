<?php

/**
* Include our essentials
*
**/
require_once __DIR__.'/lib/limonade/lib/limonade.php';
require_once __DIR__.'/lib/idiorm/idiorm.php';
require_once __DIR__.'/lib/helpers.php';
require_once __DIR__.'/lib/markdown.php';

function configure() 
{
    ORM::configure('sqlite:'.__DIR__.'/data/planner.db');
    option('daystart_hour', 6);
    option('dayend_hour', 20);
}

/*
function not_found($errno, $errstr, $errfile=null, $errline=null)
{
    set('errno', $errno);
    set('errstr', $errstr);
    set('errfile', $errfile);
    set('errline', $errline);
    set('title', "{$errno} - {$errstr}");
    return html("404.html.php");
}
*/

function before()
{
}

/**
* Start Routing
*
**/ 
layout('base.html.php');

dispatch_get('/:day', 'main_index');
dispatch_post('/:day', 'main_post');

### Todo Stuff
dispatch_post('/todo_save', 'todo_save');
dispatch_post('/todo_load', 'todo_load');
dispatch_get('/todo_complete/:id', 'todo_complete');


run();


