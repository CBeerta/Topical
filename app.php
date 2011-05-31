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
        'day_end_hour' => 16,
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
    
    /**
    * Create the Table should it not exist
    **/
    ORM::get_db()->query('
        CREATE TABLE IF NOT EXISTS "todo" (
            `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `added` datetime NOT NULL,
            `updated` datetime NOT NULL,
            `content` longtext,
            `completed` datetime DEFAULT NULL, 
            `order` int default 0);
        ');
}

function before() { }

/**
* Start Routing
*
**/ 
layout('base.html.php');

### Todo Stuff
dispatch_post('/todo/save', 'Task::save'); ## Save a Todo. This needs to DIAF
dispatch_post('/todo/sort', 'Task::sort'); ## jQuery Sortable Target for resorting
dispatch_post('/todo/load/:formatted', 'Task::load'); ## Load todo and return partial snippet
dispatch_post('/todo/complete', 'Task::complete', array('params' => array('action' => 'complete'))); ## Complete a Todo
dispatch_post('/todo/delete', 'Task::complete', array('params' => array('action' => 'delete'))); ## Delete a Todo

### Calendar Stuff
dispatch_get('/calendar/hours/:day', 'Calendar::hours');

### Help Slideout
dispatch_get('/help', 'Main::help');

### Index Page
dispatch_get('/:day', 'Main::index');


run();


