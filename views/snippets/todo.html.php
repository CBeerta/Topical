<li id="todo_order_<?php echo $task->id; ?>" class="todo">
    <img class="todo_move" src="img/gtk-dnd.png" width="24" height="24">
    <img class="todo_done" src="img/gtk-apply.png" width="24" height="24" onclick="todo_done(<?php echo $task->id; ?>);">
<?php if ($task->age): ?>
    <div class="todo_age"><?php echo $task->age; ?></div>
<?php endif; ?>
    <div class="todo_edit" id="<?php echo $task->id; ?>"><?php echo Markdown($task->content); ?></div>
</li>
