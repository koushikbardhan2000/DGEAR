<?php
$cmd = 'Rscript /var/www/html/webtool/test/temp.R 12 temp';
exec($cmd);
echo "<img src='/webtool/test/temp.png' alt='Generated Image'>";
echo "<p>Executed command: $cmd</p>";




$rscript = "Rscript";
$rcode = "/var/www/html/webtool/RunCopy.R";
$target_file = "/var/www/html/webtool/uploads/merged_sep_no_dup-truncated.txt";
$con1 = 1;
$con2 = 105;
$exp1 = 106;
$exp2 = 234;
$alpha = 0.005;
$votting_cutoff = 3;

$cmd1 = "$rscript $rcode $target_file $con1 $con2 $exp1 $exp2 $alpha $votting_cutoff";
echo "<p>Command for DGEAR: $cmd1</p>";
?>
