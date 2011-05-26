<div class="calendar_entry completed_todo">
    <?php echo Markdown($item->content); ?>
    
    <p>
    Created: <?php echo $item->added->format(option('date_format')); ?>
    </p>
    <p>
    <?php if ($item->age): ?>
    Age: <?php echo $item->age; ?> 
    <?php endif; ?>
    </p>
</div>
