<!DOCTYPE html>
<html>
<head>
  <title>Results</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h1>Results</h1>

  <h2>Generated CSV Files</h2>
  <?php
  $csv_files = glob("csv/*.csv");
  if (!empty($csv_files)) {
    echo '<ul>';
    foreach ($csv_files as $csv_file) {
      echo '<li><a href="' . $csv_file . '">' . $csv_file . '</a></li>';
    }
    echo '</ul>';
  } else {
    echo '<p>No CSV files generated.</p>';
  }
  ?>

  <h2>Generated Plots</h2>
  <?php
  $plot_file = "heatmap.pdf";
  if (file_exists($plot_file)) {
    echo '<p><img src="' . $plot_file . '" alt="Heatmap"></p>';
    echo '<p>Download the plot: <a href="' . $plot_file . '">Download</a></p>';
  } else {
    echo '<p>No plot generated.</p>';
  }
  ?>
</body>
</html>
