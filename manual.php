<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DGEAR-Web | Home</title>
</head>
<?php include 'header.php';?>
<body>
	<div class="body-div">
    <h1>DGEAR-Web Dashboard Manual</h1>

    <h2>Table of Contents</h2>

    <ul class="toc">
    <li><a href="#DGEAR-web">DGEAR-web Dashboard</a>
    <ul>
    <li><a href="#introduction">Introduction</a></li>
    <li><a href="#architecture-overview">Architecture Overview</a></li>
    <li><a href="#key-features">Key Features</a></li>
    <li><a href="#data-format-and-example-data">Data Format and Example Data</a>
    <ul>
    <li><a href="#1-microarray-example-data">1. Microarray Example Data</a></li>
    <li><a href="#2-rna-seq-example-data">2. RNA-seq Example Data</a></li>
    </ul></li>
    </ul></li>
    <li><a href="#user-manual">User Manual</a>
    <ul>
    <li><a href="#1-opening-the-web-tool">1. Reaching the Web-Tool</a></li>
    <li><a href="#2-navigation">2. Navigation</a></li>
    <li><a href="#3-uploading-data">3. Uploading Data</a></li>
    <li><a href="#4-setting-input-parameters">4. Setting Input Parameters</a></li>
    <li><a href="#5-submitting">5. Job Submitting </a></li>
    <li><a href="#6-exploring-results">6. Exploring Results</a></li>
    </ul></li>
    <li><a href="#dgear-algorithm">DGEAR Algorithm</a></li>
    <li><a href="#important-notes">Important Notes</a></li>
    <li><a href="#project-background">Project Background</a></li>
    <li><a href="#support">Support</a></li>
    </ul>

    <hr />

    <h4 id="DGEAR-web">Differential Gene Expression Analysis Resource (DGEAR)</h4>

    <h2 id="introduction">Introduction</h2>

    <p>Welcome to DGEAR-Web, an intuitive web-based platform for ensemble-based differential gene expression analysis. DGEAR empowers researchers, scientists, and users from varied backgrounds to perform complex DEG (Differentially Expressed Genes) predictions from gene expression data through a user-friendly, GUI-driven environment.</p>

    <h2 id="architecture-overview">Architecture Overview</h2>

    <p>DGEAR-Web is designed with the following key principles:</p>

    <p>
    <strong>Cross-Platform Compatibility</strong>: Accessible across Windows, macOS, Linux, and mobile devices through any modern web browser.
    <strong>User-Friendly Interface</strong>: Easy-to-navigate graphical interface with buttons, forms, and menus, ensuring usability without prior programming knowledge.
    <strong>Accessibility</strong>: Opens up bioinformatics analysis to users with minimal technical expertise.
    <strong>Efficiency and Time-Saving</strong>: Streamlined workflows minimize manual intervention, speeding up the data preprocessing and analysis process.
    </p>

    <h2 id="key-features">Key Features</h2>

    <ul>
    <li>Upload and analyze gene expression data via simple file upload.</li>
    <li>Customizable input parameters: define control/experimental groups, significance level (alpha), and ensemble voting cutoff.</li>
    <li>Visual outputs: generate plots, results summaries, and downloadable data.</li>
    <li>Result exploration: interactive browsing and download options for outputs.</li>
    </ul>

    <h2 id="data-format-and-example-data">Data Format and Example Data</h2>

    <ul>
    <li>Ensure your data is formatted correctly before upload.</li>
    <li>Example data files are available on the analysis page.</li>
    </ul>

    <h2 id="1-microarray-example-data">1. Microarray Example Data</h2>

    <table>
    <thead>
    <tr>
    <th>ID</th>
    <th>ctl1</th>
    <th>ctl2</th>
    <th>exp1</th>
    <th>exp2</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>A1BG</td>
    <td>4.993423</td>
    <td>4.977204</td>
    <td>5.69549</td>
    <td>5.876676</td>
    </tr>
    <tr>
    <td>A1CF</td>
    <td>4.788285</td>
    <td>4.417162</td>
    <td>7.557621</td>
    <td>7.662921</td>
    </tr>
    <tr>
    <td>A2M</td>
    <td>4.522844</td>
    <td>4.679698</td>
    <td>5.842635</td>
    <td>5.939148</td>
    </tr>
    <tr>
    <td>A2ML1</td>
    <td>3.864138</td>
    <td>3.771948</td>
    <td>4.234489</td>
    <td>4.342140</td>
    </tr>
    <tr>
    <td>A4GALT</td>
    <td>6.248286</td>
    <td>6.375555</td>
    <td>7.616046</td>
    <td>7.489524</td>
    </tr>
    <tr>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    </tr>
    </tbody>
    </table>

    <h2 id="2-rna-seq-example-data">2. RNA-seq Example Data</h2>

    <table>
    <thead>
    <tr>
    <th>GeneID</th>
    <th>ctl1</th>
    <th>ctl2</th>
    <th>exp1</th>
    <th>exp2</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>100287102</td>
    <td>3</td>
    <td>3</td>
    <td>3</td>
    <td>1</td>
    </tr>
    <tr>
    <td>653635</td>
    <td>367</td>
    <td>333</td>
    <td>249</td>
    <td>277</td>
    </tr>
    <tr>
    <td>102466751</td>
    <td>9</td>
    <td>12</td>
    <td>4</td>
    <td>10</td>
    </tr>
    <tr>
    <td>107985730</td>
    <td>1</td>
    <td>1</td>
    <td>0</td>
    <td>0</td>
    </tr>
    <tr>
    <td>100302278</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    </tr>
    <tr>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    </tr>
    </tbody>
    </table>

    <hr />

    <h2 id="user-manual">User Manual</h2>

    <h2 id="1-opening-the-web-tool">1. Reaching the Web-Tool</h2>

    <p>
    Visit <a href="https://compbiosysnbu.in/DGEAR/">https://compbiosysnbu.in/DGEAR/.</a> Ensure your browser supports JavaScript and cookies for optimal performance. Bookmark the URL for quick access in the future. To download the User Manual, <a href="https://compbiosysnbu.in/DGEAR/User-Manual.pdf" download>click here</a>!
    </p>

    <h2 id="2-navigation">2. Navigation</h2>

    <p>
    Use the navigation panel at the top or bottom. Sections include:
        <ul>
        <li>Home</li>
        <li>Analysis</li>
        <li>Results</li>
        <li>Contact</li>
        </ul></li>
    </p>

    <h2 id="3-uploading-data">3. Uploading Data</h2>
    <p>
     Go to the <strong>Analysis</strong> tab. Choose Microarray or RNA-seq analysis. Drag and drop or click to upload your file (.tsv, .txt).
    </p>

    <h2 id="4-setting-input-parameters">4. Setting Input Parameters</h2>

    <p>After upload, configure:
    <strong>Compare Column Range</strong>: e.g., for 4 samples comparing 2 vs 2 → Control: 1–2, Experiment: 3–4
    <strong>Alpha Value</strong>: significance threshold, e.g., 0.05
    <strong>Voting Cutoff</strong>: number of methods that must agree a gene is differentially expressed
    <ul>
    <li>Microarray: 1–5</li>
    <li>RNA-seq: 1–3</li>
    </ul></li>

    </p>

    <h2 id="5-submitting">5. Submitting and Processing the Request</h2>

    <p>
    Click <strong>Submit Request</strong>. Data will be processed using the ensemble framework.
    </p>

    <h2 id="6-exploring-results">6. Exploring Results</h2>

    <p>
    Once complete, visit the <strong>Results Page</strong> to:
    <ul>
    <li>View summary plots (e.g., Heatmap, GO bar plots)</li>
    <li>Download DEG lists and outputs from other selected methods.</li>
    </ul></li>
    </p>

    <hr />

    <h2 id="dgear-algorithm">DGEAR Algorithm</h2>

    <p>DGEAR implements an ensemble model with a modified majority voting algorithm.</p>

    <p>
    <strong>Microarray:</strong>
    Statistical tests: Student’s t-test, ANOVA, Dunnett’s t-test, half t-test, Wilcoxon/Mann-Whitney U-test</li>
    </p>
    <p><strong>RNA-seq:</strong>
    Methods: Linear modeling, negative binomial modeling, empirical Bayes
    </p>


    <p>After FDR correction, results from individual tests are converted to logical vectors, combined via majority voting to determine DEGs.</p>

    <hr />

    <h2 id="important-notes">Important Notes</h2>

    <ul>
    <li>Format: genes as rows, samples as columns</li>
    <li>Set input parameters according to your experimental design</li>
    <li>Internet connection is required</li>
    </ul>

    <hr />

    <!-- <h2  id="project-background">Project Background</h2>

    <p>DGEAR-Web was developed under the academic project titled:</p>

    <blockquote>
    <p>"To Develop an Ensemble Framework for Differential Expression Analysis"</p>
    </blockquote>

    <p>Submitted to the University of North Bengal for the degree of M.Sc. in Bioinformatics by <strong>Koushik Bardhan</strong> (Batch: 2022–2023) under the guidance of <strong>Dr. Chiranjib Sarkar</strong>, Department of Bioinformatics.</p>

    <hr /> -->

    <h2 id="support">Support</h2>

    <p>For issues or suggestions, contact the project team through the communication options provided on the DGEAR-Web platform.</p>

    <hr />

    <h3><strong>Happy Researching with DGEAR!</strong></h3>



    </div>
</body>
</html>
</body>
<?php include 'footer.php';?>
</html>