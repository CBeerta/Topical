<?php

function main_index( $day )
{
    $day = $day ? $day : date('Y-m-d');
    
    set('yesterday', 'Yesterday');
    set('tomorrow', 'Tomorrow');

    set ('title', 'Today');
    set ('day', $day);
    
    set('hours', range(option('daystart_hour'), option('dayend_hour'), 1));
    
    $todo = ORM::for_table('todo')
        ->where_raw("`completed` IS NULL")
        ->find_many();
    set('todo', $todo);
    
    $completed = ORM::for_table('todo')
        ->select_expr("STRFTIME('%H', `completed`, 'localtime')", 'hour')
        ->select('*')
        ->where_raw("DATE(`completed`) = ?", array($day))
        ->find_many();

    $indexed_completed = array();
    foreach ($completed as $item)
    {
        $indexed_completed[$item->hour][] = (object) array(
            'id' => $item->id,
            'content' => $item->content,
            'hour' => $item->hour,
            );
    }
        
    set('completed', $indexed_completed);
    

    set('todolist', partial('todolist.html.php'));
    set('calendar', partial('calendar.html.php'));
    
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
