<?php


/**
* Return The todo Partial for our main Page
*
*
**/
function _todo_index( $day )
{
    $todo = ORM::for_table('todo')
        ->where_raw("`completed` IS NULL")
        ->order_by_asc('order')
        ->find_many();
    
    $tasklist = '';
    foreach ($todo as $task)
    {
        set('task', $task);
        $tasklist .= partial('snippets/todo.html.php');    
    }
    
    return partial("todolist.html.php", array('tasklist' => $tasklist));
}

/**
* Save a new Task or Update an Existing one
*
*
**/
function todo_save()
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
*
*
**/
function todo_sort()
{
    $todo_order = isset($_POST['todo_order']) ? $_POST['todo_order'] : false;
    
    if ( ! $todo_order ) return json ("Fail");
    parse_str($todo_order, $output);
    
    foreach ($output['todo_order'] as $k=>$v)
    {
        $todo = ORM::for_table('todo')->find_one($v);
        $todo->order = $k;
        $todo->save();
    }

    return json ("OK");
}

/**
* Load Task Content, return it as partial. Without Markdown applied for 
* the jQuery editable
*
**/
function todo_load( $formatted = false )
{
    #d($_POST);
    $id = isset($_POST['id']) ? $_POST['id'] : false;
    
    if ( ! $id ) return json("Does not Exist");
    
    $todo = ORM::for_table('todo')->find_one($id);

    #d($todo);
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
* Set `completed` date in database for a Task (AJAX)
*
**/
function todo_complete()
{
    $id = params('id') ? params('id') : false;
    
    if ( ! $id ) return("failed");
    
    $todo = ORM::for_table('todo')->find_one($id);
    $todo->completed = date('c');
    $todo->save();

    return json("ok");
}



