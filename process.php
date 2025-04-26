<?php
// Full path is required i.e. "/var/www/DGEAR/uploads/"
$target_dir = "/var/www/DGEAR/uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

$con1 = escapeshellarg($_POST['con1']);
$con2 = escapeshellarg($_POST['con2']);
$exp1 = escapeshellarg($_POST['exp1']);
$exp2 = escapeshellarg($_POST['exp2']);
$alpha = escapeshellarg($_POST['alpha']);
$votting_cutoff = escapeshellarg($_POST['votting_cutoff']);

$rscript = "/usr/bin/Rscript"; // Full path is required i.e. "/usr/bin/Rscript"
$rcode = "/var/www/DGEAR/microarray.R"; // Full path is required i.e. "/var/www/DGEAR/microarray.R"
$log_file = "/var/www/DGEAR/logs/rscript.log"; // Log file path (Full path is required i.e. "/var/www/DGEAR/logs/rscript.log")

// Ensure the logs directory exists
if (!file_exists(dirname($log_file))) {
    mkdir(dirname($log_file), 0775, true);
}

// Run R script and log output
$cmd = "$rscript $rcode $target_file $con1 $con2 $exp1 $exp2 $alpha $votting_cutoff 2>&1 | tee -a $log_file";
exec($cmd, $output, $return_var);

// Log execution result
$log_message = date("Y-m-d H:i:s") . " - Executed: $cmd\nReturn Code: $return_var\nOutput:\n" . implode("\n", $output) . "\n\n";
file_put_contents($log_file, $log_message, FILE_APPEND);

if ($return_var !== 0) {
    die("Error executing R script. Check logs for details.");
}

// Redirect to results page
header("Location: results.php"); // header("Location: https://musing-bush-92495.pktriot.net/webtool/results.php");
exit();
?>