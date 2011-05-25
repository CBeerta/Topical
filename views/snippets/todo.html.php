<li id="todo_order_<?php echo $task->id; ?>" class="todo">
    <img class="todo_move" src="img/gtk-dnd.png" width="24" height="24">
    <img class="todo_done" src="img/gtk-apply.png" width="16" height="16">
<?php if ($task->age): ?>
    <div class="todo_age"><?php echo $task->age; ?> old</div>
<?php endif; ?>
    <div class="todo_edit" id="<?php echo $task->id; ?>"><?php echo Markdown($task->content); ?></div>
</li>
