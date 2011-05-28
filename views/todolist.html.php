<ul class="todo">
    <li class="todo">
        <p>
        <form id="todo_save" method="POST" action="<?php echo url_for('/todo_save/'); ?>">
            <input id="todo_task" type="text" name="value" placeholder="Create new Task" accesskey="a" size="40">
            <input type="submit" value="Add Task" class="awesome">
        </form>
        </p>
    </li>
</ul>
<ul class="todo" id="sortable">
    <div id="todolist_first"></div>
    <?php echo $tasklist; ?>
</ul>
