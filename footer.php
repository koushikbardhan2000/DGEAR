<footer>
  <a href="https://www.nbu.ac.in/"><img class="logo-nbu" src="img/NBUlogo.png" alt="University of North Bengal Logo" width="24" height="24"></a>
  
<p>
  &copy;2024-2025 DGEAR-Web All rights reserved by Computational System Biology Lab | Department of Bioinformatics.<br>
  Last update date: <span id="lastUpdated"></span>
</p>

<script>
  fetch('meta.json')
    .then(res => res.json())
    .then(data => {
      document.getElementById('lastUpdated').textContent = data.lastUpdated;
    })
    .catch(err => {
      console.error("Failed to load update date:", err);
    });
</script>
  
  <a href="https://www.linkedin.com/in/koushik-bardhan-459895225/"><img class="logo-Lin" src="img/inlogo.jpg" alt="Koushik Bardhan linkedin logo" width="24" height="24"></a>
</footer>
