function Bond() {
	this.bond_id="";
	this.title="";
	this.renderAdminUI=function(){
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.bond_id=obj.bond_id;
		this.title=obj.title;
	};
}