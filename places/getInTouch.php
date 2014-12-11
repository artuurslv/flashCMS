<div style="float:left;">
<?php 
//21 = Get in touch article;
echo Article::loadArticle(3, $mysqli); ?>
</div>
<?php include 'places/parts/contactForm.php';?>
