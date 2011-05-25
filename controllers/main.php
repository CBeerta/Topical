<?php

/**
* Builds the main index page from the initial load.
* 
*
**/
function main_index( $day )
{
    $day = $day ? $day : date('Y-m-d');
    set('day', $day);

    set('todolist', _todo_index($day));
    set('calendar', _calendar_index($day));

    return html('main.html.php');
}



