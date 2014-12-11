<?php
session_start();
include "../inc/conn.php";
include "../inc/settings.php";
include "object/GaleryService.php";
include "object/reSize.php";
$action="";
if(isset($_POST['action'])){
	$action=$_POST['action'];
}
$UPLOAD_PATH_ORIGINAL = "../upload/galery/original/";
$UPLOAD_PATH_SMALL = "../upload/galery/small/";

switch ($action) {
//create album
	case "createAlbum":
		if(isset($_POST['title'])){
			echo GaleryService::createAlbum($_POST['title'], $mysqli);
		}
		break;
//load Client page
		case "loadAlbumList":
			$albumListBased = GaleryService::loadAlbumList($mysqli);
			
			$albumList = json_decode(base64_decode($albumListBased));
			$elemCount = count($albumList);
			$lastElemSoned=$albumList[$elemCount-1];
			$lastElem = json_decode($lastElemSoned);
			
			$latestAlbumContent = GaleryService::loadAlbum($lastElem->id, $mysqli);
			
			echo $albumListBased."CONTENT:".$latestAlbumContent;
						
			break;
//load Client page
			case "loadAlbumListClient":
				$albumListBased = GaleryService::loadAlbumList($mysqli);
				echo $albumListBased;
			
				break;
//load album
	case "loadAlbum":
		if(isset($_POST['id'])){
			echo GaleryService::loadAlbum($_POST['id'], $mysqli);
		}
		break;
//Upload image
		case "uploadImage":		
			if(isset($_FILES["fileToUpload"]) && isset($_POST["album_id"])){
				if(strtolower($_FILES["fileToUpload"]["type"]) == "image/png" || strtolower($_FILES["fileToUpload"]["type"]) == "image/jpeg"){
					$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
					$newName = time()."_".$_FILES["fileToUpload"]["name"];
					move_uploaded_file($tmp_name, $UPLOAD_PATH_ORIGINAL.$newName);
					$params = array(
							'width' => 180,
							'height' => 180
					);
					img_resize($UPLOAD_PATH_ORIGINAL.$newName, $UPLOAD_PATH_SMALL.$newName, $params);
					$title ="";
					if(isset($_POST['title']))
						$title = $_POST['title'];
					$album_id = $_POST["album_id"];
					$image = $newName;
					$id = GaleryService::addImageToAlbum($album_id, $title, $image, $mysqli);
					echo $id."NAME:".$newName;
				}else{
					echo "ERROR: Wrong Format -> ".strtolower($_FILES["fileToUpload"]["type"]);
				}
			}else{
				echo "ERROR: No file";
			}

		break;
//Delete Image
		case "deleteImage":
			if(isset($_POST['id'])){
				$image = GaleryService::deleteImage($_POST['id'], $mysqli);
				unlink($UPLOAD_PATH_ORIGINAL.$image);
				unlink($UPLOAD_PATH_SMALL.$image);
			}
			break;
		case "deleteAlbum":
			if(isset($_POST['id'])){
				$images = GaleryService::deleteAlbum($_POST['id'], $mysqli);
				for($i=0; $i < count($images); $i++){
					echo $images[$i]."\n";
					unlink($UPLOAD_PATH_ORIGINAL.$images[$i]);
					unlink($UPLOAD_PATH_SMALL.$images[$i]);
				}
			}
			break;

}

?>