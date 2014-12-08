<div><div class="signText">Sign In:</div><div class="signBox"><table>
	<tr>
		<td width="150" align="center"> Email : </td>
		<td width="160"> <input type="text" id="login" name="login" value="" /> </td>
	</tr>
	<tr>
		<td align="center"> Password : </td>
		<td> <input type="password" id="password" name="pass" /> </td>
	</tr>
	<tr>
		<td height="10"> </td>
	</tr>
	<tr>
		<td align="right"><input type="button" id="loginSubmit" value="Sign in" /></td>
		<td align="center"><input type="button" id="loginCancel" value="Cancel" /></td>
	</tr>
</table></div></div><script>$('#loginSubmit').click(function(){	var login = new Login();	login.name = $("#login").val();	login.pass = MD5($("#password").val());	if(login.isValid()){		$.ajax({			type:"POST",			url: getServerName()+"services/authorize.php",	data: { login: jQuery.toJSON(login)}		}).done(function( msg ){			if(msg.indexOf('ADMIN:') >-1){								var menu = msg.substring(msg.indexOf('MENU:')+5, msg.indexOf('ARTICLES:'));				var articles = 	msg.substring(	msg.indexOf('ARTICLES:')+9, msg.indexOf('ALBUMS:'));				var albums = msg.substring(msg.indexOf('ALBUMS:')+7, msg.lenght);								sessionStorage.setItem("menu",menu);				sessionStorage.setItem("articles",articles);				sessionStorage.setItem("albums", albums);								window.location.href=getServerName()+"admin/";			}else if(msg.indexOf('ERROR:') == -1){			    location.href=getServerName();			}else{				alert(msg);				}		});	}else{		alert("Please fill all fields!");	}});</script>