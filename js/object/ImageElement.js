function ImageElement() {
	this.id="notSet";
	this.title="";
	this.renderClientView=function(nr){
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.id=obj.id;
		this.title=obj.title;
	};
}