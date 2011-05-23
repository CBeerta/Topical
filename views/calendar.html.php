

<div>
    <h1>&lt; <?php echo $yesterday; ?></h1>
</div>

<?php foreach ($hours as $hour): ?>

    <hour>
    
        <div id="hour"><?php echo $hour; ?></div>
        
    </hour>


<?php endforeach; ?>

<div>
    <h1>&gt; <?php echo $tomorrow; ?></h1>
</div>

