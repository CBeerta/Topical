

<div class="calendar_header">
    <h1>
        <span id="yesterday"><a href="<?php echo url_for($yesterday); ?>">&lt;&lt;</a></span>
        <span id="today"><a href="<?php echo url_for(); ?>"> Today </a></span>
        <span id="tomorrow"><a href="<?php echo url_for($tomorrow); ?>">&gt;&gt;</a></span>
        <span id="date"><?php echo $date; ?></span>
    </h1>
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


