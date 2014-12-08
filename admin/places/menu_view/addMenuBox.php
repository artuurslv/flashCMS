<h3 id="menu_renameTitle">What will you call the new menu item?</h3>
<div class="cityPop_txt">
	<input type="text" id="menu_menuNameTb" name="" />
</div>
<div style="margin-top: -20px; padding-bottom: 10px;">
		<span style="margin-right: 55px;"><input type="checkbox" name="hidden" value="1" /> Hide </span>
		<span><input type="checkbox" name="static" value="1" /> Static</span>
	</div>
<div style="overflow: hidden;margin-bottom:7px;">
	<div class="menu_boxBtn" id="addMenuSubmit" style="float:left; margin-left: 10%; width:150px;">Save</div>
	<div class="menu_boxBtn" id="editMenuSubmit" style="float:left; margin-left: 10%; width:150px;">Save</div>
	<div class="menu_boxBtn" style="float:right;margin-right: 10%; width:150px;" onclick="$('#ait_blanket, #menu_addItemDialog').hide();$('#menu_menuNameTb').val('');">Cancel</div>
</div>
<script>
$("#addMenuSubmit").click(function(){
	
	$('#ait_blanket, #menu_addItemDialog').hide();
	$("#ait_loader_txt").text("Adding menu item...");
	$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
	var hidden = $("input[name='hidden']:checked").val();
	var isStatic = $("input[name='static']:checked").val();
	var name = $("#menu_menuNameTb").val();
	$.ajax({		
		type:"POST",
		url: getServerName()+"services/MenuEditService.php",
		data: { action: "addMenu", name:name, isHidden:hidden, isStatic:isStatic}
	}).done(function( msg ){
		$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
		$("#sortable").append($("<li></li>")
		         .html("<input name='menuItems' type='radio' value='"+msg+"' />"+$('#menu_menuNameTb').val()));
		//Session Storage Update
		if(sessionStorage.getItem("menu") != null){
				var menuString = sessionStorage.getItem("menu");
				var tst = Base64.decode(menuString);
				tst = tst.substring(0, tst.length -1);
				var newMenu = tst + ',"{\\"id\\":\\"'+msg+'\\",\\"name\\":\\"'+$('#menu_menuNameTb').val()+'\\"}"]';
				sessionStorage.setItem("menu", Base64.encode(newMenu));
			}
		$('#menu_menuNameTb').val('');
	});
});
$("#editMenuSubmit").click(function(){
	
	$('#ait_blanket, #menu_addItemDialog').hide();
	$("#ait_loader_txt").text("Editing menu item...");
	$("#ait_blanket, #ait_loader, #ait_loader_txt").show();
	var menuid=	$("input[name='menuItems']:checked").val();
	var newName = $("#menu_menuNameTb").val();
	var hidden = $("input[name='hidden']:checked").val();
	var isStatic = $("input[name='static']:checked").val();
	
	$.ajax({		
		type:"POST",
		url: getServerName()+"services/MenuEditService.php",
		data: { action: "editMenu", name:newName, id:menuid, isHidden:hidden, isStatic:isStatic}
	}).done(function( msg ){
		$("#ait_blanket, #ait_loader, #ait_loader_txt").hide();
		if(msg != "true"){
			alert(msg);
		}else{
		$("input[name='menuItems']:checked").parent().html(
				"<input name='menuItems' type='radio' value='"+
				$("input[name='menuItems']:checked").val()+"' />"+
				$('#menu_menuNameTb').val());
		//Session Storage Update
		if(sessionStorage.getItem("menu") != null){		
			var menuString = sessionStorage.getItem("menu");
			try{
				var objArr = jQuery.parseJSON(Base64.decode(menuString));
				var newObjArr =[];
				for(var i = 0; i< objArr.length; i++){
					var item = new ClientMenuItem();
					item.fromJSON(objArr[i]);
					if(parseInt(item.id) === parseInt(menuid)){
						item.name=newName;
						item.is_static = isStatic;
						item.is_hidden = hidden;
					}
					newObjArr.push(jQuery.toJSON(item));
				}
				var newStr = Base64.encode(jQuery.toJSON(newObjArr));
				sessionStorage.setItem("menu", newStr);
			}catch(e){
			}
		}
		}
		$('#menu_menuNameTb').val('');
		
	});
});
</script>