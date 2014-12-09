<?php
include_once "AITGroupObject.php";
class EventType extends AITGroupObject{
	
	public $id="";
	public $name="";
	public $color="";
	public $text_color="";
	
	
	//Load Event Types
	public static function loadEventsTypes(mysqli $mysqli){
		$query="SELECT * FROM event_types";
		$q_result = $mysqli->query($query);
		$i=0;
		$etArray;
		//	$endList="";
		while ($row = $q_result->fetch_assoc()){
			$et = new EventType();
			foreach ($row as $key => $value){
				$et->$key = $value;
			}	
			$etArray[$i]=json_encode($et);
		}
		return base64_encode(json_encode($etArray));
	}
	
}