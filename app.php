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
    /**
    * Options with defaults, overridable in config.ini
    **/
    $options = array (
        'dbfile' => './data/planner.db',
        'day_start_hour' => 7,
        'day_end_hour' => 20,
        'date_format' => 'D, j M Y',
        );

    /**
    * Load config file and override default options
    **/    
    $config = parse_ini_file(__DIR__."/config.ini");
    foreach ( $options as $k => $v )
    {
        $v = isset($config[$k]) ? $config[$k] : $options[$k];
        option ($k, $v);
    }
    
    ORM::configure('sqlite:' . option('dbfile'));
}

function before() { }

/**
* Start Routing
*
**/ 
layout('base.html.php');

### Todo Stuff
dispatch_post('/todo_save', 'todo_save'); ## Save a Todo. This needs to DIAF
dispatch_post('/todo_sort', 'todo_sort'); ## jQuery Sortable Target for resorting
dispatch_post('/todo_load/:formatted', 'todo_load'); ## Load todo and return partial snippet
dispatch_get('/todo_complete/:id', 'todo_complete'); ## Complete a Todo
dispatch_get('/todo_delete/:id', 'todo_delete'); ## Delete a Todo

### Calendar Stuff
dispatch_get('/calendar_hours/:day', 'calendar_hours');

### Index Page
dispatch_get('/:day', 'main_index');


run();


