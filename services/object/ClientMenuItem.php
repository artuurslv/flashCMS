<?php
include_once "AITGroupObject.php";
class ClientMenuItem extends AITGroupObject{
	public $id="";
	public $name="";
	public $link ="";
	public $pos="none";
	public $is_static=false;
	public $is_hidden=false;
	public $mysqli="";
	
	function __construct(mysqli $conn){
		$this->mysqli = $conn;
	}
	//Adds menu item
	public static function addMenuItem($name, $hidden, $isStatic, mysqli $conn){
		$item = new ClientMenuItem($conn);
		$item->setName($name);
		$item->generateLink();
		$query="INSERT INTO client_menu (name, link, is_hidden, is_static) VALUES ('$item->name', '$item->link', '$hidden', '$isStatic');";
		$query .="INSERT INTO page_content (page_id) VALUES (LAST_INSERT_ID())";
		$item->saveData($query, true);
		$item->id = $item->mysqli->insert_id;
		return $item->id;
	}
	//Edits menu item
	public static function editMenuItem($id, $name,$hidden, $isStatic, mysqli $conn){
		$item = new ClientMenuItem($conn);
		$item->id = $id;
		$item->setName($name);
		$item->generateLink();
		$query="UPDATE client_menu SET name='$item->name', link='$item->link',is_static='$isStatic',is_hidden='$hidden' WHERE id='$item->id'";
		$item->saveData($query,false);
		return true;
	}
	//Load Menu
	public static function loadFullMenu(mysqli $mysqli){
		$query="SELECT * FROM client_menu ORDER BY position ASC";
		$q_result = $mysqli->query($query);
		$i=0;
		$menuArray;
		while ($row = $q_result->fetch_assoc()){
			$item = new ClientMenuItem($mysqli);
			foreach ($row as $key => $value){
				$item->$key = $value;
			}
			$menuArray[$i]=json_encode($item);
			$i++;
		}
		return base64_encode(json_encode($menuArray));
	}
	private function generateLink(){
		$this->link=strtolower($this->clean($this->name));
	}
	public function clean($string) {
		$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	public function setName($name){
		if(strlen(trim($name)) > 2){
			$this->name = $name;
		}
	}
	public function getName(){
		return $this->name;
	}
}?>