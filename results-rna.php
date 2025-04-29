<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DGEAR-Web | Results</title>
</head>
<?php include 'header.php';?>
<body>
  <div class="body-div">
  <h2>Statistical Tests</h2>
<!-- Table Starts -->
<?php
$csv_dir = "csv/";
$ver_tests = [
  "Ensemble Result" => "RNAseq_significant.csv",
  "VER1" => "VER1.csv",
  "VER2" => "VER2.csv",
  "VER3" => "VER3.csv"
];
?>

<table>
  <thead>
    <tr>
      <th>Serial No.</th>
      <th>Statistical Tests</th>
      <th>Download Links</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $serial = 1;
    foreach ($ver_tests as $test_name => $filename) {
      $filepath = $csv_dir . $filename;
      echo "<tr>";
      echo "<td>{$serial}</td>";
      echo "<td>{$test_name}</td>";
      echo "<td><a class='download-link' href='{$filepath}' download>Download</a></td>";
      echo "</tr>";
      $serial++;
    }
    ?>
  </tbody>
</table>
<!-- Table Ends -->    
  </div>
  <div class="body-div">
  <h2>Generated Plots</h2>
  <div class="gallery">
  <?php
$plot_dir = "plots/rna-seq/";
$allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];

// Scan the directory
$files = scandir($plot_dir);
$has_images = false;

foreach ($files as $file) {
    $file_path = $plot_dir . $file;
    $file_ext = pathinfo($file, PATHINFO_EXTENSION);

    if (in_array(strtolower($file_ext), $allowed_extensions)) {
        $has_images = true;
        echo '<div class="plot-card">';
        echo '<img src="' . $file_path . '" alt="Plot Image">';
        echo '<a class="download-link" href="' . $file_path . '" download>Download</a>';
        echo '</div>';
    }
}

if (!$has_images) {
    echo '<p>No plots found in the folder.</p>';
}
?>

  </div>
  </div>
  </div>
</body>
<?php include 'footer.php';?>
</html>
