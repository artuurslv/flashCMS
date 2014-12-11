function Article() {
	this.id="notSet";
	this.title="";
	this.renderAddArticleView=function(nr){		var screen = '<div class="articlesRec"> '+			'<div class="articlesBox articlesId">'+this.id+'</div>'+			'<div class="articlesBox">'+this.title+' </div>'+			'<div class="articlesBox articleActionBtn addToPage"><input type="button" value="Add To Page" /></div>'+    	'</div>';		return screen;	};		this.renderListView=function(nr){		var screen = '<div class="articlesRec"> '+			'<div class="articlesBox articlesId">'+this.id+'</div>'+			'<div class="articlesBox">'+this.title+' </div>'+			'<div class="articlesBox articleActionBtn"><input type="button" value="Delete" /></div>'+			'<div class="articlesBox articleActionBtn"><input type="button" value="Update" /></div>'+    	'</div>';		return screen;	};	
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.id=obj.id;
		this.title=obj.title;
	};		this.encode=function(){	    obj = jQuery.toJSON(this);	    return Base64.encode(obj);	};
}