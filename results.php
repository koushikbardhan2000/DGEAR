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
  <table>
    <thead>
      <tr>
        <th>Serial No.</th>
        <th>Statistical Tests</th>
        <th>Download Links</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Ensemsble Result</td>
        <td><a href="csv/ensembl_sigificant.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>2</td>
        <td>Dunnett's t-test</td>
        <td><a href="csv/d_stat_significant.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>3</td>
        <td>Half t-test</td>
        <td><a href="csv/half_t_stat_significant.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>4</td>
        <td>One-Way ANOVA</td>
        <td><a href="csv/o_stat_significant.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>5</td>
        <td>T-test Result</td>
        <td><a href="csv/t_stat_significant.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>6</td>
        <td>Wilcox/Mann-wheitney U-test</td>
        <td><a href="csv/u_stat_significant.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
    </tbody>
  </table>    
  </div>
  <div class="body-div">
  <h2>Generated Plots</h2>
  <div class="gallery">
  <?php
$plot_dir = "plots/";
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
