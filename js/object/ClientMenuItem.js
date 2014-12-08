function ClientMenuItem() {
	this.id="notSet";
	this.name="";
	this.link="";
	this.position="";	this.is_static=false;	this.is_hidden=false;
	this.renderAdminUI=function(nr){		var screen = '<li><input name="menuItems" type="radio" value="'+this.id+'" />'+					'<input name="menuIsHidden" type="hidden" value="'+this.is_hidden+'" />'+					'<input name="menuIsStatic" type="hidden" value="'+this.is_static+'" />'+this.name+'</li>';		return screen;	};	this.renderClientView=function(nr){		var encoded = this.encode();		var screen = ' <div class="product" onclick="navigate(\'productView?id='+encoded+'\')">'+		'<img alt="none" style="height: 320px;width: 260px;" src="upload/'+this.mainPic+'" />'+    	'<div class="prodTitle">'+this.name+' </div>'+    	'<div class="price"> £'+this.price+'</div>'+'</div>';		return screen;			};	
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.id=obj.id;
		this.name=obj.name;
		this.link=obj.link;
		this.position=obj.position;		this.is_static=obj.is_static;		this.is_hidden=obj.is_hidden;
	};		this.encode=function(){	    obj = jQuery.toJSON(this);	    return Base64.encode(obj);	};
}