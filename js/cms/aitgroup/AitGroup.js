//JSON string tester
function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
//checks if is number
function isNumeric(v){
   return typeof v === 'number' && isFinite(v);
}
//insert into Session
function insertSession(name, obj){
	var based = sessionStorage.getItem(name);
	  if(!isJsonString(based)){
		var soned = Base64.decode(based);
		var objArr = jQuery.parseJSON(soned);
		var newObjArr =[];
		for(var i = 0; i< objArr.length; i++){
			var item = jQuery.parseJSON(objArr[i]);
				newObjArr.push(jQuery.toJSON(item));
		}
		newObjArr.push(jQuery.toJSON(obj));
		var newSessionList = Base64.encode(jQuery.toJSON(newObjArr));
		sessionStorage.setItem(name, newSessionList);
	  }else{
		  alert("ERROR: Corrupt format in session. Variable: "+ name);
	  }	
}
//remove from Session by id
function removeSessionById(name, id){
	var based = sessionStorage.getItem(name);
	  if(!isJsonString(based)){
		var soned = Base64.decode(based);
		var objArr = jQuery.parseJSON(soned);
		var newObjArr =[];
		for(var i = 0; i< objArr.length; i++){
			var item = jQuery.parseJSON(objArr[i]);
			if(item.id != id){
				newObjArr.push(jQuery.toJSON(item));
			}
		}
		var newSessionList = Base64.encode(jQuery.toJSON(newObjArr));
		sessionStorage.setItem(name, newSessionList);
	  }else{
		  alert("ERROR: Corrupt format in session. Variable: "+ name);
	  }	
}
//Gets actual installation url
function getServerName(){
	var sn = "";
	var url = window.location.href;
	var arr = url.split("/");
	if( arr[2] == "localhost"){
		var pathname = window.location.pathname;
		var folder =pathname;
		if(pathname.indexOf("admin") >-1){
			folder = pathname.substring(0, pathname.indexOf("admin"));
		}
		sn = arr[0]+"//"+arr[2] + folder;
	}else{
		sn = arr[0]+"//"+arr[2]+"/";
	}
	return sn;
}
function myTimestamp(){
    tstmp = new Date();    
    return tstmp.getTime();
} 

//The navigation Logic With working browser back button
function navigationHandler(){
	var id = getTokenId();
	var nav = document.getElementById(id);
	$(".ait_menu, .ait_subMen").hide();
	$(nav).slideDown();
	after_navigate();
}
//event listener, listens for hash changes
if ( window.addEventListener ) {
	window.addEventListener( 'hashchange', navigationHandler, false );
} else if ( window.attachEvent ) {
	window.attachEvent( 'onhashchange', navigationHandler );
}
//Navigates between "ctnt"and "ctntHome" class elements using hash "#" 
//SubMenu is must contain main menu in its ID, example menu - news, submenu -> "news_today"
function navigate(id){
	
	var elemId=id;
	var hasSub=false;
	var sub="";
	if(id.indexOf("?") > -1){
		elemId = id.substring(0, id.indexOf("?"));
	}
	if(id.indexOf("_") > -1){
		sub = elemId;
		elemId = id.substring(0, id.indexOf("_"));
		hasSub=true;
	}
	var currToken = getTokenId();
	if(currToken.indexOf(elemId) == -1){
		$(".ait_menu, .ait_subMen").hide();
        	window.location.hash=id;
        	
	}

	if(hasSub && currToken.indexOf(sub) == -1){
		var navSub = document.getElementById(sub);
		window.location.hash=id;
    	$(".ait_subMen").hide("slide");
    	$(navSub).show("slide");    	
	}
}
// gets actual place token
function getTokenId(){
	var cont = window.location.hash;
	if(cont == ""){
		cont="home";
	}
	var id = cont;
	if(cont.indexOf("#")>-1){
		id = cont.substr(1,cont.lenght);
		if(id.indexOf("?") >-1){
			id = id.substring(0,id.indexOf("?"));
		}
	} 
	return id;
}
//displays actual content body onload
function findCont(){
	var elemId = getTokenId();
	if(elemId.indexOf("_") > -1){
		elemId = elemId.substring(0, elemId.indexOf("_"));
	}
	var obj = document.getElementById(elemId);
	if(obj != null){
	    obj.style.display="block";
	}else{
	    window.location.href=getServerName()+"404.php";
	}      		
		
after_findCont();
}
//Retuens a parameter from hash "#home?param1=THIS_VALUE" | getHashParam("param1") , returns "THIS_VALUE"
//based = is parameter Base64 encoded (TRUE = YES / FALSE = NO)
function getHashParam(param,based){
	var hash = location.hash;
	var params = hash.substring(hash.indexOf("?"),hash.length);
	var hash_parts = params.split(param, 2); //2 - limit, may be changed if more than two arguments
	var value ="";
	for(i in hash_parts) {
		if(i==1){
			if(!based){
				if(hash_parts[i].indexOf("&") > -1){
					value = hash_parts[i].substring(1, hash_parts[i].indexOf("&"));
				}else{
					value = hash_parts[i].substring(1, hash_parts[i].length);
				}
			}else{
				value = atob(hash_parts[i].substring(1, hash_parts[i].length)); 
			}	
		}
	}
	return value;
}
//Allows numberic values only usage: onkeypress='return isNumberKey(event)'
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
$(document).ready(function(){
//Requires ait_blanket and loader elements
	$("#ait_ait_blanket, #ait_loader").bind("ajaxStart", function(){
	    $(this).show();
	}).bind("ajaxStop", function(){
	    $("#ait_loader").hide();
	});
	
	$("#ait_resp_menu").click(function(){
		$(this).children("UL").slideToggle("slow");
	});
	$('#ait_logoutBtn').click(function(){
		$.ajax({
			type:"POST",
			url: getServerName()+"services/logout.php",
	data: {}
		}).done(function( msg ){
			location.href=getServerName();
		});
});

});
function encodeObj(obj){
    return Base64.encode(jQuery.toJSON(obj));
}
function decodeObj(objString){
    return jQuery.parseJSON(Base64.decode(objString));
}
function loadImage(id, filePath, width){
	// preload image
if($("#"+id).children("img").length == 0){
var elm = $('<div class="imageBase"></div>');
elm.appendTo($("#"+id));
var img = new Image();			
	img.src = getServerName()+filePath;
	img.onload = function(){
		elm.hide();
		var endImg = $('<img />',
	             { src:  getServerName()+filePath, 
	               alt:'MyAlt',
	               width: width});
	              endImg.appendTo($("#"+id));
	              endImg.addClass('preLoadImage');
	              endImg.fadeIn( "slow" );
	};
}
}