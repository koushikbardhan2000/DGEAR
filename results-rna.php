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
        <td><a href="csv/RNAseq_significant.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>2</td>
        <td>VER1</td>
        <td><a href="csv/VER1.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>3</td>
        <td>VER2</td>
        <td><a href="csv/VER2.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
      <tr>
        <td>4</td>
        <td>VER3</td>
        <td><a href="csv/VER3.csv" download>Download</a></td> <!-- Full path is not required i.e. "csv/ensembl_sigificant.csv"  -->
      </tr>
    </tbody>
  </table>    
  </div>
  <!-- <div class="body-div">
  <h2>Generated Plots</h2>
  <?php
  $plot_file = "plots/heatmap.png"; // Full path is not required i.e. "plots/heatmap.png"
  if (!empty($plot_file)) {
    echo '<p><img src="' . $plot_file . '" alt="Heatmap"></p>';
    echo '<p>Download the plot: <a style="text-decoration: none; color: black; font-size: 18px; padding: 7px,13px; border-radius: 3px; font-weight: bold; text-align: center;" href="' . $plot_file . '">Download</a></p>';
  } else {
    echo '<p>No plot generated.</p>';
  }
  ?>
  </div> -->
  </div>
</body>
<?php include 'footer.php';?>
</html>
