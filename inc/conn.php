<?php
//$con=mysql_connect("localhost","pagepitc_pieteta","!])HRf1k8#xF");

	//mysql_select_db("pagepitc_pagepit",$con);
	
	$mysqli = new mysqli("localhost","root","","qconstr");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>