<?php 
include '../inc/settings.php';
$fold = scandir(PATH_UPLOAD);

for($i=0; $i<count($fold);$i++){
	echo $fold[$i]." ";
}
?>