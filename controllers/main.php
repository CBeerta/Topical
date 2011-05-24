<?php

function main_index( $day )
{
    $day = $day ? $day : date('Y-m-d');
    set('day', $day);

    set('todolist', _todo_index($day));
    set('calendar', _calendar_index($day));

    return html('main.html.php');
}



function main_post( $day )
{
    $day = $day ? $day : '';

    $valid_functions = array('todo_save');
    
    if ( isset($_POST['function']) && in_array($_POST['function'], $valid_functions) )
    {
        # FIXME: is this save and all?
        # Should be, with the valid functions checks
        $_POST['function']();
    }

    return redirect('/' . $day);
}




