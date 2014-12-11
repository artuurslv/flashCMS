<?php
include_once "AITGroupObject.php";
class Event extends AITGroupObject{
	public $id="";
	public $title="";
	public $start="";
	public $end="";
	public $allDay="";
	public $event_id="";
	public $color="";
	public $text_color="";
		
	function __construct(){
	}
//Creates an article -> Returns article ID
	public static function create($eventZip, mysqli $mysqli){	
		$event = json_decode(base64_decode($eventZip));
		$eventTypes = json_decode(base64_decode($_SESSION['eventTypes']));
		$color = "";
		$text_color ="";
		for($x=0; $x<count($eventTypes); $x++){
			$et = json_decode($eventTypes[$x]);
			if($et->id == $event->type_id){
				$color = $et->color;
				$text_color = $et->text_color;
			}
		}
		//Save regular event
		$stmt = $mysqli->prepare('INSERT INTO events (type_id, title) VALUES( ? , ?)');
		$stmt->bind_param('is', intval($event->type_id),$event->title);
		$stmt->execute();
		$event_id = $stmt->insert_id;
		$stmt->free_result();
		//Save To Schedule
		$eventArray;
		
		if($event->type_id == 1){
			for($i=0; $i<$event->freq; $i++){
				$add = $i * 7;
				$start_time = strtotime($event->start.'+'.$add.'DAYS');
				$end_time = strtotime($event->end.'+'.$add.'DAYS');
				$start = date("Y-m-d H:i", $start_time);
				$end = date("Y-m-d H:i", $end_time);
				
				$stmt = $mysqli->prepare('INSERT INTO event_schedule (event_id, start, end, allDay) VALUES (?, ?, ?, ?)');
				$stmt->bind_param('issi', $event_id, $start, $end, intval($event->allDay));
				$stmt->execute();
				$shed_id = $stmt->insert_id;
				
				
				$newEvent = new Event();
				$newEvent->id = $shed_id;
				$newEvent->title = $event->title;
				$newEvent->start = $start;
				$newEvent->end = $end;
				$newEvent->allDay = $event->allDay;
				$newEvent->event_id = $event_id;
				$newEvent->color = $color;
				$newEvent->text_color = $text_color;
				$eventArray[$i]=json_encode($newEvent);
			}
			$stmt->close();
		}else{
			$stmt = $mysqli->prepare('INSERT INTO event_schedule (event_id, start, end, allDay) VALUES( ? , ?, ?, ?)');
			$stmt->bind_param('issi', $event_id, $event->start, $event->end, intval($event->allDay));
			$stmt->execute();
			$shed_id = $stmt->insert_id;
			$stmt->close();
			
			$newEvent = new Event();
			$newEvent->id = $shed_id;
			$newEvent->title = $event->title;
			$newEvent->start = $event->start;
			$newEvent->end = $event->end;
			$newEvent->allDay = $event->allDay;
			$newEvent->event_id = $event_id;
			$newEvent->color = $color;
			$newEvent->text_color = $text_color;
			$eventArray[0]=json_encode($newEvent);
		}
		
		return base64_encode(json_encode($eventArray));
	}
//Loads article list
	public static function loadEventsSchedule(mysqli $mysqli){
		$query="SELECT s.id AS sched_id, s.event_id, s.start, s.end, s.allDay, e.id, e.type_id, e.title, t.id, t.color, t.text_color
				FROM event_schedule AS s,
				events AS e, event_types AS t
				WHERE s.event_id = e.id
				AND e.type_id = t.id";
		$q_result = $mysqli->query($query);
		if($q_result === false){
			echo "Query failed...";
		}else{
			$i=0;
			$eventArray="";
			while ($row = $q_result->fetch_assoc()){
				$event = new Event();
				$event->id = $row['sched_id'];
				$event->title = $row['title'];
				$event->start = $row['start'];
				$event->end = $row['end'];
				$event->allDay = $row['allDay'];
				$event->event_id = $row['event_id'];
				$event->color = $row['color'];
				$event->text_color = $row['text_color'];
				$eventArray[$i]=json_encode($event);
				//$endList = $endList.$i.". -> ".$event->end."<br />";
				$i++;
			}
			return base64_encode(json_encode($eventArray));
		}
	}

//update Event Details
	public static function updateEventDetails($jsonedEvent, mysqli $mysqli){
		$event = json_decode(base64_decode($jsonedEvent));
		$stmt = $mysqli->prepare('UPDATE event_schedule SET start = ?, end = ?, allDay = ? WHERE id = ?');
		$stmt->bind_param('ssii', $event->start, $event->end, intval($event->allDay), $event->id);
		$stmt->execute();
		$res = $stmt->affected_rows;
		$stmt->close();
		return $res;
	}
//update Event Title
	public static function updateEventTitle($title, $event_id, mysqli $mysqli){
		$stmt = $mysqli->prepare('UPDATE events SET title = ? WHERE id = ?');
		$stmt->bind_param('si', $title, intval($event_id));
		$stmt->execute();
		$res = $stmt->affected_rows;
		$stmt->close();
		return $res;
	}
//Assign article To Event
	public static function assignArticle($event_id, $article_id, mysqli $mysqli){
		$stmt = $mysqli->prepare('UPDATE events SET article_id =? WHERE id = ?');
		$stmt->bind_param('ii', intval($article_id), intval($event_id));
		$stmt->execute();
		$res = $stmt->affected_rows;
		$stmt->close();
		return $res;
	}
//getAssignedArticleId
	public static function getAssignedArticleId($event_id, mysqli $mysqli){
		$query = "SELECT article_id FROM events WHERE id=".$event_id;
		$q_result = $mysqli->query($query);
		$result = $q_result->fetch_assoc();
		return $result['article_id'];
	}
//Delete Event
	public static function deleteEvent($event_id, mysqli $mysqli){
		$query="DELETE FROM event_schedule WHERE event_id = '$event_id'; ";
		$query .= "DELETE FROM events WHERE id = '$event_id'";
		$res = $mysqli->multi_query($query);
		
		return $res;
	}
//getAssignedArticleId
	public static function loadEventArticle($event_id, mysqli $mysqli){
		$query = "SELECT e.article_id, a.id, a.text FROM events AS e, articles AS a WHERE e.id ='$event_id' AND e.article_id = a.id";
		$q_result = $mysqli->query($query);
		$result = $q_result->fetch_assoc();
		return $result['text'];
	}
	public static function loadClosesEvent(mysqli $mysqli){
		$now = date("Y-m-d");
		$query = "SELECT e.title, e.id, s.event_id, s.start FROM events as e, event_schedule as s where s.event_id=e.id ORDER BY s.start";
		$q_result = $mysqli->query($query);
		$title = "none";
		$id = "";
		while($result = $q_result->fetch_assoc()){
			$time =strtotime($result['start']);
			$start = date("Y-m-d", $time);
			if($start > $now){
				$title = $result['title'];
				$id = $result['event_id'];
				break;
			}			
		}
		
		return $title."//".$id;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}
	public function setTitle($title){
		if(strlen(trim($title)) > 2){
			$this->title = $title;
		}
	}
	public function getTitle(){
		return $this->title;
	}
}?>