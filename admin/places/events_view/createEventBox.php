	<div>
		<strong>Selected start date: </strong><h2 id="startDateED">THIS ONE</h2>
	</div>
	<div id="errMsgCM" class="errMsgGreen"></div>
	<form>
		<div><strong>Event Title</strong></div>
		<input id="createEventTitle" type="text" /> 
		<div class="createEventDetailHolder">
			<div style="float:left;">Event type: </div>
			<div class="createEventInputHolder">
				<select id="createEventSelectBox">
					<option value="2">General</option>
					<option value="1">Weekly</option>
				</select>
			</div>
		</div>
		<div id="createEventFreqField" class="createEventDetailHolder" style="display:none">
				<div style="float:left;">How many weeks: </div>
				<div class="createEventInputHolder"><input id="createEventFreq" type="text" /></div>
		</div>
		<div class="createEventDetailHolder">
			<div style="float:left;">Starts at: </div>
			<div class="createEventInputHolder"><input id="createEventStartDate" type="text" /></div>
		</div>
		<div class="createEventDetailHolder">
			<div style="float:left;">Ends at: </div>
			<div class="createEventInputHolder"><input id="createEventEndDate" type="text" /></div>
		</div>
		<div class="createEventDetailHolder">
			<div style="float:left;">Check if it is an all day event: </div>
			<div class="createEventInputHolder"><input id="isAllDay" style="width:50px" type="checkbox" /></div>
		</div>
		<br />
		<div class="menu_boxBtn" id="createEventSubmit" style="float:left; width:150px;">Save</div>
		<div class="menu_boxBtn" style="float:right; width:150px;" onclick="$('#ait_blanket, #create_eventDialog').hide();$('#errMsg').html('')">Close</div>
	</form>
