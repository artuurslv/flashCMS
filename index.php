<?php 
include "inc/settings.php";
include "places/parts/menuLoader.php"; //Loads menu and gives you $menuArr, that is an array or ClientMenuItem objects
include "services/object/ClientContent.php"; 
include "services/object/Article.php";
$contArr = ClientContent::loadPageContent($mysqli); //Loads content of all pages and gives you $contArr, that is an array or ClientContent objects

?>
<!DOCTYPE html>
<html>
<head>
<meta name="keywords" content="girlington, advice centre, bradford, girlington advice centre, gatc bradford" />
<meta name="robots" content="index,follow" />
<meta name="description" content="Girlington Advice and Training Centre in Bradford specialises in advice in benefits, debt and housing." />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
	<title>Girlington Advice Centre</title>
	<link rel="shortcut icon" href="<?php echo PATH_SITE;?>favicon.ico" type="image/png">
	<?php include "inc/ait_header.php";?>
	<script type="text/javascript" src="<?php echo PATH_SITE;?>js/customsite/aitgroup_custom.js"></script>
	<script type="text/javascript" src="<?php echo PATH_SITE;?>js/customsite/CustomViewRenderer.js"></script>
	<script src="<?php echo PATH_SITE;?>js/cms/modules/jquery/jssor.core.js" ></script>
    <script src="<?php echo PATH_SITE;?>js/cms/modules/jquery/jssor.utils.js" ></script>
    <script src="<?php echo PATH_SITE;?>js/cms/modules/jquery/jssor.slider.js" ></script>
    <script src="<?php echo PATH_SITE;?>js/customsite/functions/slider_functions.js" ></script>	
	<link rel="stylesheet" href="<?php echo PATH_SITE;?>css/project_style.css" type="text/css" />
    <script src="<?php echo PATH_SITE;?>js/customsite/functions/pastPictures_functions.js" ></script>
</head>

<body>
<!-- Required by CMS !
	The loading ait_blanket, that covers content while ajax is called.
-->
<div id="ait_ait_blanket" style="display:none;">&nbsp;</div>
<div id="ait_ait_loader_txt" style="display:none;">&nbsp;</div>
<div id="ait_loader" class="ait_loaderImg" style="display:none;" >
	<img src="<?php echo PATH_SITE;?>img/loading.gif" alt="Loaging.." height="50" width="50" />
</div>
<!-- / Required by CMS -->
<div id="wrapper"> 
	<div class="header">
			<div class="logo" onclick="navigate('home')">
				<img alt="LOGO" src="<?php echo PATH_SITE;?>/img/landscape/logo.png" style="margin-top:20px; width:350px;">
			</div>
			
			<div class="reg_menu">
				<ul class="ait_center">
					<?php foreach($menuArr as $item){
							if(!$item->is_hidden){?>
							<li id="menu_<?php echo $item->link; ?>" onclick="navigate('<?php echo $item->link; ?>')"><?php echo $item->name; ?></li>
					  <?php  }
						   } ?>
				</ul>
			</div>
	</div>
	<div class="content widthWrap widthWrapRight">
		
					<?php foreach ($contArr as $content){ ?>
						<div class="ait_menu" id="<?php echo $content->link; ?>">
							<?php echo $content->content; ?>				
						</div>
					<?php } ?>
					
					<div class="ait_menu" style="margin-left: -15px;" id="home">
						<?php include 'places/home.php';?>
					</div> 
					<div class="ait_menu" id="signin">
						<?php include 'admin/signIn.php';?>
					</div>  
					<div class="ait_menu" id="projectgallery">
						<?php include 'places/galleryView.php';?>
					</div>
					<div class="ait_menu" style="margin-left: -15px;" id="contactus">
						<?php include 'places/getInTouch.php';?>
					</div>
		</div>
				
			<script type="text/javascript">
		findCont();
		</script>

<div id="footer">
	<div class="ait_center" style="overflow: hidden">
		<div class="section">
			<div class="title"> Site Map</div>
			<ul>
				<?php foreach($menuArr as $item){
						if(!$item->is_hidden){?>
							<li id="menu_<?php echo $item->link; ?>" onclick="navigate('<?php echo $item->link; ?>')"><?php echo $item->name; ?></li>
				<?php 	}
				 	} ?>
				 	
			</ul>
		</div>
		<div class="section">
			<div class="title">Contact us</div>
			<div class="contact">Phone: 01274 547118</div>
			<div class="contact">Email: 01274 547831</div>
			<div class="title">Partners: </div>
			<div class="contact">Logo1</div>
			<div class="contact">Logo2</div>
		</div>
		<div class="section">
			<div class="title">Site information</div>
			<div class="contact link" onclick="navigate('signin')">Sign in</div>
			<div class="contact">Created by: <a href="http://aitgroup.co.uk" target="_blank" title="This site was designed and created by AitGroup" >AitGroup</a></div>
		</div>
	</div>
</div>	

</body>
</html>