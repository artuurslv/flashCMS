importScripts('workerAjax.js');
onmessage = function(e) {
	
	var msg =ajaxf("GaleryManagementService", "action=loadAlbumListClient");
	postMessage(msg);		
};