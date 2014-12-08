function menu_render(menuString){
	var objArr = jQuery.parseJSON(Base64.decode(menuString));
	for(var i = 0; i< objArr.length; i++){
		var item = new ClientMenuItem();
		item.fromJSON(objArr[i]);
		$("#sortable").html($("#sortable").html()+item.renderAdminUI()); 
	}
}
function loadDbMenu(){
	$("#ait_loader_txt").text("Loading client menu...");
	$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
	$.ajax({		
		type:"POST",
		url: getServerName()+"services/MenuEditService.php",
		data: { action: "loadMenu"}
	}).done(function( msg ){
		$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
		sessionStorage.setItem("menu", msg);
		menu_render(msg);
	});
}

//Content management screen..
$(document).ready(function(){
// Adding new menu item
	$("#menu_addItem").click(function(){
		$("#menu_renameTitle").text("What will you call the new menu item?");
		$("#editMenuSubmit").hide();
		$("#ait_blanket, #menu_addItemDialog, #addMenuSubmit").show();
	});	
//Deleting Menu items
	$("#menu_deleteItem").click(function(){
		var x = $('input[name="menuItems"]:checked').parent().text();
		if(x!= ""){
			if(confirm('Sure you want to delete \"'+x+'\" page?')){
				var idString ="";
				$('input[name="menuItems"]:checked').each(function(){
					idString += $(this).val()+" ";
					$(this).parent().remove();
				});
				$("#ait_loader_txt").text("Deleting menu item(s) from database...");
				$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
				$.ajax({		
					type:"POST",
					url: getServerName()+"services/MenuEditService.php",
					data: { action: "deleteMenu", id: idString }
				}).done(function( msg ){
					$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
					//Session Storage Update
					if(sessionStorage.getItem("menu") != null){		
						var menuString = sessionStorage.getItem("menu");
						try{
						var objArr = jQuery.parseJSON(Base64.decode(menuString));
						var newObjArr =[];
						for(var i = 0; i< objArr.length; i++){
							var item = new ClientMenuItem();
							item.fromJSON(objArr[i]);
							if(parseInt(item.id) !== parseInt(idString)){
								newObjArr.push(jQuery.toJSON(item));
							}
						}
						var newStr = Base64.encode(jQuery.toJSON(newObjArr));
						sessionStorage.setItem("menu", newStr);
						}catch(e){
							//TODO Ignoring error..
						}
					}

				});
			}
		}
	});
//Editting the menu item
	$("#menu_editItem").click(function(){
		var currName =  $('input[name="menuItems"]:checked').parent().text();
		var isHidden = $('input[name="menuItems"]:checked').parent().children('input[name="menuIsHidden"]').val();
		var isStatic = $('input[name="menuItems"]:checked').parent().children('input[name="menuIsStatic"]').val();
		if($("input[name='menuItems']:checked").val()){
			$("#menu_renameTitle").text("Renaming menu item \""+currName+"\" !");
			$("#menu_menuNameTb").val(currName);
			if(isHidden == 1){
				$("input[name='hidden']").prop('checked', true);
			}else{
				$("input[name='hidden']").prop('checked', false);
			}
			if(isStatic == 1){
				$("input[name='static']").prop('checked', true);
			}else{
				$("input[name='static']").prop('checked', false);
			}
			$("#addMenuSubmit").hide();
			$("#ait_blanket, #menu_addItemDialog, #editMenuSubmit").show();
		}else{
			alert("No items selected.");
		}
	});
//Sorting Menu
	$( "#sortable" ).sortable({
		  stop: function( event, ui ) {
			  var idString ="";
				$("#sortable").children().each(function(){
					idString = idString + $(this).children(':first-child').val()+" ";
				});
				$("#ait_loader_txt").text("Sorting the menu...");
				$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
				$.ajax({		
					type:"POST",
					url: getServerName()+"services/MenuEditService.php",
					data: { action: "sortMenu", id: idString}
				}).done(function( msg ){
					$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
					//Session Storage Update
					sessionStorage.setItem("menu", "");
				});
		  },
	});
	var page_id ="";
	$("#menu_contentItem").click(function(){
		if($("input[name='menuItems']:checked").val()){
			page_id = $("input[name='menuItems']:checked").val();
			var pageTitle = $('input[name="menuItems"]:checked').parent().text();
			$("#pageTitleCM").text(pageTitle);
			$("#errMsgCM").text("Loading assigned article list");
			$("#ait_blanket, #menu_contentDialog").show();
			$.ajax({		
				type:"POST",
				url: getServerName()+"services/ElementAssignmentService.php",
				data: { action: "loadAssignedElements", page_id: page_id }
			}).done(function( msg ){
				var list = jQuery.parseJSON(Base64.decode(msg));
				$("#errMsgCM").text("Content ready for use!");
				if(list.length > 0){
					for(var i = 0; i< list.length; i++){
						item = new Bond();
						item.fromJSON(jQuery.toJSON(list[i]));
						$("#currentContentList").append(item.renderAdminUI());
					}
				}else{
					$("#currentContentList").append("<span class='error'>No Articles on this page</span>");
				}
			});
			var articles = sessionStorage.getItem("articles");
			  if(!isJsonString(articles)){
				var objArr = jQuery.parseJSON(Base64.decode(articles));
				for(var i = 0; i< objArr.length; i++){
					var item = new Article();
					item.fromJSON(objArr[i]);
					$("#addContentToPageList").append(item.renderAddArticleView());
				}
			  }			
			
		}else{
			alert("Select a page");
		}
	});	
	$(document).on('click', '.assignedlist input', function(){
		var bond_id = $(this).parents(".articlesRec").children("input").val();
		var parent = $(this).parents(".articlesRec");
		$("#errMsgCM").text("Removing Element From Page");
		$.ajax({		
			type:"POST",
			url: getServerName()+"services/ElementAssignmentService.php",
			data: { action: "unassignElement", bond_id: bond_id }
		}).done(function( msg ){
			parent.remove();
			$("#errMsgCM").text("Done! Select your next action");
			if($("#currentContentList").children("articlesRec").length == 0){
				$("#currentContentList").append("<span class='error'>No Articles on this page</span>");
			}
		});
	});
	$(document).on('click', '.addToPage input', function(){ 
		var id = $(this).parents(".articlesRec").children(":first").html();
		var title = $(this).parents(".articlesRec").children().eq(1).html();
		$("#errMsgCM").text("Adding Article to the page");
		$.ajax({		
			type:"POST",
			url: getServerName()+"services/ElementAssignmentService.php",
			data: { action: "assignElement", page_id: page_id, element_id:id }
		}).done(function( msg ){
			item = new Bond();
			item.bond_id=msg;
			item.title = title;
			$("#errMsgCM").text("Done! Select your next action");
			if($("#currentContentList").children(".error").length > 0){
				$("#currentContentList").html(item.renderAdminUI());
			}else{
				$("#currentContentList").append(item.renderAdminUI());
			}
		});
	});
});