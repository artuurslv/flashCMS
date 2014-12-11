<h1>Gallery</h1>
<div id="insertImageBox" class="center" ><?php include 'insertImageBox.php';?></div>
<div style="overflow:hidden">
	<div style="float:left">
		Album list: 
		<select id="albumList" class="selects">
			<option value="0" >-Select-</option>
		</select>
	</div>
	<div style="float:right">
		<input type="button" value="Create new Album" class="menu_boxBtn" id="create_album" />
	</div>
			<div id="info" class="newErrMsg">ddddd</div>
</div>
<hr />
	<br />
<div>
	<div style="overflow:hidden;">
		<input type="button" value="Delete Album" id="deleteAlbum" class="menu_boxBtn" style="float:left" />
		<div class="middleMan">
			<input type="hidden" id="currentAlbumId" />
		</div>
		<input type="button" value="Insert picture" id="insertImage" class="menu_boxBtn" style="float:right" />
	</div>
	<strong>Picture list:</strong>
	<div id="pictureList">	</div>
</div>