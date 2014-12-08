function ImageElement() {
	this.id="notSet";
	this.title="";	this.name="";
	this.renderClientView=function(nr){		var screen = '<div class="imgHolder"> '+			'<div><a class="prettyPhoto" href="'+getServerName()+'upload/galery/original/'+this.name+'" rel="galery">'+			'<img src="'+getServerName()+'upload/galery/small/'+this.name+'" alt="noname" /> </a></div>'+			'<div class="imgTitle">'+this.title+' </div>'+    	'</div>';		return screen;	};		this.renderListView=function(nr){		var screen = '<div class="articlesRec"> '+			'<div class="articlesBox articlesId">'+this.id+'</div>'+			'<div class="articlesBox"><img src="'+getServerName()+'upload/galery/small/'+this.name+'" alt="noname" width="100" /></div>'+			'<div class="articlesBox">'+this.title+' </div>'+			'<div class="articlesBox articleActionBtn"><input type="button" value="Delete" /></div>'+    	'</div>';		return screen;	};	this.renderAlbumView=function(nr){		var screen = '<div class="album_imgHolder" onclick="navigate(\'#projectgallery?id='+this.id+'&title='+this.title+'\')"> '+		'<div class="album_imgTitle">'+this.title+' </div>'+		'<div><img src="'+getServerName()+'upload/galery/small/'+this.name+'" alt="noname" /> </a></div>'+			'</div>';	return screen;	};
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.id=obj.id;
		this.title=obj.title;
	};		this.encode=function(){	    obj = jQuery.toJSON(this);	    return Base64.encode(obj);	};
}