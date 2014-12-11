//Events screen..
$(document).ready(function(){
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next',
			center: 'title',
			right: 'month,agendaWeek,today'
		},
		editable: true,
		allDayDefault:false,
		timeFormat: 'H:mm',
		firstDay: 1,
        events: function(start, end, timezone, callback) {
				var sessionEvents = sessionStorage.getItem("events");
                   eventList = jQuery.parseJSON(Base64.decode(sessionEvents));
                   var events = formCalendarSource(eventList);
          	       callback(events);
         },
		 eventDrop: function(event, delta, revertFunc) {
			 	updateEventDetails(event);			        
		    },
		    eventResize: function(event, delta, revertFunc) {
		    	updateEventDetails(event);
		    },
		    eventClick: function(calEvent, jsEvent, view) {
			    $("#update_elem_id").val(calEvent.event_id);
			    $("#updateEventErr").html("Loading assigned article...");
			    $("#update_eventTitle, #update_eventTitle_old").val(calEvent.title);
			    
				var articles = sessionStorage.getItem("articles");
				  if(!isJsonString(articles)){
					var objArr = jQuery.parseJSON(Base64.decode(articles));
					for(var i = 0; i< objArr.length; i++){
						var item = new Article();
						item.fromJSON(objArr[i]);
						$("#addContentToEventList").append(item.renderAddArticleView());
					}
				  }							
					$.ajax({		
						type:"POST",
						url: getServerName()+"services/EventManagementService.php",
						data: { action: "getAssignedArticleId", event_id:calEvent.event_id}
					}).done(function( msg ){
						if(msg == 0){
							$("#currentEventArticle").html("None");
						}else{
							$("#currentEventArticle").html(msg);
						}
						$("#updateEventErr").html("Done!");
					});
			    $("#update_eventDialog,#ait_blanket").show();
		    },
		    selectable: true,
			selectHelper: true,
			select: function(start, end) {
				$("#ait_blanket, #create_eventDialog").show();
				var dates={
						start: start,
						end: end
				};
				$("#createEventStartDate").val(dates.start.format());
				$("#createEventEndDate").val(dates.end.format());

				$("#createEventStartDate, #createEventEndDate").datetimepicker({
					dayOfWeekStart : 1,
					lang:'en',
					format: 'Y-m-d H:i',
					});
				
				$("#startDateED").text(dates.start.format().toString());
				// $('#calendar').fullCalendar('renderEvent', eventData, true);
				$('#calendar').fullCalendar('unselect');
			}
	});
//Click Handlers
		$("#update_eventTitleAction").click(function(){
			
			var title = $("#update_eventTitle").val();
			var title_old = $("#update_eventTitle_old").val();
			var event_id =  $("#update_elem_id").val();
	
			if(title.length > 4 && title != title_old){
				$("#updateEventErr").html("Updating Title...");
				$.ajax({		
					type:"POST",
					url: getServerName()+"services/EventManagementService.php",
					data: { action: "updateTitle", event_id:event_id, title:title}
				}).done(function( msg ){
					if(msg == 1){
						//Updating session events
						var sessionEvents = sessionStorage.getItem("events");
					    eventList = jQuery.parseJSON(Base64.decode(sessionEvents));	
					    var newList = [];
						$(eventList).each(function(){
							single = jQuery.parseJSON(this);
							if(single.event_id == event_id){
								single.title = title;
							}
							newList.push(jQuery.toJSON(single));
						});						
						var events = Base64.encode(jQuery.toJSON(newList));
						sessionStorage.setItem("events", events);
						//Updated
						//Refreshing Calendar
						 $('#calendar').fullCalendar( 'refetchEvents' );
							$("#updateEventErr").html("Done!");
					}else{
						alert(msg);
					}
				});
			}			
	});
	$("#update_DeleteEvent").click(function(){
		var title = $("#update_eventTitle").val();
		var event_id =  $("#update_elem_id").val();
		
		var sure = confirm("You are about to delete '"+title+"' event!");
		if(sure){
			$("#updateEventErr").html("Deleting Event...");
			$.ajax({		
				type:"POST",
				url: getServerName()+"services/EventManagementService.php",
				data: { action: "deleteEvent", event_id:event_id}
			}).done(function( msg ){
				//Updating session Events
				var sessionEvents = sessionStorage.getItem("events");
			    eventList = jQuery.parseJSON(Base64.decode(sessionEvents));	
			    var newList = [];
				$(eventList).each(function(){
					single = jQuery.parseJSON(this);
					if(single.event_id != event_id){
						newList.push(jQuery.toJSON(single));
					}
				});						
				var events = Base64.encode(jQuery.toJSON(newList));
				sessionStorage.setItem("events", events);
				//Updated
				//Refreshing Calendar
				 $('#calendar').fullCalendar( 'refetchEvents' );
				 $("#updateEventErr").html("Event Deleted");
				 $("#addContentToEventList .addToPage input").remove();
				 $("#currentEventArticle").html("None");
				 $("#update_eventTitleAction, #update_DeleteEvent").attr('disabled','disabled');
				 $("#update_elem_id").val("");
			});
		}
	});
//Add Event Pop Click handlers
	$("#createEventSelectBox").change(function(){
		if($(this).val() == 1){
			$("#createEventFreqField").show();
		}else{
			$("#createEventFreqField").hide();
		}
	});
	$("#createEventSubmit").click(function(){
		var ewtitle= $("#createEventTitle").val();
		var type_id=$("#createEventSelectBox").val();
		var starts=$("#createEventStartDate").val();
		var ends=$("#createEventEndDate").val();
		var freq=$("#createEventFreq").val();
		var allDay = $("#isAllDay")[0].checked;
		
		if(ewtitle.length > 4 && type_id !="" && starts !="" && ends != ""){
	
			var event={
					title: ewtitle,
					type_id: type_id,
					start: starts,
					end: ends,
					freq: freq,
					allDay: allDay
					};
			eventZiped = Base64.encode(jQuery.toJSON(event));
			$.ajax({		
				type:"POST",
				url: getServerName()+"services/EventManagementService.php",
				data: { action: "create", event: eventZiped}
			}).done(function( msg ){
				// msg = new event item (s)
				var sessionEvents = sessionStorage.getItem("events");
	            eventList = jQuery.parseJSON(Base64.decode(sessionEvents));
	           	var newList = jQuery.parseJSON(Base64.decode(msg));               	
	            $(newList).each(function() {
	            	eventList.push(this);
	            });
	            var events = Base64.encode(jQuery.toJSON(eventList));
	            sessionStorage.setItem("events", events);
	
	            $('#calendar').fullCalendar( 'refetchEvents' );
				$("#ait_blanket, #ait_loader, #ait_loader_txt, #create_eventDialog").hide();
			
				});
		}
	});
});

// Dynamic clisck adder
$(document).on('click', '#addContentToEventList .addToPage input', function(){ 
	var article_id = $(this).parents(".articlesRec").children(":first").html();
	var event_id = $("#update_elem_id").val();
	$("#updateEventErr").html("Updating Event...");
	$.ajax({		
		type:"POST",
		url: getServerName()+"services/EventManagementService.php",
		data: { action: "assignArticle", event_id:event_id, article_id:article_id }
	}).done(function( msg ){
		if(msg == 1){
			$("#currentEventArticle").html(article_id);
			$("#updateEventErr").html("Done!");
		}else{
			alert(msg);
		}
	});
});
//Stand Alone Functions
function formCalendarSource(eventList){
	var events = [];
	     $(eventList).each(function() {
	    	var event = jQuery.parseJSON(this);
	    	if(event.allDay == true){
	    		event.allDay = 1;
	    	}
	    	if(event.allDay == false){
	    		event.allDay = 0;
	    	}
 	      events.push({
				id: event.id,
				title: event.title,
				start: event.start.toString(),
				end: event.end.toString(),
     	        allDay: parseInt(event.allDay),
     	     	event_id: event.event_id,
				color: event.color,
				textColor: event.text_color
 	      });
	     });
	return events;
}
function updateEventDetails(event){
	var sessionEvents = sessionStorage.getItem("events");
    eventList = jQuery.parseJSON(Base64.decode(sessionEvents));	
    
	var end = event.end;
	if(end == null)
		end = "";
	else
		end = end.format();
	var jsonEvent = {
			id: event.id,
			title: event.title,
			start: event.start.format(),
			end: end,
			allDay: event.allDay
		};
	var newList = [];
	$(eventList).each(function(){
		single = jQuery.parseJSON(this);
		if(single.id == jsonEvent.id){
			single.start = jsonEvent.start;
			single.end = jsonEvent.end;
			single.allDay = jsonEvent.allDay;
		}
		newList.push(jQuery.toJSON(single));
	});
	
	var events = Base64.encode(jQuery.toJSON(newList));
	sessionStorage.setItem("events", events);
	
	var worker = new Worker(getServerName()+'js/workers/updateEventDetails.js');
	worker.postMessage(Base64.encode(jQuery.toJSON(jsonEvent)));
	worker.onmessage = function(event) {
        worker.terminate();
    };
    worker.onerror = function(e){
       alert('ERROR: Line '+ e.lineno +' in '+ e.filename+ ': '+ e.message);  
    };
}
