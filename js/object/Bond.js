function Bond() {
	this.bond_id="";
	this.title="";
	this.renderAdminUI=function(){		var screen = '<div class="articlesRec">'+						'<div class="articlesBox assignedlist">'+this.title+'</div>'+						'<input type="hidden" value="'+this.bond_id+'" />'+						'<div class="articlesBox assignedlist articleActionBtn"><input type="button" value="Remove" /></div>'+					'</div>';		return screen;	};	this.renderListView=function(nr){		var screen = '<div class="articlesRec"> '+			'<div class="articlesBox">'+this.id+'</div>'+			'<div class="articlesBox">'+this.title+' </div>'+			'<div class="articlesBox articleActionBtn"><input type="button" value="Delete" /></div>'+			'<div class="articlesBox articleActionBtn"><input type="button" value="Update" /></div>'+    	'</div>';		return screen;		//'+this.id+'	};	
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.bond_id=obj.bond_id;
		this.title=obj.title;
	};		this.encode=function(){	    obj = jQuery.toJSON(this);	    return Base64.encode(obj);	};
}