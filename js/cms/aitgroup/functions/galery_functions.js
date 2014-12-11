//Galery functions
$(document).ready(function(){
	$("#create_album").click(function(){
		var albumTitle = prompt("Album Title","Empty Album");
		if(albumTitle.length > 4){
			$("#info").html("Creating the album...");
			$.ajax({		
				type:"POST",
				url: getServerName()+"services/GaleryManagementService.php",
				data: { action: "createAlbum", title:albumTitle}
			}).done(function( msg ){
				if(isNumeric(parseInt(msg))){
					$("#albumList").append($("<option></option>")
					         .attr("value",msg)
					         .text(albumTitle));
					var newAlbum={
							id: msg,
							title: albumTitle
					};
					insertSession("albums", newAlbum);
					$("#info").html("Done");
				}else{
					alert("ERROR: \n"+msg);
					$("#info").html("Failed - Try again.");
				}
			});
		}else{
			alert("Title must be at least 5 characters long!");
		}
	});
	$("#albumList").change(function(){
		var id = $(this).val();
		if(id != "0"){
			$("#info").html("Loading album content...");
			$("#currentAlbumId").val(id);
			$.ajax({		
				type:"POST",
				url: getServerName()+"services/GaleryManagementService.php",
				data: { action: "loadAlbum", id:id}
			}).done(function( msg ){
				$("#pictureList").html("");
				var resultList = jQuery.parseJSON(Base64.decode(msg));
				$(resultList).each(function(){
					var obj = jQuery.parseJSON(this);
					var img = new ImageElement();
						img.id = obj.id;
						img.title = obj.title;
						img.name=obj.image;
					$("#pictureList").append(img.renderListView());
				});
				$("#info").html("Done");
			});
		}else{
			$("#pictureList").html("Please select an album");
		}
	});
	$("#insertImage").click(function(){
		var id = $("#currentAlbumId").val();
		if(id){
			$("#ait_blanket, #insertImageBox").show();
			
		}	
	});
	$("#image").preimage();
	
	$("#deleteAlbum").click(function(){
		var id = $("#currentAlbumId").val();
		if(id){
			var r = confirm("Are you sure you want to delete curent Album? ");
			if (r == true) {
				$("#ait_loader_txt").text("Deleting Album...");
				$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
				$.ajax({		
					type:"POST",
					url: getServerName()+"services/GaleryManagementService.php",
					data: { action: "deleteAlbum", id:id}
				}).done(function( msg ){
					$("#pictureList").html("No images");
					$("#albumList option[value='"+id+"']").remove();
					removeSessionById("albums", id);
					$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
					$("#info").html("Album deleted");
				});
			}			
		}	
	});
});

function fileSelected() {
    var file = document.getElementById('image').files[0];
    $("#uploadProgress").hide();
    if (file) {
        var fileSize = 0;
        if (file.size > 1024 * 1024)
            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
        else
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

        document.getElementById('fileName').innerHTML = '<strong>Name: </strong>' + file.name;
        document.getElementById('fileSize').innerHTML = '<strong>Size: </strong>' + fileSize;
        document.getElementById('fileType').innerHTML = '<strong>Type: </strong>' + file.type;
    }
}

function uploadFile() {
	$("#uploadProgress").show();
	var id = $("#currentAlbumId").val();
    var fd = new FormData();
    fd.append("action", "uploadImage");
    fd.append("fileToUpload", document.getElementById('image').files[0]);
    fd.append("title", $("#imageTitle").val());
    fd.append("album_id", id);
    var xhr = new XMLHttpRequest();
    xhr.upload.addEventListener("progress", uploadProgress, false);
    xhr.addEventListener("load", uploadComplete, false);
    xhr.addEventListener("error", uploadFailed, false);
    xhr.addEventListener("abort", uploadCanceled, false);
    xhr.open("POST", getServerName()+"services/GaleryManagementService.php");
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
   	var resp = evt.target.responseText;
   	var id = resp.substring(0, resp.indexOf("NAME:"));
   	var name = resp.substring(resp.indexOf("NAME:")+5, resp.length);
   	var image = new ImageElement();
	   	image.id = id;
	   	image.name = name;
	   	image.title = $("#imageTitle").val();
   	$("#pictureList").append(image.renderListView());
   	$("#imageTitle").val("");
   	$("#image").val("");
   	
}

function uploadFailed(evt) {
    alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
    alert("The upload has been canceled by the user or the browser dropped the connection.");
}
//Update X DELETE image
$(document).on('click', '#pictureList .articleActionBtn input', function(){ 
	var id = $(this).parents(".articlesRec").children(":first").html();
	var mainParent = $(this).parents(".articlesRec");
	$("#ait_blanket, #ait_loader").show();
	var action = $(this).val();
	if(action == "Delete"){
		var r = confirm("Are you sure you want to delete this Image? ");
		if (r == true) {
			$("#ait_loader_txt").text("Deleting Image...");
			$("#ait_loader_txt").show();
			$.ajax({		
				type:"POST",
				url: getServerName()+"services/GaleryManagementService.php",
				data: { action: "deleteImage", id:id}
			}).done(function( msg ){
				mainParent.remove();
				$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
				$("#info").html("Image deleted");
			});
		}
	}
});
