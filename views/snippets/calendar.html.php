<div class="calendar_entry completed_todo">
    <div class="todo_edit" id="<?php echo $item->id; ?>"><?php echo Markdown($item->content); ?></div>

    <!-- p id="info"><?php echo $item->added->format(option('date_format')); ?></p -->
    <p id="info">
        Created <?php if ($item->age): ?><?php echo $item->age; ?><?php endif; ?>
    </p>
</div>
