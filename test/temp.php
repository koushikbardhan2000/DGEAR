<style>
/* Only for the loading animation Start */
/* Fullscreen overlay */
#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
}

/* Circular spinner */
.loader {
    border: 12px solid #f3f3f3;
    border-top: 12px solid #3498db;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    animation: spin 1s linear infinite;
}

/* Spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
/* Only for the loading animation End */
</style>


<!-- loading overlay  div -->
<div id="loading-overlay">
    <div class="loader"></div>
</div>
<!-- loading overlay  div -->


<!-- main content on the site -->
<img src='temp.png' alt='Generated Image'>

<form method="post" onsubmit="showLoading()">
    <button type="submit" name="run_script">Generate Plot</button>
</form>


<script>
function showLoading() {
    document.getElementById('loading-overlay').style.display = 'flex';
}
</script>

<!-- main content on the site with script-->
<?php
if (isset($_POST['run_script'])) {
    $cmd = '/usr/bin/Rscript /var/www/DGEAR/test/temp.R 12 temp';
    exec($cmd);
    echo "<p>Executed command: $cmd</p>";
}
?>
