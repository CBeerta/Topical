<?php

Class Task
{
    
    /**
    * Return The todo Partial for our main Page
    **/
    public static function index( $day )
    {
        $todo = ORM::for_table('todo')
            ->where_raw("`completed` IS NULL")
            ->order_by_asc('order')
            ->find_many();
        
        $tasklist = '';
        foreach ($todo as $task)
        {
            $task->age = self::age($task);
            set('task', $task);
            $tasklist .= partial('snippets/todo.html.php');    
        }
        return partial("todolist.html.php", array('tasklist' => $tasklist));
    }


    /**
    * Save a new Task or Update an Existing one
    **/
    public static function save()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : false;
        $value = isset($_POST['value']) ? $_POST['value'] : false;

        if ( ! $value ) return;

        if ( ! $id )
        {
            # new todo
            $todo = ORM::for_table('todo')->create();    
            $todo->added = date('c');
            $todo->order = -1;
            $value = "# " . $value; // Automatically make it a header
        }
        else
        {
            # edit existing
            $todo = ORM::for_table('todo')->find_one($id);
        }

        $todo->updated = date('c');
        $todo->content = $value;
        $todo->save();

        return partial($id ? Markdown($value) : $todo->id);
    }

    /**
    * Sort the tasklist (AJAX)
    **/
    public static function sort()
    {
        $todo_order = isset($_POST['todo_order']) ? $_POST['todo_order'] : false;
        
        if ( ! $todo_order ) return json ("Fail");
        parse_str($todo_order, $output);
        
        foreach ($output['todo_order'] as $k=>$v)
        {
            $todo = ORM::for_table('todo')->find_one($v);
            if ( ! $todo ) continue;
            $todo->order = $k;
            $todo->save();
        }

        return json ("OK");
    }

    /**
    * Load Task Content, return it as partial. Without Markdown applied for 
    * the jQuery editable
    **/
    public static function load( $formatted = false )
    {
        $id = isset($_POST['id']) ? $_POST['id'] : false;
        
        if ( ! $id ) return json("Does not Exist");
        
        $todo = ORM::for_table('todo')->find_one($id);
        $todo->age = self::age($todo);
        
        if ( $formatted )
        {    
            return partial('snippets/todo.html.php', array('task' => $todo));
        }
        else
        {
            return partial($todo->content);
        }
    }

    /**
    * Complete or Delete a Task in the Database (AJAX)
    **/
    public static function complete( $action )
    {
        $id = params('id') ? params('id') : false;
        if ( ! is_numeric($id) ) return json("FAIL");
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
    **/
    public static function age( $task )
    {
        $created = new DateTime($task->added);
        $interval = $created->diff(new DateTime());
        if ($interval->days == 0) return 'Today';
        else if ($interval->days == 1) return "Yesterday";
        else return $interval->days . " Days Ago";
    }

} # Class


