importScripts('workerAjax.js');
onmessage = function(e) {
	
	var msg =ajaxf("EventManagementService", "action=loadEventArticle&event_id="+e.data);
	postMessage(msg);		
};