<?php
include "../inc/settings.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>

<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/modules/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/modules/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo PATH_SITE;?>js/cms/aitgroup/AitGroup.js"></script>
<script>
tinymce.init({
    selector: "#text_content",
    theme: "modern",
    plugins: [
              "iframe advlist autolink lists link image charmap preview hr anchor pagebreak",
              "searchreplace wordcount visualblocks visualchars code fullscreen",
              "insertdatetime media nonbreaking save table contextmenu directionality",
              "emoticons template paste textcolor"
    ],
    image_advtab: true,
    relative_urls: false,
    remove_script_host: false,
    toolbar1: "fontsizeselect | fontselect | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "preview media | forecolor backcolor emoticons | insertfile undo redo "
});

//TinyUpdate
$(document).ready(function(){
	setTimeout(function(){ 
		$("#mce_44").click(function(){
			setTimeout(function(){
				$(".mce-foot").append("<div id='custom_upl' class='custom_btn' >Upload pic</div>");
					$("#custom_upl").click(function(){
							$("#ait_ait_blanket",parent.document).show();
							$("#aitPicUploader").show();
							updateSide();
						});
			}, 1200);
			});
    }, 1000);
});
function updateSide(){
	$.ajax({		
		type:"POST",
		url: getServerName()+"services/GetFolderContService.php",
		data: { action: "get"}
	}).done(function( msg ){
		var result = msg.split(" ");
		var res ="";
		for(var i = 0; i<result.length; i++){
			if(result[i].length > 4){
				res += "<div> <input type='radio' name='pic' value='"+result[i]+"' />"+result[i]+"</div>";
			}
		}
		$("#servFileList").html(res);
		//sessionStorage.setItem("menu", msg);
		//menu_render(msg);
	});	
}
function insertPic(){
	$(".mce-container.mce-panel.mce-floatpanel.mce-window.mce-in .mce-textbox.mce-placeholder").val(getServerName()+"upload/"+$("input[name='pic']:checked").val());
	$('#aitPicUploader').hide();
}

function fileSelected() {
    var file = document.getElementById('fileToUpload').files[0];
    if (file) {
        var fileSize = 0;
        if (file.size > 1024 * 1024)
            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
        else
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

        document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
        document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
        document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
    }
}

function uploadFile() {
    var fd = new FormData();
    fd.append("fileToUpload", document.getElementById('fileToUpload').files[0]);
    var xhr = new XMLHttpRequest();
    xhr.upload.addEventListener("progress", uploadProgress, false);
    xhr.addEventListener("load", uploadComplete, false);
    xhr.addEventListener("error", uploadFailed, false);
    xhr.addEventListener("abort", uploadCanceled, false);
    xhr.open("POST", getServerName()+"services/uploadTinyPicService.php");
    xhr.send(fd);
}

function uploadProgress(evt) {
    if (evt.lengthComputable) {
        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
        document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%';
        document.getElementById('prog').value = percentComplete;
    }
    else {
        document.getElementById('progressNumber').innerHTML = 'unable to compute';
    }
}

function uploadComplete(evt) {
    /* This event is raised when the server send back a response */
   	if(evt.target.responseText == "saved"){
   		updateSide();
   	}else{
		alert(evt.target.responseText);
   	}
}

function uploadFailed(evt) {
    alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
    alert("The upload has been canceled by the user or the browser dropped the connection.");
}
</script>
<style>
.custom_btn{
	 border: 1px solid !important;
    border-radius: 3px !important;
    cursor: pointer !important;
    margin-left: 4% !important;
    padding: 4px !important;
    position: relative !important;
    width: 70px !important;
    margin-top: -40px !important;
}
.dialog{
	position:absolute;
	z-index: 100000;
	top: 33%;
	left: 35%;
	width:600px;
	height:300px;
	background:#FFF;
	display:none;
	border: 10px solid grey;
	border-radius: 5px;
	overflow:hidden;
}
.dialog .leftSide{
padding-top:20px;
	float:left; 
	width:30%; 
	border-right:1px solid grey; 
	height:100%;
}
.dialog .rigthSide{
padding-top:20px;
	float:left; 
	width:60%; 
	padding-left: 20px;
	height:100%;
}
.bottomBtns{
	margin-top: 5px;
	height:30px;
}
.bottomBtns input{
	height: 30px;
    margin-right: 50px;
    width: 110px;
}
</style>
</head>
<body>
<div  id="text_content" style="width:90%;height:400px"></div>
<div id="aitPicUploader" class="dialog">
	<div class="leftSide"><div style="padding-left:20px;padding-bottom:20px;border-bottom:1px solid grey; "><b>Select from the list</b>
	</div>
	<div id="servFileList" style="padding:20px; overflow-y:scroll; height:200px" >Loading...</div>
	</div>
	<div class="rigthSide" >
	<div>
		<form id="form1">
    <div>
        <label for="fileToUpload">
           <h3> Or Upload a new image</h3></label>
        <input type="file" name="fileToUpload[]" id="fileToUpload" onchange="fileSelected();" />
    </div>
    <div id="fileName">
    </div>
    <div id="fileSize">
    </div>
    <div id="fileType">
    </div>
    <div>
    	<br />
        <input type="button" onclick="uploadFile()" value="Upload" />
    </div>

    <div id="progressNumber">
    </div>
    <progress id="prog" value="0" max="100.0"></progress>
    </form>
	</div>
		<div class="bottomBtns">
			<input type="button" value="Insert" id="insertPic" onclick="insertPic()"/>
			<input type="button" value="Close" onclick="$('#aitPicUploader').hide()" />	
		</div>
	</div>
</div>
</body>
</html>