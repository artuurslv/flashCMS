<?php
include_once "AITGroupObject.php";
class GaleryService extends AITGroupObject{
	public $id="";
	public $title="";
	public $cover_img="";
	
	//Creates an Album -> Returns article ID
	public static function createAlbum($title, mysqli $mysqli){
		$query="INSERT INTO albums (title) VALUES ('$title');";
		$mysqli->query($query);
		return  $mysqli->insert_id;
	}
//Load Album list
	public static function loadAlbumList(mysqli $mysqli){
		//SELECT id, image FROM `album_images` WHERE album_id = 1 order by id DESC LIMIT 1
		$query="SELECT * FROM albums order by id desc";
		$q_result = $mysqli->query($query);
		$i=0;
		$menuArray="";
		while ($row = $q_result->fetch_assoc()){
			$article = new GaleryService();
			foreach ($row as $key => $value){
				$article->$key = $value;
			}
			$menuArray[$i]=json_encode($article);
			$i++;
		}
		return base64_encode(json_encode($menuArray));
	}
//Load album Content
	public static function loadAlbum($id, mysqli $mysqli){
		$query="SELECT a.id, i.id, i.title, i.image, i.album_id FROM albums AS a, album_images AS i WHERE a.id = i.album_id AND i.album_id = ".$id." Order By i.id DESC";
		$q_result = $mysqli->query($query);
		$i=0;
		$menuArray="";
		while ($row = $q_result->fetch_assoc()){
			$menuArray[$i]=json_encode($row);
			$i++;
		}
		return base64_encode(json_encode($menuArray));
	}
//save Image
	public static function addImageToAlbum($album_id, $title, $image, mysqli $mysqli){
		if($title == null){
			$title="";
		}
		$query="INSERT INTO album_images (title, image, album_id) VALUES ('$title', '$image', '$album_id');";
		$mysqli->query($query);
		$resultId = $mysqli->insert_id;
		$q2 = "Update albums set cover_img = '$image' where id='$album_id'";
		$mysqli->query($q2);
		return  $resultId;
	}
//Delete image
	public static function deleteImage($id, mysqli $mysqli){
		$query="SELECT image FROM album_images WHERE id = '$id'";
		$res = $mysqli->query($query);
		$name = $res->fetch_assoc();
		$query2 = "DELETE FROM album_images WHERE id = '$id'";
		$res = $mysqli->query($query2);
		
		return $name['image'];
	}
//Delete Album
	public static function deleteAlbum($id, mysqli $mysqli){
		$query="SELECT image FROM album_images WHERE album_id = '$id'";
		$res = $mysqli->query($query);
		$imageArr = "";
		$i=0;
		while($name = $res->fetch_assoc()){
			$imageArr[$i] = $name['image'];
			$i++;
		}
		$query2 = "DELETE FROM album_images WHERE album_id = '$id'; ";
		$query2 .="DELETE FROM albums WHERE id = '$id'";
		$res = $mysqli->multi_query($query2);
	
		return $imageArr;
	}
}?>