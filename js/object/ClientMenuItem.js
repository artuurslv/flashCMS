function ClientMenuItem() {
	this.id="notSet";
	this.name="";
	this.link="";
	this.position="";
	this.renderAdminUI=function(nr){
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.id=obj.id;
		this.name=obj.name;
		this.link=obj.link;
		this.position=obj.position;
	};
}