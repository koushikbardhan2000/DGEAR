<html>
  <head>
    <title>PHP and R Integration Sample</title>
  </head>
  <body>
    <div id="r-output" id="width: 100%; padding: 25px;">
    <?php
      $filename = "samplefile".rand(1,100);
      $exe = '"C:/Program Files/R/R-4.3.1/bin/x64/Rscript.exe" "C:/xampp/htdocs/webtool/temp.R" 6 "temp"';
      exec($exe);
      echo $exe;
      echo "<img src ='temp.png'> ";
	  $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/webtool/uploads/";
	  echo $target_dir;
    ?>
      
    </div>
  </body>
</html>