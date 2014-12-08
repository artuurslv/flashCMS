var render= {
// Home load logic
		view_home:function(){
			
		},
		view_projectgallery: function(){
			var id = getHashParam('id',false);
			if(id){
				var title = getHashParam('title',false);
				$("#albumTitle").html("&nbsp;/ &nbsp; "+title);
				 $("#imageList").html("Loading images...");
				 $('#galleryList').hide("slide", { direction: "left" }, 500);	
				 $("#singleGalleryView").show("slide", { direction: "right" }, 500);	
			 $.ajax({		
					type:"POST",
					url: getServerName()+"services/GaleryManagementService.php",
					data: { action: "loadAlbum", id:id}
				}).done(function( msg ){
					$("#imageList").html("");
					 renderImageList(msg);
				});
			}else{
				 $("#galleryList").show();
				 $("#singleGalleryView").hide();
			}
		}
		
};
function renderImageList(basedCtnt){
	var ctnt = decodeObj(basedCtnt);
	$(ctnt).each(function(){
		var obj = jQuery.parseJSON(this);
		var img = new ImageElement();
			img.id = obj.id;
			img.title = obj.title;
			img.name=obj.image;
		$("#imageList").append(img.renderClientView());
	});
}