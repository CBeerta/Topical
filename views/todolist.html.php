

<ul id="todo">

<?php foreach ($todo as $k=>$v): ?>


    <li id="<?php echo $k; ?>">
        <img class="todo_move" id="<?php echo $k; ?>" src="img/gtk-dnd.png" width="16" height="16">
    
        <img class="todo_done" id="<?php echo $k; ?>" src="img/gtk-apply.png" width="16" height="16">
        
        <div class="todo_edit" id="<?php echo $k; ?>"><?php echo Markdown($v); ?></div>
        
    </li>

<?php endforeach; ?>

    <li style="padding-top: 50px;">
        <p>
        <form method="POST" action="<?php echo url_for(); ?>">
            <input type="hidden" name="function" value="todo_save">
            <input type="text" name="value" placeholder="Create new TODO" size="40">
            <input type="submit" value="Save">
        </form>
        </p>
    </li>

</ul>

