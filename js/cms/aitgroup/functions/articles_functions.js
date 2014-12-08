$(document).ready(function(){
//Create article submission!
$("#createArticleSubmit").click(function(){
	
	$('#ait_blanket, #create_articleDialog').hide();
	$("#ait_loader_txt").text("Creating Article...");
	$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
	var title = $("#articleTitle").val();
	$.ajax({		
		type:"POST",
		url: getServerName()+"services/ArticleManagementService.php",
		data: { action: "create", title:title}
	}).done(function( msg ){
		$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
		var item = new Article();
		item.id = msg;
		item.title = title;
		$("#articleList").append(item.renderListView());
		$('#articleTitle').val('');

		var articles = sessionStorage.getItem("articles");
		  if(!isJsonString(articles)){
			var objArr = jQuery.parseJSON(Base64.decode(articles));
			objArr.push(jQuery.toJSON(item));
			var newArticlesList = Base64.encode(jQuery.toJSON(objArr));
			sessionStorage.setItem("articles", newArticlesList);
		  }			
	});
});
//UPDATE || Delete Article Call
	$(document).on('click', '#articleList .articleActionBtn input', function(){ 
		var id = $(this).parents(".articlesRec").children(":first").html();
		var mainParent = $(this).parents(".articlesRec");
		var action = $(this).val();
		$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
		if(action == "Update"){
			$("#ait_loader_txt").text("Loading Article...");
			$.ajax({		
				type:"POST",
				url: getServerName()+"services/ArticleManagementService.php",
				data: { action: "loadArticle", id:id}
			}).done(function( msg ){	
				$("#ait_loader,#ait_loader_txt").hide();
				$("#update_articleDialog").show();
				$("#errMsg").html("Loading article...");
				$("#update_articleDialog #text_content").attr("src", $('#update_articleDialog #text_content').attr("src"));
					setTimeout(function(){
						$("#text_content").contents().find("#text_content_ifr").contents().find("#tinymce").html(msg);
						$("#errMsg").html("Article ready to be edited.");
						$("#articleID").val(id);
			    	}, 1500);
			});
		}
		if(action == "Delete"){
			$("#ait_loader_txt").text("Deleting Article...");
			var r = confirm("Are you sure you want to delete article ? ");
			if (r == true) {
				$.ajax({		
					type:"POST",
					url: getServerName()+"services/ArticleManagementService.php",
					data: { action: "deleteArticle", id:id}
				}).done(function( msg ){	
					var articles = sessionStorage.getItem("articles");
					  if(!isJsonString(articles)){
						var objArr = jQuery.parseJSON(Base64.decode(articles));
						var newObjArr =[];
						for(var i = 0; i< objArr.length; i++){
							var item = new Article();
							item.fromJSON(objArr[i]);
							if(parseInt(item.id) !== parseInt(id)){
								newObjArr.push(jQuery.toJSON(item));
							}
							var newArticlesList = Base64.encode(jQuery.toJSON(newObjArr));
							sessionStorage.setItem("articles", newArticlesList);
						}
					  }			
					
					mainParent.remove();
					$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
				});
			}else{
				$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
			}
		}
	});

//	Saves Updated Article To DB
	$("#update_articleDialog #saveText").click(function(){
		var id = $("#articleID").val();
		$("#errMsg").html("Saving article...");
		var value = $("#text_content").contents().find("#text_content_ifr").contents().find("#tinymce").html();
		var content = Base64.encode(value);
		$.ajax({		
			type:"POST",
			url: getServerName()+"services/ArticleManagementService.php",
			data: { action: "updateArticle", id:id,  cont:content}
		}).done(function( msg ){					
			if(msg.indexOf("ERROR") == -1){
				$("#errMsg").html("Changes saved!");
			}else{
				alert(msg);
			}
		});
	});
});