<li id="todo_order_<?php echo $task->id; ?>" class="todo">
    <div class="todo">
        <img id="todo_move" src="img/move_alt1_16x16.png" width="16" height="16">
        <img src="img/trash_stroke_16x16.png" title="Delete" width="16" height="16" onclick="todo_complete('delete', <?php echo $task->id; ?>);">
        <img src="img/check_16x13.png" title="Complete" width="16" height="13" onclick="todo_complete('complete', <?php echo $task->id; ?>);">
    </div>
    <div class="todo_age"><?php echo $task->age; ?></div>
    <div class="todo_edit" id="<?php echo $task->id; ?>"><?php echo Markdown($task->content); ?></div>
</li>
