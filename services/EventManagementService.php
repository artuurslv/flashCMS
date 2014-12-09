<?php

session_start();
include "../inc/conn.php";
include "../inc/settings.php";
include "object/Event.php";
$action="";
if(isset($_POST['action'])){
	$action=$_POST['action'];
}

switch ($action) {
//loadEventShcedule
	case "loadschedule":
		echo Event::loadEventsSchedule($mysqli);
		break;
//Create Event
	case "create":
		if(isset($_POST['event'])){ 
			echo Event::create($_POST['event'], $mysqli);
		}else{
			echo "ERROR: Request Broken! ArticleManagementService:create";			
		}
	break;
//Assign Article To Event
	case "assignArticle":
		if(isset($_POST['event_id']) && isset($_POST['article_id'])){
			echo Event::assignArticle($_POST['event_id'], $_POST['article_id'], $mysqli);
		}
		break;
//Load Assigned Article ID
	case "getAssignedArticleId":
		if(isset($_POST['event_id'])){
			echo  Event::getAssignedArticleId($_POST['event_id'], $mysqli);
		}
		break;
//Update Event  Details		
	case "updateDetails":
		if(isset($_POST['event'])){
			$event = $_POST['event'];
			echo Event::updateEventDetails($event, $mysqli);
		}
		break;
//Update TITLE
		case "updateTitle":
			if(isset($_POST['event_id']) && isset($_POST['title'])){
				echo Event::updateEventTitle($_POST['title'], $_POST['event_id'], $mysqli);
			}
			break;
//Delete EVENT
	case "deleteEvent":
		if(isset($_POST['event_id'])){
			echo Event::deleteEvent($_POST['event_id'], $mysqli);
		}		
		break;
	case "loadEventArticle":
		if(isset($_POST['event_id'])){
			echo Event::loadEventArticle($_POST['event_id'], $mysqli);
		}
		break;
		
}

?>