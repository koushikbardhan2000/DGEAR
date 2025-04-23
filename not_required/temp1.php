<!DOCTYPE html>
<html>
<head>
  <title>Website Title</title>
  <style>
    /* Header Styles */
    header {
      background-color: #000;
      color: #fff;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    header img.logo-left {
      width: 120px;
      margin-left: 20px;
    }
    
    header img.logo-right {
      width: 80px;
      margin-right: 20px;
    }
    
    header h1 {
      text-align: center;
      margin: 0;
    }
    
    /* Main Content Styles */
    .main-content {
      background-color: green;
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
    
    /* Footer Styles */
    footer {
      background-color: #f1f1f1;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    footer .footer-left {
      margin-left: 20px;
    }
    
    footer .footer-right {
      margin-right: 20px;
    }
  </style>
</head>
<body>
  <header>
    <img src="logo-left.png" alt="Left Logo" class="logo-left">
    <h1>University of North Bengal</h1>
    <img src="logo-right.png" alt="Right Logo" class="logo-right">
  </header>

  <div class="main-content">
    <div class="left-section">
      <h2>HI! Welcome to DEG-WEBTOOL,<h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada elit eget lobortis volutpat. Proin volutpat neque et tempor congue. Fusce rhoncus posuere tristique. In maximus interdum lorem, sit amet aliquam lectus sagittis ut. Curabitur dictum justo et pharetra consectetur. Duis id ante augue.</p>
    </div>
    <div class="right-section">
      <img src="img.png" alt="Image">
    </div>
  </div>

  <footer>
    <div class="footer-left">
      <!-- Navigation Panel goes here -->
    </div>
    <div class="footer-right">
      <h3>Connect through:</h3>
      <!-- Social Media Logo goes here -->
    </div>
  </footer>
</body>
</html>
