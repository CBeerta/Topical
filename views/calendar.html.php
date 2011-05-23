

<div>
    <h1 id="tomorrow"><a href="#"><?php echo $tomorrow; ?></a> &gt;</h1>
    <h1 id="yesterday">&lt; <a href="#"><?php echo $yesterday; ?></a></h1>
</div>

<?php foreach ($hours as $hour): ?>

    <hour>

        <div class="calendar_hour"><big><?php printf("%02d", $hour); ?></big><small>00</small></div>

    <?php if ( in_array($hour, array_keys($completed)) ): ?>

        <!-- FIXME: FUCK this is ugly -->
            <?php foreach ($completed[$hour] as $item): ?>
            
                <div class="calendar_entry completed_todo">
                    <?php echo Markdown($item->content); ?>
                </div>
            
            <?php endforeach; ?>

    <?php endif; ?>

        
    </hour>

<?php endforeach; ?>


