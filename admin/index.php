<?php
include "../inc/settings.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AITGroup Admin</title>
<?php include "../inc/ait_header.php";?>
<link rel="stylesheet" href="<?php echo PATH_SITE;?>css/cms/aitgroup/ait_admin.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH_SITE;?>css/cms/aitgroup/responsive_admin.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo PATH_SITE;?>css/cms/modules/jquery/jquery.datetimepicker.css"/>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/customsite/aitgroup_custom.js"></script>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/aitgroup/CmsViewRenderer.js"></script>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/modules/jquery/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/aitgroup/functions/menu_management_functions.js"></script>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/aitgroup/functions/articles_functions.js"></script>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/aitgroup/functions/galery_functions.js"></script>
<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>
</head>

<body onload="findCont()" >
<?php 
if(isset($_SESSION['signed']) && $_SESSION['signed'] === true ){
?>
<div id="ait_blanket" style="display:none;">&nbsp;</div>
<div id="ait_loader_txt" style="display:none;">&nbsp;</div>
<div id="ait_loader" class="ait_loaderImg" style="display:none;" >
	<img src="<?php echo PATH_SITE;?>img/loading.gif" alt="Loaging.." height="50" width="50" />
</div>

<div id="wrapper">
	<div class="headCont">
		<div class="widthWrap widthWrapRight">
			<div style="float:right;color: #fff;cursor:pointer" id="ait_logoutBtn" >logout</div>
			<h2 style="color:#fff">Welcome to Administration panel</h2>
		</div>	
	</div>
			
	<div class="content widthWrap widthWrapRight" id="pageContent">
		<div class="leftSide">
			<div class="menu">
				<ul>
					<li onclick="navigate('home')">Home</li>
					<li onclick="navigate('menu')">Page Management</li>
					<li onclick="navigate('articles')">Articles</li>
					<li onclick="navigate('galery')">Gallery</li>
				</ul>
			</div>
		</div>
		<div class="rightSide">
			<div class="ait_menu" id="home">
				<?php include "places/home_view.php"; ?>
			</div>
			<div class="ait_menu" id="articles">
				<?php include "places/articles_view/articles_view.php"; ?>
			</div>
			<div class="ait_menu" id="menu">
				<?php include "places/menu_view/menu_view.php"; ?>
	
			</div>
			<div class="ait_menu" id="galery">
				<?php include "places/galery_view/galery_view.php"; ?>
			</div>
		</div>
	</div>	
	<?php }else{ 
		include "signIn.php";
	}?>
</div>
<div id="footer">
	<div class="widthWrap" style="overflow: hidden">
		<div class="section">
			<div class="title">Contact us</div>
			<div class="contact">Social media: 
				<a href="http://www.facebook.com" target="_blank" title="Our Facebook Profile"><img class="socImg" src="<?php echo PATH_SITE;?>img/facebook.jpg" alt="facebook"/></a> &nbsp;
				<a href="http://www.instagram.com" target="_blank" title="Our Instagram Profile"><img class="socImg" src="<?php echo PATH_SITE;?>img/instagram.jpg" alt="instagram"/></a> 
			</div>
			<div class="contact">Phone: 07555 555555</div>
			<div class="contact">Email: info@girlingtoncenter.co.uk</div>
			<div class="contact">Online: <a href="#home" title="Complete this online form and we will get back to you as soon as we can">Complete this form</a></div>
		</div>
		<div class="section">
			<div class="title">Site information</div>
			<div class="contact link" onclick="navigate('termsandconditions')">Terms and Conditions</div>
			<div class="contact link" onclick="navigate('privacypolicy')">Privacy Policy</div>
			<div class="contact">Created by: <a href="http://aitgroup.co.uk" target="_blank" title="Site designed and created by AitGroup" >AitGroup</a></div>
		</div>
	</div>
</div>	
</body>
</html>