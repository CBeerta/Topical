

<div class="calendar_header">
    <h1>
        <span id="yesterday"><a href="#<?php //echo url_for($yesterday); ?>" onclick="load_calendar('yesterday');" >&lt;&lt;</a></span>
        <span id="today"><a href="#<?php //echo url_for(); ?>" onclick="load_calendar('today');"> Today </a></span>
        <span id="tomorrow"><a href="#<?php //echo url_for($tomorrow); ?>" onclick="load_calendar('tomorrow');">&gt;&gt;</a></span>
        <span id="date"><?php echo $date; ?></span>
    </h1>
</div>

<?php foreach ($hours as $hour): ?>

    <hour>

        <div id="<?php echo $hour; ?>" class="calendar_hour"><big><?php printf("%02d", $hour); ?></big><small>00</small></div>
        
    </hour>

<?php endforeach; ?>


