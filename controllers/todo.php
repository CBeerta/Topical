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
* Task Controller
*
* @category Todo
* @package  Topical
* @author   Claus Beerta <claus@beerta.de>
* @license  http://www.opensource.org/licenses/mit-license.php MIT License
* @link     http://claus.beerta.de/
**/
class Task
{
    /**
    * Return The todo Partial for our main Page
    *
    * @param string $day Day to load
    *
    * @return html
    **/
    public static function index($day)
    {
        $todo = ORM::for_table('todo')
            ->where_raw("`completed` IS NULL")
            ->order_by_asc('order')
            ->find_many();
        
        $tasklist = '';
        foreach ($todo as $task) {
            $task->age = self::age($task);
            set('task', $task);
            $tasklist .= partial('snippets/todo.html.php');    
        }
        
        return partial("todolist.html.php", array('tasklist' => $tasklist));
    }

    /**
    * Save a new Task or Update an Existing one
    *
    * @return html
    **/
    public static function save()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : false;
        $value = isset($_POST['value']) ? $_POST['value'] : false;

        if ( ! $value ) {
            return;
        }

        if ( ! $id ) {
            // new todo
            $todo = ORM::for_table('todo')->create();    
            $todo->added = date('c');
            $todo->order = -1;
            $value = "# " . $value; // Automatically make it a header
        } else {
            // edit existing
            $todo = ORM::for_table('todo')->find_one($id);
        }

        $todo->updated = date('c');
        $todo->content = $value;
        $todo->save();

        return partial($id ? Markdown($value) : $todo->id);
    }

    /**
    * Sort the tasklist (AJAX)
    *
    * @return json
    **/
    public static function sort()
    {
        $todo_order = isset($_POST['todo_order']) ? $_POST['todo_order'] : false;
        
        if ( ! $todo_order ) {
            return json("Fail");
        }
        
        parse_str($todo_order, $output);
        
        foreach ($output['todo_order'] as $k=>$v) {
            $todo = ORM::for_table('todo')->find_one($v);
            
            if ( ! $todo ) {
                continue;
            }
            
            $todo->order = $k;
            $todo->save();
        }

        return json("OK");
    }

    /**
    * Load Task Content, return it as partial. Without Markdown applied for 
    * the jQuery editable
    *
    * @param bool $formatted Should the reply be formatted
    *
    * @return html
    **/
    public static function load( $formatted = false )
    {
        $id = isset($_POST['id']) ? $_POST['id'] : false;
        
        if ( ! $id ) {
            return json("Does not Exist");
        }
        
        $todo = ORM::for_table('todo')->find_one($id);
        $todo->age = self::age($todo);
        
        if ( $formatted ) {    
            return partial('snippets/todo.html.php', array('task' => $todo));
        } else {
            return partial($todo->content);
        }
    }

    /**
    * Complete or Delete a Task in the Database (AJAX)
    *
    * @param string $action What action to execute
    *
    * @return html
    **/
    public static function complete( $action )
    {
        $id = isset($_POST['id']) ? $_POST['id'] : false;

        if ( ! is_numeric($id) ) {
            return json("FAIL");
        }

        $todo = ORM::for_table('todo')->find_one($id);
        switch ($action)
        {
        case 'complete':
            $todo->completed = date('c');
            $todo->save();
            break;
        case 'delete':
            $todo->delete();
            break;
        }

        return partial($id);
    }

    /**
    * Calculate the "age" of a task in days
    *
    * @param string $task  Task to calc days for
    * @param bool   $today Use Today as offset?
    *
    * @return string
    **/
    public static function age( $task, $today = false )
    {
        if ( ! $today ) {
            $today = new DateTime();
        }
        
        $created = new DateTime($task->added);
        $interval = $created->diff($today);
        
        if ($interval->days == 1 
            || ($today->format('z') - $created->format('z')) == 1
        ) { 
            return "Yesterday";
        } else if ($interval->days == 0) {
            return 'Today';
        } else {
            return $interval->days . " Days Ago";
        }
    }

}
