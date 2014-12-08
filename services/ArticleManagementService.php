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
//Create a new Article
	case "create":
		$title="";
		if(isset($_POST['title'])){
			$title=$_POST['title'];
		}
		if($title != ""){
			$id = Article::create($title, $mysqli);
			echo $id;
		}else{
			echo "ERROR: Request Broken! ArticleManagementService:create";			
		}
	break;
//Load article List
	case "loadList":
		echo Article::loadArticleList($mysqli);
		break;
//Load single Article
	case "loadArticle":
		$id="";
		if(isset($_POST['id'])){
			$id=$_POST['id'];
		}
		if($id != ""){
			echo Article::loadArticle($id, $mysqli);
		}
		break;
//Update Article		
	case "updateArticle":
		$id="";
		if(isset($_POST['id'])){
			$id=$_POST['id'];
		}
		$pageContent="";
		if(isset($_POST['cont'])){
			$pageContent=$_POST['cont'];
		}
		if($id != ""){
			echo Article::updateArticle($id, $pageContent, $mysqli);
		}
		break;
//Delete Article
	case "deleteArticle":
		$id="";
		if(isset($_POST['id'])){
			$id=$_POST['id'];
		}
		if($id != ""){
			echo Article::deleteArticle($id, $mysqli);
		}		
		break;
}

?>