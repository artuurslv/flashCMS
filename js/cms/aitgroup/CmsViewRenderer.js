
var render= {
// Menu editting functionality
	view_menu: function(){
		if($("#sortable").html().indexOf("<li") == -1){	
			if(sessionStorage.getItem("menu") != ""){		
			  menuString = sessionStorage.getItem("menu");
			  if(!isJsonString(menuString)){
				  menu_render(menuString);
			  }else{
				  loadDbMenu();
			  }
			}else{
				
				loadDbMenu();
			}				
		}	
		$( "#sortable" ).sortable("option", "cursor", "move");	
		$( "#sortable" ).disableSelection();
	},
	view_articles:function(){
//Load and Display List
		if($("#articleList").children("div").length == 0){
			var articles = sessionStorage.getItem("articles");
			  if(!isJsonString(articles)){
				var objArr = jQuery.parseJSON(Base64.decode(articles));
				for(var i = 0; i< objArr.length; i++){
					var item = new Article();
					item.fromJSON(objArr[i]);
					$("#articleList").append(item.renderListView());
				}
			  }
		}	
	},
	view_galery:function(){
		$("#info").html("");
		if($("#albumList").children("option").length == 1){
			var albums = sessionStorage.getItem("albums");
			  if(!isJsonString(albums)){
				var objArr = jQuery.parseJSON(Base64.decode(albums));
				for(var i = 0; i< objArr.length; i++){
					var item = jQuery.parseJSON(objArr[i]);
					$("#albumList").append($("<option></option>")
					         .attr("value",item.id)
					         .text(item.title));
				}
			  }
		}
	}
};