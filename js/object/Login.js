function Login() {
	this.name="";
	this.pass="";
	
	this.isValid=function(){
		if(this.name && this.pass){
			return true;
		}else{
			return false;
		}
	};
	
	this.fromJSON=function(text){
		var obj = jQuery.parseJSON(text);
		this.name=obj.name;
		this.pass=obj.pass;
	};
}