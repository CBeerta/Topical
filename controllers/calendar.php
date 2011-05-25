<?php

function _set_dates ( $day ) 
{
    try
    {
        $date = new DateTime($day);
        $yesterday = new DateTime($day);
        $tomorrow = new DateTime($day);
    
        $yesterday->sub(new DateInterval('P1D'));
        $tomorrow->add(new DateInterval('P1D'));
    }
    catch (Exception $e)
    {
        return;
    }
    set('date', $date->format(option('date_format')));
    set('today', $date->format('Y-m-d'));
    set('yesterday', $yesterday->format('Y-m-d'));
    set('tomorrow', $tomorrow->format('Y-m-d'));
    
    return;
}

function _calendar_index ( $day )
{
    _set_dates($day);
    set('hours', range(option('day_start_hour'), option('day_end_hour'), 1));

    return partial('calendar.html.php');
}

function calendar_hours ( $day ) 
{
    try
    {
        $date = new DateTime($day);
    }
    catch (Exception $e)
    {
        return json("FAIL");
    }
    
    _set_dates($day);
    
    $completed = ORM::for_table('todo')
        ->select_expr("STRFTIME('%H', `completed`, 'localtime')", 'hour')
        ->select('*')
        ->where_raw("DATE(`completed`) = ?", $date->format('Y-m-d'))
        ->find_many();

    $indexed_completed = array();
    foreach ($completed as $item)
    {
        $indexed_completed[$item->hour][] = array(
            'id' => $item->id,
            'content' => partial('task_snippet.html.php', array('content' => $item->content)),
            'hour' => $item->hour,
            );
    }
    $data = array (
        'items' => $indexed_completed, 
        'date' => $date->format(option('date_format')),
        'today' => set('today'),
        'tomorrow' => set('tomorrow'),
        'yesterday' => set('yesterday'),
        'day' => $date->format('Y-m-d'),
        );
        
    return json($data);
}
