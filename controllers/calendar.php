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
* Calendar Controller
*
* @category Todo
* @package  Topical
* @author   Claus Beerta <claus@beerta.de>
* @license  http://www.opensource.org/licenses/mit-license.php MIT License
* @link     http://claus.beerta.de/
**/
class Calendar
{
    /**
    * For the main file fill the right "frame" with initial content
    *
    * @param string $day Day to load
    *
    * @return html
    **/
    public static function index($day)
    {
        $hours = array();
        $timeframe = range(option('day_start_hour'), option('day_end_hour'), 1);

        foreach (range(0, 23, 1) as $hour) {
            $in_timeframe = in_array($hour, $timeframe) ? true : false;
            $hours[$hour] = (object) array (
                'in_timeframe' => $in_timeframe,
            );
        }

        set('hours', $hours);
        self::_dates($day);
        return partial('calendar.html.php');
    }

    /**
    * Convert $day to dates we need for snippets, json etc
    *
    * @param string $day Day to load
    *
    * @return object
    **/
    private static function _dates($day) 
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
            return false;
        }
        
        $dates = (object) array(
            'date' => $date,
            'today' => $today->format('Y-m-d'),
            'yesterday' => $yesterday->format('Y-m-d'),
            'tomorrow' => $tomorrow->format('Y-m-d'),
        );

        foreach ($dates as $k => $v) {
            set($k, $v);
        }
        
        return $dates;
    }

    /**
    * Return for the AJAX call to fill the calendar of $day with content
    *
    * @param string $day Day to load
    *
    * @return json
    **/
    public static function hours($day)
    {
        $dates = self::_dates($day);
        
        if (!$dates) {
            $dates = self::_dates("today");
        }
        
        $completed = ORM::for_table('todo')
            ->select_expr("STRFTIME('%H', `completed`, 'localtime')", 'hour')
            ->select('*')
            ->where_raw("DATE(`completed`) = ?", $dates->today)
            ->find_many();

        $indexed_completed = array();
        foreach ($completed as $item) {
            //$item->age = Task::age($item, new DateTime($item->completed));
            $item->age = new DateTime($item->completed);
            $item->added = new DateTime($item->added);
            $indexed_completed[$item->hour][] = array(
                'id' => $item->id,
                'content' => partial(
                    'snippets/calendar.html.php', array('item' => $item)
                ),
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

}


