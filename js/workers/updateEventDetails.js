importScripts('workerAjax.js');
onmessage = function(e) {
	
	var msg =ajaxf("EventManagementService", "action=updateDetails&event="+e.data);
	postMessage(msg);		
};