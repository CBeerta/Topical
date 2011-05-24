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
    option('daystart_hour', 7);
    option('dayend_hour', 22);
    
    option('date_format', 'D, j M Y');
}

function before()
{
}

/**
* Start Routing
*
**/ 
layout('base.html.php');

### Todo Stuff
dispatch_post('/todo_save', 'todo_save');
dispatch_post('/todo_sort', 'todo_sort');
dispatch_post('/todo_load', 'todo_load');
dispatch_get('/todo_complete/:id', 'todo_complete');


### Index Page
dispatch_get('/:day', 'main_index');
dispatch_post('/:day', 'main_post');



run();


