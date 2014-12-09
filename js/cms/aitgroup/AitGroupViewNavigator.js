$(document).ready(function(){
	var token = getTokenId();
	try{
		render["view_"+token]();
	}catch(e){
		//TODO Ignoring error..
	}	
});
$(window).on('hashchange', function() {
	var token = getTokenId();
	try{
		render["view_"+token]();
	}catch(e){
		//TODO Ignoring error..
	}
});