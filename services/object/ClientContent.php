<?php
include_once "AITGroupObject.php";
class ClientContent extends AITGroupObject{
	public $id="";
	public $link="";
	public $content ="";
	
	function __construct(){
	}
	//Load Article & Module driven CMS content
	public static function loadPageContent(mysqli $mysqli){
		$query="SELECT m.id as pageid, m.link, m.is_static, pc.page_id, pc.elem_id, a.id, a.text
				FROM client_menu AS m, page_content AS pc, articles AS a
				WHERE pc.page_id = m.id
				AND pc.elem_id = a.id
				AND m.is_static =0";
		$q_result = $mysqli->query($query);
		$i=0;
		$contArray = array();
		while ($row = $q_result->fetch_assoc()){
			$skip = false;
			for($a=0; $a<count($contArray); $a++){
				if($contArray[$a]->id == $row['pageid']){
					$contArray[$a]->content = $contArray[$a]->content.$row['text'];
					$skip = true;
				}
			}
			if(!$skip){
				$item = new ClientContent();
				$item->id = $row['pageid'];
				$item->link = $row['link'];
				$item->content = $row['text'];
				$contArray[$i]=$item;
				$i++;
			}
		}
		return $contArray;
	}
	
	//Load Content
	public static function loadFullMenu(mysqli $mysqli){
		$query="SELECT * FROM page_content";
		$q_result = $mysqli->query($query);
		$i=0;
		$contArray;
		while ($row = $q_result->fetch_assoc()){
			$item = new ClientContent();
			foreach ($row as $key => $value){
				$item->$key = $value;
			}
			$contArray[$i]=$item;
			$i++;
		}
		return $contArray;
	}
}