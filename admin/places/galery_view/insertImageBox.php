<div style="overflow:hidden">
	<div style="float:right;">
			<div class="menu_boxBtn" style="float:right; width:150px;" onclick="$('#ait_blanket, #insertImageBox, #uploadProgress').hide();$('#fileName,#fileSize,#fileType,#prev_image').html('');$('#imageTitle, #image').val('');">Close</div>	
	</div>
	<div style="float:left;">
		<div class="menu_boxBtn" style="width:150px;" onclick="uploadFile()">Save</div>
	</div>	
	<div style="text-align:left;width:400px;margin:auto;">
		<div>
			<strong>Title: </strong><input type="text" id="imageTitle" style="width:245px" placeholder="Image title" />
		</div>
		<div>
			<strong>Image: </strong><input type="file" name="image" id="image" class="menu_boxBtn" onchange="fileSelected()"/>
			<div id="uploadProgress" style="display:none">
				<span id="progressNumber">0%</span><progress id="prog" value="0" max="100.0"></progress>	
			</div>
			<br />
		</div>
		<div>
			<div id="prev_image" style="overflow: auto;width: 300px;" class="prev_container">&nbsp;</div>
		</div>
		<div>
		<br />
			<div id="fileName"></div>
			<div id="fileSize"></div>
			<div id="fileType"></div>
		</div>
		
	</div>
</div>


