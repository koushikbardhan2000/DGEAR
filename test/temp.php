<img src='temp.png' alt='Generated Image'>
<form method="post">
    <button type="submit" name="run_script">Generate Plot</button>
</form>
<?php
if (isset($_POST['run_script'])) {
    $cmd = '/usr/bin/Rscript /var/www/DGEAR/test/temp.R 12 temp';
    exec($cmd);
    echo "<p>Executed command: $cmd</p>";

}
?>
