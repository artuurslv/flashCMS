<div class="title">Articles</div>
<div id="create_articleDialog" class="center"><?php include 'CreateArticleBox.php';?></div>
<div id="update_articleDialog" class="center"><?php include 'UpdateArticleBox.php';?></div>
<div style="overflow:hidden" >
	<div style="float:left">
		<input type="text" /> <input type="button" value="Search" />
	</div>
	<div style="float:right">
		<input type="button" value="Create" onclick="$('#ait_blanket, #create_articleDialog').show();"/>
	</div>
</div>
<div>
	<strong>Article List:</strong>
	<div id="articleList">
	</div>
</div>