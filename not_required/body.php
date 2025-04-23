<!DOCTYPE html>
<html>
<head>
  <title>DEG Web-Tool</title>
  <style>
    body {
      background-color:antiquewhite;
      margin: 0;
      box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
    }

    nav {
      background-color: black;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
    }

    nav ul li {
      margin-right: 20px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-size: 18px;
      padding: 7px,13px;
      border-radius: 3px;
      font-weight: bold;
    }
    a.active,a:hover{
      background:white;
      transition: .5s;
      color: #000;
    }
    label.logo{

      color: white;
      font-size: 35px;
      line-height: 80px;
      padding: 0 100px;
      font-weight: bold;
    }

    footer {
      background-color: rgb(0, 0, 0);
      color: rgb(255, 255, 255);
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 70px;
    }

    footer nav ul li {
      margin-right: 10px;
      margin-left: 15px;
    }

    .social-media {
      display: flex;
      align-items: center;
    }

    .social-media a {
      margin-right: 20px;
      color: white;
      text-decoration: none;
    }

    .button{
      width: 90;
      height: 90;
      border-radius: 3px;
      border: 0;
      background-color: black;
      color: aliceblue;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    tbody tr td a {
      text-decoration: none;
      color: black;
      font-size: 18px;
      padding: 7px,13px;
      border-radius: 3px;
      font-weight: bold;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }

    .main-content {
      height: calc(100vh - 80px);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .left-section {
      width: 50%;
      padding: 20px;
      box-sizing: border-box;
    }
    
    .right-section {
      width: 50%;
    }
    
    .left-section p {
      color: #fff;
      font-size: 22px;
    }
    
    .right-section img {
      width: 50%;
      height: auto;
    }

  </style>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <nav>
    <label class="logo">DEG Web-Tool</label>
    <ul>
      <li><a class = "active" href="http://localhost/webtool/index.html">Home</a></li>
      <li><a href="http://localhost/webtool/analysis.php">Analysis</a></li>
      <li><a href="http://localhost/webtool/results.php">Results</a></li>
      <li><a href="#">Contact Us</a></li>
    </ul>
  </nav>
  <div style="margin: 20px; background-color:rgb(253, 253, 253); padding: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
  <div class="main-content">
    <div class="left-section">
      <h2>HI! Welcome to DEG-WEBTOOL,<h2>
      <h3>A platform focusing on an Ensemble based integrative analysis for the prediction of Differentially expressed genes from the Gene Expression data and making it easier, so that those troublesome intermediate steps no longer trouble any academic.

Let our academic research become pure and help our academic career.</h3>
    </div>
    <div class="right-section">
      <img src="img.png" alt="Image">
    </div>
  </div>
  </div>

  <footer>
    <nav>
      <ul style="list-style: none; display: flex; margin-left: 20; padding: 0;margin-right: 20px;">
        <li><a class = "active" href="http://localhost/webtool/index.html">Home</a></li>
        <li><a href="http://localhost/webtool/analysis.php">Analysis</a></li>
        <li><a href="http://localhost/webtool/results.php">Results</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </nav>
    <p>&copy; 2023-2024 DEG Web-Tool. All rights reserved.</p>
    <div class="social-media">
      <h3>Connect through:</h3>
      <a href="https://www.linkedin.com/in/koushik-bardhan-459895225/"><img src="linkedinLogo.jpg" alt="Social Media" width="24" height="24"></a>
    </div>
  </footer>
</body>
</html>
