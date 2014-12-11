<div class="contact_us">
		<form>
		<div class="field"><div>Name: </div> <input type="text" class="query_name" placeholder="Type in your name"/> </div>
		<div class="field"><div>Phone: </div> <input type="text" class="query_phone" placeholder="Use digits only" onkeypress='return isNumberKey(event)' /> </div>
		<div class="field"><div>Topic:</div> <input class="query_type" type="text" placeholder="What is your query about" /></div>
		<div class="textField">
			<div>Type in your query below:</div>
			<textarea  class="query_descr" style="max-width: 100%;width:300px;min-width:300px;height:130px" ></textarea>
		</div>
		<span class="error"></span>	
		<div style="width:306px;padding-top: 15px;"> 
			<input type="button" class="send_form" value="Send" />
			<input type="reset" value="Cancel" style="float:right" />
		</div>
	</form>
</div>
<script>
$(".contact_us .send_form").click(function(){
   		var name = $(".contact_us").find(".query_name");
   		var phone = $(".contact_us").find(".query_phone");
   		var type = $(".contact_us").find(".query_type");
   		var descr = $(".contact_us").find(".query_descr");
   		var err = $(".contact_us").find(".error");
   		if(name.val().length >3 && phone.val().length > 3 && type.val().length > 3 && descr.val().length > 3){
   		 err.html("Sending the email...");
   		 $.ajax({
	   			type:"POST",
	   			url: getServerName()+"services/sendQuoteMail.php",
	   			data: { name: name.val(), phone: phone.val(), type: type.val(), descr: descr.val()}
   		    }).done(function( msg ){
   				err.text(msg);
   				name.val("");
   				type.val("");
   				phone.val("");
   				descr.val("");
   		    });
   		}else{
			alert("We expect all fields to be at least 4 characters long!");
   		}  
});
</script>