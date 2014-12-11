<?php 
include "inc/conn.php";
include "services/object/ClientMenuItem.php";

$menu = ClientMenuItem::loadFullMenu($mysqli);
$menu = json_decode(base64_decode($menu));
$menuArr;
$i=0;
foreach ($menu as $value){
	$item = new ClientMenuItem($mysqli);
	$item->getFromStand(json_decode($value));
	$menuArr[$i] = $item;
	$i++;	
} ?>
