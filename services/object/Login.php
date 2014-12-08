<?php

// Pieteikuma formas objekts..

class Login{

	//klienta dati

	public $name;

	public $pass;
	
	private $userId;

	private $mysqli;
	
	
	
	function __construct(mysqli $conn){
		//global $REG_TIMEOUT;
		$this->mysqli = $conn;
	}

	public function expose() {

		return get_object_vars($this);

	}

	//gets from standart class

	public function getFromStand($stnd){

		@$this->name=$stnd->name;

		@$this->pass=$stnd->pass;

	}

	//ValidÄ�cija

	public function isValid(){

		if(strlen($this->name) < 1 && strlen($this->pass) < 1){

			return "ERROR: Please fill all fields!";

		}

		if(!$this->isUsrValid()){

			return "ERROR: login or password incorrect!";

		}

		return "valid";

	}

	private function isUsrValid(){
			if($this->name == "admin" && $this->pass == md5("admin")){			
				$_SESSION['usr']=md5("logged");		
				$this->userId="admin";
				return true;			
			}else{	return false;	}

	}
	
	public function getUserId(){
		return $this->userId;
	}

}

//json_encode(AppForm->expose()); // KonvertÄ“ uz JSON objektu

//$result = json_decode($someJsonText); //KonvertÄ“ no JSON uz Standartu

//AppForm.getFromStand($result); // No standarta uz paÅ¡taisÄ«to php

?>