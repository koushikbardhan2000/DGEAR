<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DGEAR-Web | CONTACT US</title>
</head>
<?php include 'header.php';?>
<body>
  <div class="body-div">      
	<h3>Let's Get in Touch</h3>
  <form action="#" method="post" enctype="multipart/form-data">
	
    <label for="name">Your Name:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="email">Your Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="phone">Your Mobile / Phone:</label>
    <input type="tel" id="phone" name="phone">
    
    <label for="attachment">Attachment (if any):</label>
    <input type="file" id="attachment" name="attachment">
    
    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" required></textarea>
    
    <button type="submit">Submit</button>
  </form>
  </div>
  <div class="body-div">
  <h3>Contact Us</h3>
  <p><strong>Contact No.:</strong> +91 353 2699117</p>
  <p><strong>Email:</strong> koushikbardhan2000@gmail.com</p>
  <p><strong>Location:</strong> Department of Bioinformatics, University of North Bengal, Siliguri, Darjeeling, West Bengal, India</p>
  </div>
	<div class="body-div">    
    <h3>Data Safety and Security</h3>
    <p>We prioritize the confidentiality and security of your data. All submitted information is handled with strict security measures, ensuring protection against unauthorized access.</p>
    
    <h3>Acknowledgement</h3>
    <p>The DGEAR project is developed and maintained by <strong>Computational System Biology Laboratory</strong>, led by experts from the Department of Bioinformatics, University of North Bengal.</p>


  </div>
</body>
<?php include 'footer.php';?>
</html>
