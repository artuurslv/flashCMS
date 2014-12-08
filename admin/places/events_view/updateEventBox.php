<div class="closeBtn" style="margin-top:0px"onclick="$('#ait_blanket, #update_eventDialog,#ait_loader, #ait_loader_txt').hide();$('#errMsg').html('');$('#currentEventArticle, #addContentToEventList').html(''); $('#update_eventTitleAction, #update_DeleteEvent').removeAttr('disabled');">Close</div>
<div style="overflow:hidden">
	<div style="text-align: center;padding-top: 10px;">
		<input type="hidden" id="update_elem_id" />
		<input type="hidden" id="update_eventTitle_old" />
		<strong>Event Title: </strong>
		<input type="text" id="update_eventTitle" />
		<input type="button" id="update_eventTitleAction" class="menu_boxBtn" value="Update" />
	</div>
	<div class="newErrMsg" id="updateEventErr"></div>
		
	<div style="float: left;">
		<strong>Current Content: &nbsp;</strong><span id="currentEventArticle"></span>
	</div>
	<input style="float: right;" type="button" id="update_DeleteEvent" class="menu_boxBtn" value="Delete Event" />
</div>
<div><strong>Available Articles:</strong></div>
<div id="addContentToEventList"></div>