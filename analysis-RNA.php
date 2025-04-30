<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="DGEAR-Web is a web-based platform designed for ensemble-based integrative analysis, enabling the prediction of differentially expressed genes (DEGs) from gene expression data.">
  <link rel="canonical" href="https://compbiosysnbu.in/DGEAR/analysis-RNA.php">
  <title>DGEAR-Web | RNA-seq Analysis</title>
</head>
<?php include 'header.php';?>
<body>
  <div class="body-div">
        <h3>Differential Gene Expression Analysis</h3>
        <!-- Loading div starts-->
	    <div class="loader-container" id="loader-container" style="display: none;">
            <div class="loader"></div>
        </div>
        <!-- Loading div ends-->

        <!-- form starts --> 
        <form action="process-rna.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <a href="analysis.php" id="" class="change-btn">Microarray Analysis</a>
            </div>
            <div class="form-group">
                <a href="analysis-RNA.php" id="active" class="change-btn">[RNA-seq Analysis]</a>
            </div>
            <div class="file-upload">
                <input type="file" name="file" id="file" required hidden>
                <label for="file" class="drop-area" id="drop-area">
                    <p>Drag & Drop a file here or <span>Browse</span></p>
                </label>
                <p id="file-name"></p>
            </div>

            <div class="form-group">
                <label for="con1">Control Start Column:</label>
                <input type="text" name="con1" required>

                <label for="con2">Control End Column:</label>
                <input type="text" name="con2" required>
            </div>

            <div class="form-group">
                <label for="exp1">Experiment Start Column:</label>
                <input type="text" name="exp1" required>

                <label for="exp2">Experiment End Column:</label>
                <input type="text" name="exp2" required>
            </div>

            <div class="form-group">
                <label for="alpha">Alpha Value:</label>
                <input type="text" name="alpha" placeholder="Any value i.e. 0.1, 0.05, 0.005 etc." required>

                <label for="votting_cutoff">Voting Cutoff:</label>
                <input type="text" name="votting_cutoff" placeholder="Any number 1 to 3." required>
            </div>
            <div class="form-group">
                <label for="download">Download Example data:</label>
                <a href="example/Example_microarray_data.txt" download class="download-btn">Microarray Data</a><br>
                <a href="example/Example_RNA-seq_data.tsv" download class="download-btn">RNA-seq Data</a>
            </div>

            <button class="button" type="submit" onclick=startLoading()>Submit request</button>
        </form>
        <!-- form ends -->
  </div>
  <script src="js/script.js"></script> <!-- This is for the Drag and Drop Box  -->
  <script src="js/loading.js"></script> <!-- This is for the loading animation  -->
</body>
<?php include 'footer.php';?>
</html>
