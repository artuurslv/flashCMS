<?php
session_start();
include "object/Login.php";	
include "../inc/conn.php";
include "../inc/settings.php";
include "object/ClientMenuItem.php";
include "object/Article.php";
include "object/Event.php";
include "object/EventType.php";
include "object/GaleryService.php";

$prelogin=$_POST['login']; // Sa�em datu objektu ar vienu POST
$result = json_decode($prelogin); // Atkod� objektu, $result ir standarta php objekts
$login = new Login($mysqli); // Izveido jaunu  formas objektu
$login->getFromStand($result); // P�rtaisa standarta objektu par pa�tais�to formas objektu

$valid = $login->isValid(); // iziet valid�ciju
if($valid == "valid"){ 
	if($login->getUserId() == "admin"){
		echo "ADMIN: LOGIN SUCCESS!";
		$_SESSION['signed']=true;
	}
	echo "MENU:".ClientMenuItem::loadFullMenu($mysqli);
	echo "ARTICLES:".Article::loadArticleList($mysqli);
	echo "ALBUMS:".GaleryService::loadAlbumList($mysqli);
}else{
	echo $valid;
}
?>