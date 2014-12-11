<?php
include_once "AITGroupObject.php";
class Article extends AITGroupObject{
	public $id="";
	public $title="";
	public $text="";
	public $mysqli="";
	
	function __construct(mysqli $conn){
		$this->mysqli = $conn;
	}
	//Creates an article -> Returns article ID
	public static function create($title, mysqli $conn){
		$article = new Article($conn);
		$article->setTitle($title);
		$query="INSERT INTO articles (title) VALUES ('$article->title');";
		$article->saveData($query, false);
		$article->id = $article->mysqli->insert_id;
		return $article->id;
	}
	//Loads article list
	public static function loadArticleList(mysqli $mysqli){
		$query="SELECT id, title FROM articles";
		$q_result = $mysqli->query($query);
		$i=0;
		$menuArray;
		while ($row = $q_result->fetch_assoc()){
			$article = new Article($mysqli);
			foreach ($row as $key => $value){
				$article->$key = $value;
			}
			$articleArray[$i]=json_encode($article);
			$i++;
		}
		return base64_encode(json_encode($articleArray));
	}
	//Load single article
	public static function loadArticle($id, mysqli $mysqli){
		$q_result = $mysqli->query("SELECT text FROM articles WHERE id= ".$id);
		while ($row = $q_result->fetch_assoc()){
			return $row['text'];
		}		
	}
	//Delete article
	public static function deleteArticle($id, mysqli $mysqli){
		$article = new Article($mysqli);
		$article->setId($id);
		$query="DELETE FROM articles WHERE id = '$id'; ";
		$query .= "DELETE FROM page_content WHERE elem_id = '$id'";
		$article->saveData($query, true);
	}
	//Update Article
	public static function updateArticle($id, $textbased, mysqli $mysqli){
		$text = base64_decode($textbased);
		$val = $mysqli->prepare("UPDATE articles SET text = ? WHERE id= ?");
		$hasTiny = true;
		$newFrame="";
		while($hasTiny){
			$hasTiny = false;
			$pos = strpos($text,"mce-object-iframe");
			if($pos !== false){ //Found tinyMce classes
				$hasTiny = true;
				//split in 2
				$pos = strpos($text,"data-mce-p-src=");
				$dirtyHead = substr($text, 0, $pos);
				$dirtyFoot = substr($text,$pos);
				//cuts elem from head
				$startPos = strrpos($dirtyHead, "<img", -1);
				$head = substr($dirtyHead, 0, $startPos); //Got head
				$endPos = strpos($dirtyFoot, ">");
				$foot = substr($dirtyFoot, $endPos+1); //Got foot
				$frameStart = substr($dirtyHead, $startPos);
				$frameEnd = substr($dirtyFoot, 0, $endPos+1);
				$newFrame = Article::converToHTMLframe($frameStart.$frameEnd);
				$text = $head." ".$newFrame." ".$foot;
			}
		}
		$val->bind_param('si', $text, intval($id));
		try{
			$val->execute();
		} catch(Exception $e){
			return new Exception( 'ERROR:', 0, $e);
		}
		return "Saved";
	}
	
	private static function converToHTMLframe($fakeFrame){
	//	echo $fakeFrame."\n";
		$stylePos1 = strpos($fakeFrame, "style=\"");
		$style="";
		if(	$stylePos1 !== false){
			$stylePos2 = strpos($fakeFrame, "\"", $stylePos1 + strlen("style=\""));
			$styleLen = $stylePos2 - $stylePos1;
			$style = substr($fakeFrame,$stylePos1, $styleLen+1);//Style
			
		}
		$linkPos1 = strpos($fakeFrame, "p-src=\"");
		$linkPos2 = strpos($fakeFrame, "\"", $linkPos1 + strlen("p-src=\""));
		$link =  substr($fakeFrame, $linkPos1+7, $linkPos2-$linkPos1-7);// Extracting url

		$hwPos1 = strpos($fakeFrame, "height=\"");
		$h="";
		if($hwPos1 !== false){
			$hwPos2 = strpos($fakeFrame, "\"", $hwPos1 + strlen("height=\""));
			$hwlen = $hwPos2 - $hwPos1;
			$h =  substr($fakeFrame, $hwPos1, $hwlen+1);
		}
		$wiPos1 = strpos($fakeFrame, "width=\"");
		$w="";
		if($wiPos1 !== false){
			$wiPos2 = strpos($fakeFrame, "\"", $wiPos1 + strlen("width=\""));
			$wilen = $wiPos2 - $wiPos1;
			$w =  substr($fakeFrame, $wiPos1, $wilen+1);
		}
		
		$newFrame="<iframe src=\"".$link."\" border=\"0\" ".$style." ".$h." ".$w."></iframe>";
	//	echo "newFrame = ".$newFrame."<-VISS\n";
		return $newFrame;
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