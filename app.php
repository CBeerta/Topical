<?php

require_once __DIR__.'/lib/limonade/lib/limonade.php';
require_once __DIR__.'/lib/helpers.php';
require_once __DIR__.'/lib/markdown.php';

function configure() 
{
    option('daystart_hour', 9);
    option('dayend_hour', 18);
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

layout('base.html.php');

dispatch_get('/', 'main_index');
dispatch_post('/', 'main_post');

### Todo Stuff
dispatch_post('/todo_save', 'todo_save');
dispatch_post('/todo_load', 'todo_load');
dispatch_get('/todo_complete/:id', 'todo_complete');


run();


