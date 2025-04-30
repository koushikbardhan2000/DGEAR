<meta name="author" content="Koushik Bardhan">
<meta name="keywords" content="DGEAR, Differential Gene Expression Analysis, Bioinformatics, Web Tool">
<meta name="robots" content="index, follow">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="shortcut icon" href="img/logo.png" alt="DGEAR icon">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<nav>
  <ul class="sidebar">
    <li onclick=hideSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
    <li><a href="index.php">Home</a></li>
    <li><a href="analysis.php">Analysis</a></li>
    <li><a href="results.php">Results</a></li>
    <li><a href="contact.php">Contact Us</a></li>
  </ul>
  <ul>
    <li><a href="index.php"><img class="logo-DGEAR-nav" src="img/logo.png" alt="DGEAR Web-tool Logo">
          <span class="nav-logo-text">DGEAR Web Dashboard<br>Computational Systems Biology Lab.</span>
        </a>
    </li>
    <li class="hideOnMobile"><a href="index.php">Home</a></li>
    <li class="hideOnMobile"><a href="analysis.php">Analysis</a></li>
    <li class="hideOnMobile"><a href="results.php">Results</a></li>
    <li class="hideOnMobile"><a href="contact.php">Contact Us</a></li>
    <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
  </ul>
</nav>

<script>
  function showSidebar() {
    var sidebar = document.querySelector('.sidebar');
    if (sidebar.style.display === 'block') {
      sidebar.style.display = 'none';
    } else {
      sidebar.style.display = 'block';
    }
  }
</script>
<script>
  function hideSidebar() {
    var sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'none';
  }
</script>