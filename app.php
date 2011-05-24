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
dispatch_post('/todo_save', 'todo_save');
dispatch_post('/todo_sort', 'todo_sort');
dispatch_post('/todo_load', 'todo_load');
dispatch_get('/todo_complete/:id', 'todo_complete');

### Calendar Stuff
dispatch_get('/calendar_hours/:day', 'calendar_hours');


### Index Page
dispatch_get('/:day', 'main_index');
dispatch_post('/:day', 'main_post');



run();


