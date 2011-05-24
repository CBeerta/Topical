<?php

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

function todo_load()
{
    $id = isset($_POST['id']) ? $_POST['id'] : false;
    
    if ( ! $id ) return json("Does not Exist");
    
    $todo = ORM::for_table('todo')->find_one($id);
    
    return partial($todo->content);
}

function todo_complete()
{
    $id = params('id') ? params('id') : false;
    
    if ( ! $id ) return("failed");
    
    $todo = ORM::for_table('todo')->find_one($id);
    $todo->completed = date('c');
    $todo->save();

    return json("ok");
}
