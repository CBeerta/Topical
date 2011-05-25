<div class="calendar_entry completed_todo">
    <?php echo Markdown($item->content); ?>
    
    <p>
    Created: <?php echo $item->added->format(option('date_format')); ?>
    </p>
    <p>
    Age: <?php echo $item->age; ?> 
    </p>
</div>
