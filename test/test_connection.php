<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'connection.php';

if ($con) {
    echo "✅ Database connection successful!";
} else {
    echo "❌ Failed to connect: " . mysqli_connect_error();
}
?>
