<?php

function _calendar_index ( $day )
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
        # FIXME Some errormessage would be nice
        redirect('/');
        return;
    }

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

    set('date', $date->format(option('date_format')));
    set('yesterday', $yesterday->format('Y-m-d'));
    set('tomorrow', $tomorrow->format('Y-m-d'));
    
    set('hours', range(option('daystart_hour'), option('dayend_hour'), 1));

    return partial('calendar.html.php');
}
