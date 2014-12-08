<?php
session_start();
include "../inc/conn.php";
include "../inc/settings.php";
include "object/Article.php";
$action="";
if(isset($_POST['action'])){
	$action=$_POST['action'];
}

switch ($action) {
/** Assign Element
 *  @page_id
 *  @element_id
 */
	case "assignElement":
		$page_id="";
		if(isset($_POST['page_id'])){
			$page_id=$_POST['page_id'];
		}
		$element_id="";
		if(isset($_POST['element_id'])){
			$element_id=$_POST['element_id'];
		}
		if($page_id != "" && $element_id !="" ){
			$query = "INSERT INTO page_content (page_id, elem_id) VALUES ('$page_id', '$element_id')";
			$q_result = $mysqli->query($query);
			echo $mysqli->insert_id;
		}else{
			echo "ERROR: Request Broken! ElementAssignmentService:assignElement";			
		}
	break;
//loadAssignedElements
	case "loadAssignedElements":
		$page_id="";
		if(isset($_POST['page_id'])){
			$page_id=$_POST['page_id'];
		}
		if($page_id != "" ){
			$list = array();
			$i=0;
			$query = "SELECT pc.page_id, pc.elem_id, pc.id AS bond_id, a.id, a.title FROM page_content AS pc, articles AS a 
					WHERE pc.page_id = '$page_id' AND pc.elem_id = a.id";
			$q_result = $mysqli->query($query);
			while ($row = $q_result->fetch_assoc()){
				$record = array(
					"bond_id" => $row['bond_id'],
					"title" => $row['title'],
				);
				$list[$i] = $record;
				$i++;
			}
			echo base64_encode(json_encode($list));
		}else{
			echo "ERROR: Request Broken! ElementAssignmentService:loadAssignedElements";			
		}
	break;
//unassignElement
	case "unassignElement":
		$bond_id="";
		if(isset($_POST['bond_id'])){
			$bond_id=$_POST['bond_id'];
		}
		if($bond_id != "" ){
			$query = "DELETE FROM page_content WHERE id='$bond_id'";
			$q_result = $mysqli->query($query);
		}else{
			echo "ERROR: Request Broken! ElementAssignmentService:unassignElement";			
		}
	break;
}

?>