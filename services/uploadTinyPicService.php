<?php
include '../inc/settings.php';
if(isset($_FILES["fileToUpload"])){
	if(strtolower($_FILES["fileToUpload"]["type"]) == "image/png" || strtolower($_FILES["fileToUpload"]["type"]) == "image/jpeg"){
		$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
		move_uploaded_file($tmp_name, "../upload/".$_FILES["fileToUpload"]["name"]);
		echo "saved";
	}else{
		echo "ERROR: Wrong Format";
	}
}else{
	echo "ERROR: No FILE";
}
?>