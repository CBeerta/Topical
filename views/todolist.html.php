

<ul class="todo">

    <li class="todo">
        <p>
        <form method="POST" action="<?php echo url_for('/' . $day); ?>">
            <input type="hidden" name="function" value="todo_save">
            <input type="text" name="value" placeholder="Create new Task" size="40">
            <input type="submit" value="Save" class="awesome small">
        </form>
        </p>
    </li>

</ul>

<ul class="todo" id="sortable">
<?php foreach ($todo as $v): ?>

    <li id="todo_order_<?php echo $v->id; ?>" class="todo">
    
        <img class="todo_move" src="img/gtk-dnd.png" width="24" height="24">
    
        <img class="todo_done" src="img/gtk-apply.png" width="16" height="16">
        
        <div class="todo_edit" id="<?php echo $v->id; ?>"><?php echo Markdown($v->content); ?></div>
        
    </li>

<?php endforeach; ?>

</ul>

