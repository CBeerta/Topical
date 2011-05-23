<?php

function main_index()
{
    set ('title', 'Today');
    
    set('hours', array_fill(option('daystart_hour'), option('dayend_hour'), 1));
    
    set('todo', array(
            'todo_1' => 'some test todo',
            'todo_2' => 'another one',
            'todo_3' => 'aaaand yet another one',
        ));
    

    set('todolist', partial('todolist.html.php'));
    set('calendar', partial('calendar.html.php'));
    
    return html('main.html.php');
}



function main_post()
{
    $valid_functions = array('todo_save');
    
    if ( isset($_POST['function']) && in_array($_POST['function'], $valid_functions) )
    {
        # FIXME: is this save and all?
        # Should be, with the valid functions checks
        $_POST['function']();
    }

    return main_index();
}
