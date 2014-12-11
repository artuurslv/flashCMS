function myTimestamp(){
    tstmp = new Date();    
    return tstmp.getTime();
} 

//xmlhttp.send("fname=Henry&lname=Ford");

function ajaxf(service, params){
var xmlhttp =new XMLHttpRequest();
var resp = "none";
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      resp = xmlhttp.responseText;
      
    }
  }
  xmlhttp.open("POST","../../services/"+service+".php",false);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send(params);
  return resp;
}