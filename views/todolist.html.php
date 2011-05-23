

<ul id="todo">

    <li style="padding-bottom: 20px;">
        <p>
        <form method="POST" action="<?php echo url_for('/' . $day); ?>">
            <input type="hidden" name="function" value="todo_save">
            <input type="text" name="value" placeholder="Create new Task" size="40">
            <input type="submit" value="Save">
        </form>
        </p>
    </li>

<?php foreach ($todo as $v): ?>


    <li id="<?php echo $v->id; ?>" class="todo">
        <img class="todo_move" id="<?php echo $v->id; ?>" src="img/gtk-dnd.png" width="16" height="16">
    
        <img class="todo_done" id="<?php echo $v->id; ?>" src="img/gtk-apply.png" width="16" height="16">
        
        <div class="todo_edit" id="<?php echo $v->id; ?>"><?php echo Markdown($v->content); ?></div>
        
    </li>

<?php endforeach; ?>


</ul>

