<script>
// Somewhat ugly, but we need to set these somewhere initially
<!--
document.today="<?php echo $today; ?>";
document.tomorrow="<?php echo $tomorrow; ?>";
document.yesterday="<?php echo $yesterday; ?>";
-->
</script>

<div class="calendar_header">
    <h1>
        <span id="yesterday"><a href="#" onclick="load_calendar(document.yesterday);" >&lt;&lt;</a></span>
        <span id="today"> - <a href="#" onclick="load_calendar('today');"> Today </a> - </span>
        <span id="tomorrow"><a href="#" onclick="load_calendar(document.tomorrow);">&gt;&gt;</a></span>
        <span id="calendar_date"></span>
    </h1>
</div>

<table class="calendar">
<?php foreach ($hours as $k => $v): ?>

    <tr style="<?php if ( ! $v->in_timeframe ) echo 'display:none;'; ?>" id="hour_<?php printf("%02d", $k); ?>">
    
        <td>
        
        <div id="<?php printf("%02d", $k); ?>" class="calendar_hour"><big><?php printf("%02d", $k); ?></big><small>00</small></div>
        
        </td>
        
    </tr>

<?php endforeach; ?>
</table>
