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
    set('todo', $todo);
    
    return partial('todolist.html.php');
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

    return partial(Markdown($value));
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
* Load a Task, return it as partial (AJAX)
*
*
**/
function todo_load()
{
    d($_POST);
    $id = isset($_POST['id']) ? $_POST['id'] : false;
    
    if ( ! $id ) return json("Does not Exist");
    
    $todo = ORM::for_table('todo')->find_one($id);
    
    return partial($todo->content);
}

/**
* Set `completed` date in database for a Task (AJAX)
*
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




