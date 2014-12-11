$(document).ready(function(){
	var galeryWorker = new Worker(getServerName()+'js/workers/loadAlbumList.js');
    galeryWorker.postMessage("work");
    galeryWorker.onmessage= function(resp){
	   	 var albums = resp.data;
	   	 renderGaleryContent(albums);
	   	 
	   	 var latestTitle = renderAlbumSelect(albums);
	   	
	   	 galeryWorker.terminate();
    };
    galeryWorker.onerror = function(e){
        alert('ERROR: Line '+ e.lineno +' in '+ e.filename+ ': '+ e.message);  
     };
     $("#albumSelectList").change(function(){
    	 var id = $(this).val();
    	 if(id){
	    	 $("#imageList").html("Loading new images...");
	    	 var title = $(this).find("option:selected").text(); 
	    	 $("#albumTitle").html("&nbsp;/ &nbsp; "+title);
	    	 $.ajax({		
					type:"POST",
					url: getServerName()+"services/GaleryManagementService.php",
					data: { action: "loadAlbum", id:id}
				}).done(function( msg ){
					 $("#imageList").html("");
					 renderImageList(msg);
				});
    	 }
     });
     $("#backBtn").click(function(){
    	 $("#galleryList").show("slide", { direction: "left" }, 500);
		 $("#singleGalleryView").hide("slide", { direction: "right" }, 500);
		 window.location.hash="projectgallery";
     });
});
function renderAlbumSelect(basedAlbums){
	var albumList = decodeObj(basedAlbums);
	var albumArr =[];
	var count = -1;
	$(albumList).each(function(){
		count++;
		var elem = jQuery.parseJSON(this);
		albumArr.push(elem);
	});
	for(var i=count;i>=0;i--){
		$("#albumSelectList").append($("<option></option>")
		         .attr("value",albumArr[i].id)
		         .text(albumArr[i].title));
	}
	return albumArr[count].title;
}
function renderGaleryContent(basedCtnt){
	var ctnt = decodeObj(basedCtnt);
	$(ctnt).each(function(){
		var obj = jQuery.parseJSON(this);
		var img = new ImageElement();
			img.id = obj.id;
			img.title = obj.title;
			img.name=obj.cover_img;
		$("#galleryList").append(img.renderAlbumView());
	});
}
