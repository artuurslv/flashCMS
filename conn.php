<?php
$mysqli = new mysqli("localhost","girlington","Girlington2","girlington");
// Check connection
if (mysqli_connect_errno()) 
 {  
echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
 }
?>