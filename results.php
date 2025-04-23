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
        <td><a href="csv/ensembl_sigificant.csv" download>Download</a></td>
      </tr>
      <tr>
        <td>2</td>
        <td>Dunnett's t-test</td>
        <td><a href="csv/d_stat_significant.csv" download>Download</a></td>
      </tr>
      <tr>
        <td>3</td>
        <td>Half t-test</td>
        <td><a href="csv/half_t_stat_significant.csv" download>Download</a></td>
      </tr>
      <tr>
        <td>4</td>
        <td>One-Way ANOVA</td>
        <td><a href="csv/o_stat_significant.csv" download>Download</a></td>
      </tr>
      <tr>
        <td>5</td>
        <td>T-test Result</td>
        <td><a href="csv/t_stat_significant.csv" download>Download</a></td>
      </tr>
      <tr>
        <td>6</td>
        <td>Wilcox/Mann-wheitney U-test</td>
        <td><a href="csv/u_stat_significant.csv" download>Download</a></td>
      </tr>
    </tbody>
  </table>    
  </div>
  <div class="body-div">
  <h2>Generated Plots</h2>
  <?php
  $plot_file = "plots/heatmap.png";
  if (!empty($plot_file)) {
    echo '<p><img src="' . $plot_file . '" alt="Heatmap"></p>';
    echo '<p>Download the plot: <a style="text-decoration: none; color: black; font-size: 18px; padding: 7px,13px; border-radius: 3px; font-weight: bold; text-align: center;" href="' . $plot_file . '">Download</a></p>';
  } else {
    echo '<p>No plot generated.</p>';
  }
  ?>
  </div>
  </div>
</body>
<?php include 'footer.php';?>
</html>
