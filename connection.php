<?php
$host = "192.168.0.165";  
$user = "ksk";  
$password = '326500';  
$db_name = "dgear"; 

$con = mysqli_connect($host, $user, $password, $db_name);  

if (mysqli_connect_errno()) {
    header("Location: error.php");
    exit();
}
?>
