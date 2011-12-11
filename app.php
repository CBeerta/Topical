<?php
/**
* Topical - Topical is a Simple PHP Application to Plan your day-to-day activity. 
*
* PHP Version 5.3
*
* Copyright (C) 2011 by Claus Beerta <claus@beerta.de>
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
* @category Todo
* @package  Topical
* @author   Claus Beerta <claus@beerta.de>
* @license  http://www.opensource.org/licenses/mit-license.php MIT License
* @link     http://claus.beerta.de/
**/


/**
* Include our essentials
*
**/
require_once __DIR__.'/lib/limonade/lib/limonade.php';
require_once __DIR__.'/lib/idiorm/idiorm.php';
require_once __DIR__.'/lib/helpers.php';
require_once __DIR__.'/lib/markdown.php';

/**
* Limonade configure
*
* @return void
**/
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
    foreach ( $options as $k => $v ) {
        $v = isset($config[$k]) ? $config[$k] : $options[$k];
        option($k, $v);
    }

    ORM::configure('sqlite:' . option('dbfile'));
    
    /**
    * Create the Table should it not exist
    **/
    ORM::get_db()->query(
        '
        CREATE TABLE IF NOT EXISTS "todo" (
            `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `added` datetime NOT NULL,
            `updated` datetime NOT NULL,
            `content` longtext,
            `completed` datetime DEFAULT NULL, 
            `order` int default 0);
        '
    );
}

//function before() { }

/**
* Start Routing
*
**/ 
layout('base.html.php');

//# Todo Stuff
dispatch_post('/todo/save', 'Task::save'); // Save a Todo.
dispatch_post('/todo/sort', 'Task::sort'); // jQuery Sortable Target for resorting

// Load todo and return partial snippet
dispatch_post('/todo/load/:formatted', 'Task::load');

 // Complete a Todo
dispatch_post(
    '/todo/complete', 
    'Task::complete', 
    array('params' => array('action' => 'complete'))
);

// Delete a Todo
dispatch_post(
    '/todo/delete', 
    'Task::complete', 
    array('params' => array('action' => 'delete'))
);

//# Calendar Stuff
dispatch_get('/calendar/hours/:day', 'Calendar::hours');

//# Help Slideout
dispatch_get('/help', 'Main::help');

//# Index Page
dispatch_get('/:day', 'Main::index');

if ( file_exists(__DIR__.'/lib/lemons/lemon_server.php') ) {
    include_once __DIR__.'/lib/lemons/lemon_server.php';
}

run();

