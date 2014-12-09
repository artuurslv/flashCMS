<?php
session_start();	
include "../inc/conn.php";
include "../inc/settings.php";
include "object/ClientMenuItem.php";
$action="";
if(isset($_POST['action'])){
	$action=$_POST['action'];
}

switch ($action) {
//Adding new Item to Menu
//Request name of menu item
	case "addMenu":
		$name = "";
		if(isset($_POST['name'])){
			$name=$_POST['name'];
		}
		$hidden = false;
		if(isset($_POST['isHidden'])){
			if($_POST['isHidden'] == "1"){
				$hidden=true;
			}
		}
		$isStatic = false;
		if(isset($_POST['isStatic'])){
			if($_POST['isStatic'] == "1"){
				$isStatic=true;
			}
		}
		if(strlen($name) >2){
			echo ClientMenuItem::addMenuItem($name, $hidden, $isStatic, $mysqli);
		}
		break;
//Deleting Menu items
// Request = string of IDs [12 13 78]
	case "deleteMenu":
		$idStr = "";
		if(isset($_POST['id'])){
			$idStr=$_POST['id'];
		}
		
		$query="DELETE FROM client_menu WHERE id = '$idStr'; ";
		$query .= "DELETE FROM page_content WHERE page_id = '$idStr'";
		if($res = $mysqli->multi_query($query)){
				do {
					/* Must free all results, or next queries wont work.. */
					if ($result =  $mysqli->store_result()) {
						$result->free();
					}
					 $mysqli->more_results();
				} while ( $mysqli->next_result());
				echo "true";
			}else{
				echo "Query failed.";
			}
		break;
// Loading Client Menu
//Blank request 
	case "loadMenu":
		echo ClientMenuItem::loadFullMenu($mysqli);
		break;
//Edit Menu
	case "editMenu":
			$idStr = "";
			if(isset($_POST['id'])){
				$idStr=$_POST['id'];
			}
			$name = "";
			if(isset($_POST['name'])){
				$name=$_POST['name'];
			}
			$hidden = false;
			if(isset($_POST['isHidden'])){
				if($_POST['isHidden'] == "1"){
					$hidden=true;
				}
			}
			$isStatic = false;
			if(isset($_POST['isStatic'])){
				if($_POST['isStatic'] == "1"){
					$isStatic=true;
				}
			}
			$status = ClientMenuItem::editMenuItem($idStr, $name,$hidden, $isStatic, $mysqli);
			if($status === true){
				echo "true";
			}else{
				echo $status;	
			}
		break;	
//Menu Sorting
		case "sortMenu":
			$idStr = "";
			if(isset($_POST['id'])){
				$idStr=$_POST['id'];
			}
			$ids = explode(" ", $idStr);
			$i=0;
			$update_query="";
			$arr_size = count($ids);
			foreach($ids as $value) {
				$i++;
				if($i<$arr_size){
					$update_query .= "UPDATE client_menu SET position = ".$i." WHERE id=".$value."; ";
				}
			}
			$update_query = substr($update_query, 0, -2);
			if($res = $mysqli->multi_query($update_query)){
				do {
					/* Must free all results, or next queries wont work.. */
					if ($result =  $mysqli->store_result()) {
						$result->free();
					}
					 $mysqli->more_results();
				} while ( $mysqli->next_result());
				echo "true";
			}else{
				echo "Query failed.";
			}
			
		break;
	default:
		echo "Service Call has been broken.";
}
?>