<?php

/**
* For the main file fill the right "frame" with initial content
*
**/
function _calendar_index ( $day )
{
    $hours = array();
    $timeframe = range(option('day_start_hour'), option('day_end_hour'), 1);
    foreach (range(0, 23, 1) as $hour)
    {
        $in_timeframe = in_array($hour, $timeframe) ? true : false;
        $hours[$hour] = (object) array (
            'in_timeframe' => $in_timeframe,
            );
    }
    set('hours', $hours);
    _get_dates($day);
    return partial('calendar.html.php');
}

/**
* Convert $day to dates we need for snippets, json etc
*
**/
function _get_dates ( $day ) 
{
    try
    {
        $today = new DateTime($day);
        $yesterday = new DateTime($day);
        $tomorrow = new DateTime($day);
        $date = $today->format(option('date_format'));
    
        $yesterday->sub(new DateInterval('P1D'));
        $tomorrow->add(new DateInterval('P1D'));
    }
    catch (Exception $e)
    {
        return;
    }
    
    $dates = (object) array(
        'date' => $date,
        'today' => $today->format('Y-m-d'),
        'yesterday' => $yesterday->format('Y-m-d'),
        'tomorrow' => $tomorrow->format('Y-m-d'),
        );
    foreach ($dates as $k => $v)
    {
        set ($k, $v);
    }
    
    return $dates;
}


/**
* Return for the AJAX call to fill the calendar of $day with content
*
*
**/
function calendar_hours ( $day ) 
{
    $dates = _get_dates($day);
    
    $completed = ORM::for_table('todo')
        ->select_expr("STRFTIME('%H', `completed`, 'localtime')", 'hour')
        ->select('*')
        ->where_raw("DATE(`completed`) = ?", $dates->today)
        ->find_many();

    $indexed_completed = array();
    foreach ($completed as $item)
    {
        $item->age = _todo_age($item);
        $item->added = new DateTime($item->added);
        $indexed_completed[$item->hour][] = array(
            'id' => $item->id,
            'content' => partial('snippets/calendar.html.php', array('item' => $item)),
            'hour' => $item->hour,
            );
    }
    $data = array (
        'items' => $indexed_completed, 
        'date' => $dates->date,
        'today' => $dates->today,
        'tomorrow' => $dates->tomorrow,
        'yesterday' => $dates->yesterday,
        );
        
    return json($data);
}


