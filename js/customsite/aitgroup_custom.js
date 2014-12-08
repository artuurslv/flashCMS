//Happens after the navigation is done
function after_navigate(){
	$(".menu_active").removeClass("menu_active");
	$("#menu_"+getTokenId()).addClass("menu_active");
	if(getTokenId() != "home"){
		$("#sliderWidth").hide();
	}else{
		$("#sliderWidth").show();
	}
	$("html, body").animate({ scrollTop: 0 }, "slow");
}
//displays actual content body onload
function after_findCont(){
	$(".menu_active").removeClass("menu_active");
	$("#menu_"+getTokenId()).addClass("menu_active");
	if(getTokenId() != "home"){
		$("#sliderWidth").hide();
	}else{
		$("#sliderWidth").show();
	}
	
	$("html, body").animate({ scrollTop: 0 }, "slow");
}


//Scripts that should go into "head"
$(document).ready(function(){
	loadImage("slider1","img/landscape/22.jpg","100%");
	loadImage("slider2","img/landscape/11.jpg","100%");
	loadImage("slider3","img/landscape/33.jpg","100%");
	$('.prettyPhoto').fancybox();
	$("html, body").animate({ scrollTop: 0 }, "slow");
});