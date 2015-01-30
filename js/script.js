// Delete event
$(".deletable").click(function(e) {
	var info=this;
    var myid=info.id;
    $( "#dialog" ).dialog({
    	dialogClass:"no-close",
    	open: function(event, ui){
        	var text="<p> Time: "+ $("#"+myid+"Date").html() +"</br> Device: "+ $("#"+myid+"Title").html() +"</p>";
    		$("#ui-dialog-title-dialog").html($("#"+myid+"Title").html());
			$( "#dialog" ).html(text);
    	},
    	buttons:{
    		"Delete":function(){
    			var text="<p> Do you want to delete the event: " + $("#"+myid+"Title").html() + " ? </p>";
				$( this ).html(text);
    			$( this ).dialog( "destroy" );
        		$( "#dialog" ).dialog({
        			dialogClass:"no-close",
        			buttons:{
        				"yes":function(){
        					// function for delete the event from the database
        					$('#ajax').load('function/deleteEvent.php', {id:myid}, function() { window.location.reload(); });},
        				"no": function(){
        					$( this ).dialog( "close" );	
        				}
        			}
        		});
    		},
    		"Cancel":function(){
    			$( this ).dialog( "close" );
			}
    	}
    });
});

// Add new event
$(".eventAddable").dblclick(function(){
	var info = this;
    var dayStamp = info.id;
	$("#dialogNewEvent").dialog({
		modal: true,
  	  	dialogClass:"no-close",
		buttons:{
			"Save":function(){		
				var newDeviceId=$("#newEventDeviceId").val();
			    var newStart=$("#newEventStart").val();
	            var newEnd=$("#newEventEnd").val();
	            var newUserId=$("#newEventUserId").val();
			    newStart = newStart.split(":");
			    newEnd = newEnd.split(":"); 
			    var startStamp = parseInt(dayStamp) + (parseInt(newStart[0]) * 60 * 60) + (parseInt(newStart[1]) * 60);
			    var endStamp = parseInt(dayStamp) + (parseInt(newEnd[0]) * 60 * 60) + (parseInt(newEnd[1]) * 60);
				$('#ajax').load(
			        'function/newEvent.php',
			        {deviceId:newDeviceId, start:startStamp, end:endStamp, dayStamp:dayStamp, userId:newUserId},
			        function() { window.location.reload(); }
			    );						
			},
			"Cancel":function(){
    			$( this ).dialog( "close" );
			}
		}
	});
});
  		
// Delete user
$(".deleteUser").click(function() {
	var info=this;
    var myid=info.id;
	$( "#dialogDeleteUser" ).dialog({
		dialogClass:"no-close",
    	buttons:{
			"yes":function(){
				// function for delete the event from the database
        		$('#ajax').load('function/deleteUser.php', {id:myid}, function() { window.location.reload(); } );
        	},
        	"no": function(){
        		$( this ).dialog( "close" );	
        	}
        }
    });
});
  		