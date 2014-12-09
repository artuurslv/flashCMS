importScripts('workerAjax.js');
onmessage = function(e) {
	
	var msg =ajaxf("EventManagementService", "action=loadschedule");
	postMessage(msg);		
};