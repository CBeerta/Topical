<?php

class Main
{
    /**
    * Builds the main index page from the initial load.
    **/
    public static function index( $day )
    {
        $day = $day ? $day : date('Y-m-d');
        set('day', $day);

        set('todolist', Task::index($day));
        set('calendar', Calendar::index($day));

        return html('main.html.php');
    }

    /**
    * Builds the main index page from the initial load.
    **/
    public static function help()
    {
        return partial("snippets/help.html.php");
    }


}
