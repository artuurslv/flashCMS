<?php

// AITGroup Parent Object

class AITGroupObject{	
	
	public function expose() {

		return get_object_vars($this);

	}
//Converts standart class to your object
	public function getFromStand($stnd){
		foreach ($stnd as $key => $value){
			$this->$key = $value;
		}
	}
// Converts asociative array to your object	
//MUST HAVE mysqli parameter
	public function fetchObjFromBD($query){
		$q_result = $this->mysqli->query($query);
		$result = $q_result->fetch_assoc();
		foreach ($result as $key => $value){
			$this->$key = $value;
		}
	}
//Converts object to string!
//IMPORTANT: mysqli MUST be the last parameter in the param list!
	public function toString(){
		$res = "";
		foreach ($this as $key => $value){
			if($key == "mysqli"){
				break;
			}
			$res .= $key." = ". $value."<br />";
		}
		return $res;
	}	
	public function printLn($msg){
		echo $msg."<br />";
	}
	
//returns associative array from DB	
//MUST HAVE mysqli parameter
	public function getAsociatArray($query){
		$q_result = $this->mysqli->query($query);
		$i=0;
		$skillArray;
		while ($row = $q_result->fetch_assoc()){
			$skillArray[$i]=$row;
			$i++;
		}
		return $skillArray;
	}
//Executes query and returns error is smth is wrong with connection..
	public function saveData($q, $isMulti){
		if($isMulti){
			try{
				if($res = $this->mysqli->multi_query($q)){
					return "saved";
				}
			}catch (Exception $e){
				return new Exception( 'Something really gone wrong', 0, $e);
			}	
		}else{
			try{
				if($res = $this->mysqli->query($q)){
					//$res->close();
					return "saved";
				}
			}catch (Exception $e){
				return new Exception( 'Something really gone wrong', 0, $e);
			}
		}
	}
//Dont forget to validate your objects
	public function isValid(){
		//implement validation
	}

}

//json_encode(AppForm->expose()); // KonvertÄ“ uz JSON objektu

//$result = json_decode($someJsonText); //KonvertÄ“ no JSON uz Standartu

//AppForm.getFromStand($result); // No standarta uz paÅ¡taisÄ«to php

?>