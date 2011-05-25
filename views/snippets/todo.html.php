<li id="todo_order_<?php echo $task->id; ?>" class="todo">
    <img class="todo_move" id="<?php echo $task->id; ?>" src="img/gtk-dnd.png" width="24" height="24">
    <img class="todo_done" id="<?php echo $task->id; ?>" src="img/gtk-apply.png" width="16" height="16">
    <div class="todo_edit" id="<?php echo $task->id; ?>"><?php echo Markdown($task->content); ?></div>
</li>
