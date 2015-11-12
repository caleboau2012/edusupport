<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	global $current_user;
	/*$target_module = 'rolus_Twilio_Account';
	$class = $GLOBALS['beanList'][$target_module];
	require_once($GLOBALS['beanFiles'][$class]);
	$rolus_Twilio_Account = new $class();*/
	
	require_once("modules/rolus_Twilio_Account/rolus_Twilio_Account.php");
	$rolus_Twilio_Account = new rolus_Twilio_Account();
		
	try{
		$capability = $rolus_Twilio_Account->getCapability();
		if(!(is_object($capability) && $capability instanceof Services_Twilio_Capability))
				throw new settingsException('Cannot connect to Twilio','3');

		$capability->allowClientIncoming($current_user->user_name);
		$token = $capability->generateToken();
		
	} catch (communicaitonException $e) {
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}
?>
<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
<script type="application/javascript" src="custom/include/javascript/flash_detect_min.js"></script>
<script type="text/javascript" src="custom/include/javascript/FormatPhone.js"></script>
<link type="text/css" rel="stylesheet" href="custom/include/call_css/style.css" />

<style type="text/css">
	.status_config
	{
		position:absolute;
		text-align:right;
		width:40px;
		float:right;
		margin-left:340px;
		margin-top:-10px;
		color:#32CD32;
		font-size:20px;
	}
	#noscript
	{		
		width: 620px;
		height: 50px;
		font-size: 30px;
		font-weight: bold;
		color: red;
		position: absolute;
		top: 5%;
		left: 20%;
		z-index:-9999;
	}
</style>
<script type="text/javascript">
				
		var incoming_number='';
		var incoming_connection ='';
		var call_id = '';
   	    var rejected ='';
		var related_id = '';
		var related_module = '';
		var call_con_checker_inbound = false; // this will check the call is currently in active state or in in-active state
		var incoming_call_flag = false; // show call div only when icoming call event occurs otherwise hide call div permanently 
		var available_user_name = ''; // this will contain the user_name of that particular user which has no extension configured in user's module
		var setupTimerIncoming = ''; // time interval after which our code will again call the twilio device setup method to validate the already generated token and make device ready for connections
		var setupTimeOutIncoming = 0; // time out interval after which code will alert that Twilio is not available
		
		/*
		*	this will set the UI according to requirements during page load
		*/
		function dom_ready_for_incoming_UI()
		{
			$('#callWrapperInbound').WindowStatesInbound({
				defaultState		:	'max' // max, min, shade 
			});
			$("#callWrapperInbound").hide("fast");						
			
			$("#call_points_div").css({display:"none"});
			$("#detail_box").css({display:"none"});			
			$("#end_call").hide();			
			$("#accept_call").show();
			$("#reject_call").show();
		}
		
		/*
		*	this will actually accept the incoming connection
		*/
		function accept_incoming_call()
		{
			$("#log").text("Establishing Call...");				
			$("#call_points_div").css({display:"block"});	
			$("#accept_call").hide('fast');
			$("#reject_call").hide('fast');
			$("#end_call").show('fast');
			incoming_connection.accept();// this function will accept the incoming call	
			
			$("#accept_call").attr("disabled","disabled");
			$("#accept_call").css({cursor:"default"});
			$("#reject_call").attr("disabled","disabled");			
			$("#reject_call").css({cursor:"default"});				
		}
		
		/*
		*	this will handle that the incoming connection is rejected by callee
		*/
		function reject_incoming_call()
		{
			$("#reject_call").attr("disabled","disabled");
			$("#reject_call").css("cursor","default");
			$("#accept_call").attr("disabled","disabled");
			$("#accept_call").css("cursor","default");
						
			incoming_connection.reject();//reject the current incoming dialing connection 
			rejected = "rejected";
		}
		
		/*
		*	this will handle the hanging up current inbound connection
		*/	
		function hangup_incoming_call()
		{
			$("#end_call").hide();
			$("#end_call").attr("disabled","disabled");	
			$("#end_call").css("cursor","default");				
			$("#accept_call").show();
			$("#reject_call").show();

			incoming_connection.disconnect();//close or disconnect the current open connection 
		}
		
		/*
		*	this will save the currently interacting call keypoints to db
		*/
		function save_call_keypoints()
		{
			var call_keypoints = $("#call_points").val();
			$.ajax({
				url:"index.php",
				type:"POST",
				data:"module=Calls&action=inbound_call_recording&sugar_body_only=true&call_points="+call_keypoints+"&call_id="+call_id,
				dataType:"html",
				async:true,
				cache:false,
				success:function(response){
					if(response == "true")
					{
						$("#inbound_call_points_save_status").text("saved").show().fadeOut(2000);							
					}
				},
				error:function(jqXHR,textStatus,errorThrown)
				{
					if(jqXHR.readyState == 0)
					{
						alert("Internet Connection Problem");						
					}
					else
					{
						console.log("Error Occurred on server side(saving Call Note) : "+textStatus);
					}					
				}					
			});
		}
		
		/*
		*	this will forward the current call to the desired party by entering extension of that party
		*/
		function forward_current_call()
		{			
			var user_extension = parseInt($("#user_extension").html()) || 0; //check the entered extension is a valid integer			 						
			if(isNaN(user_extension))
			{				
				$("#inbound_call_points_save_status").text("Invalid").show().fadeOut(2000);
			}
			else
			{
				if(user_extension == 0)
				{
					user_extension = 'false';
				}
				$("#inbound_call_points_save_status").text("Forwarding").show().fadeOut(2000);
				$.ajax({ // update reject call status					
					url:"index.php",
					type:"POST",
					data:"module=Calls&action=ForwardIncomingCall&sugar_body_only=true&user_extension="+user_extension+"&call_sid="+call_id+"&available_user_name="+available_user_name,
					dataType:"html",
					async:true,
					cache:false,
					success:function(forwarded_call)					
					{						
						if(forwarded_call == "forwarded")
						{
							$("#inbound_call_points_save_status").text("Forwarded").show().fadeOut(2000);
						}
						else
						{
							$("#inbound_call_points_save_status").text("failed").show().fadeOut(2000);
						}	
					},
					error:function(jqXHR,textStatus,errorThrown)
					{
						if(jqXHR.readyState == 0)
						{
							alert("Internet Connection Problem");						
						}
						else
						{
							console.log("No Other User is logged In !"+textStatus);
						}						
					}
				});
			}		
		}
		
		/*
		*	DOM ready function
		*/
		$("document").ready(function(){
			
				
			dom_ready_for_incoming_UI();// set the initial UI for interacting incoming call
			
			/*
			*	it will display the Contact detail of the Caller, if exist in Sugar
			*/
			$("#detail_action").click(function(){
				$("#detail_box").css({display:"block"});
			});
			
			//accepting the incoming call
			$("#accept_call").click(function(){
				accept_incoming_call();
			});
			
			//rejecting the incoming call
			$("#reject_call").click(function(){
			
				reject_incoming_call();
				
			});
			
			//hanging up the incoming call
			$("#end_call").click(function(){
				
				hangup_incoming_call();
				
			});
			
			//saving the call key points to db 
			$("#save_call_points").click(function(){
		
				save_call_keypoints();
			});
			
			//hiding the detail box upon clicking call contact close button
			$("#call_contact_div").click(function(){
				$("#detail_box").hide();			
			});
							
	
		}); //ending the document.ready method
		
		
		//start inbound call plugin
		(function ($) {
			$.fn.WindowStatesInbound = function (option) {				
				option = $.extend({}, $.fn.WindowStatesInbound.option, option);				
					cw = $('#' + option.callsWrapper);
					cc = $('#' + option.callContents);
					sc = $('#' + option.callStatus);
					ct = $('#' + option.callType);
					cd = $('.' + option.callDetails);
					cn = $('#' + option.callerName);
					cp = $('#' + option.callerPhone);
					tm = $('#' + option.twilioMessage);					
					acn = $('#' + option.addCallNotes);
					ma = $('#' + option.moreActions);		
					map = $('#' + option.moreActionsPopup);					
					ctd = $('#' + option.contactDetailLink);					
					cld = $('#' + option.callDetailLink);
					cla = $('#' + option.callActionBtns);
					acl = $('#' + option.acceptCall);
					rcl = $('#' + option.rejectCall);	
				
					$.fn.callSwitchInbound(option.defaultState, option);
					
					minButton.click(function () {
						$.fn.callSwitchInbound('min', option);
						
					});
					
					shadeButton.click(function () {
						$.fn.callSwitchInbound('shade', option);
						
					});
					
					maxButton.click(function () {
						$.fn.callSwitchInbound('max', option);
						if(cd.children().hasClass('actionBox')){
							ma.children().remove();
						}
						else
						cd.prepend(map);
					});
					
					shadeMaxButton.click(function () {									
						$.fn.callSwitchInbound('shademax', option);
						if(cd.children().hasClass('actionBox')){
							ma.children().remove();
						}
						else
						cd.prepend(map);
					});
														
					closeButton.click(function () {
						$.fn.callSwitchInbound('close', option);
					});											
			};

			$.fn.WindowStatesInbound.option = {
				defaultState: 'min',
				callsWrapper: 'callWrapperInbound',
				callContents: 'callContent',
				callType: 'callType',
				callStatus: 'callStatus',
				twilioMessage: 'log',												
				callDetails: 'callDetailLink',
				callerName: 'callerName',
				callerPhone: 'callerPhone',
				addCallNotes: 'call_points_div',
				callActionBox: 'moreActions',				
				contactDetailLink: 'contact_detail',
				callDetailLink: 'call_detail',
				callActionBtns: 'call_handler_div_inbound',
				acceptCall: 'acceptCall',
				rejectCall: 'rejectCall',
				moreActions: 'moreActions',
				moreActionsPopup: 'moreActionsPopup'
			};
			
			$.fn.callSwitchInbound = function (incoming_state, option) {
				if(incoming_state == 'min' || incoming_state == 'shade'){
					ma.append(map);
				}
				else
				closeButton = $('#closeOperationInbound');
				maxButton = $('#maximizeOperationInbound');				
				minButton = $('#minimizeOperationInbound');
				shadeButton = $('#shadeOperationInbound');
				shadeMaxButton = $('#shadeMaxOperationInbound');
			
				switch (incoming_state) {
					case "max":						
						cw.attr('class', 'callWrapper');
						if(incoming_call_flag == true)
						{
							cw.show();										
						}	
						ct.show();	
						acn.show();		
						minButton.show();							
						shadeMaxButton.hide();
						$("#user_ext_div").show();						
						$('#callWrapperInbound').css({top:"60%"});											
						if(call_con_checker_inbound == true)
						{
							$("#call_points_div").show();						
						}
						else if(call_con_checker_inbound == false)
						{
							$("#call_points_div").hide();						
						} 
						break;
					case "min":
						/*if(call_con_checker_inbound == true)
						{								
							$("#minimizeOperationInbound").removeAttr("disabled");*/																					
							cw.attr('class', 'callWrapperminimized');
							cw.show();						
							maxButton.show();
							shadeButton.show();		
							shadeMaxButton.show();								
							$("#call_contact_div").hide();								
							$("#user_ext_div").hide();
							minButton.hide();
							ct.show();							
							acn.hide();							
							$('#callWrapperInbound').css({top:"96%"});
						/*}
						else if(call_con_checker_inbound == false)
						{
							$("#minimizeOperationInbound").attr({disabled:"disabled"});														
						}*/
						break;
					case "shade":
						/*if(call_con_checker_inbound == true)
						{*/						
							//$("#shadeOperationInbound").removeAttr("disabled");							
							cw.attr('class', 'callWrappershaded');
							cw.show();						
							minButton.show();
							maxButton.hide();
							shadeButton.hide();
							shadeMaxButton.show();							
							$("#call_contact_div").hide();								
							$("#user_ext_div").hide();
							ct.hide();
							acn.hide();
							ct.show();						
							$('#callWrapperInbound').css({top:"97%"});
						/*}
						else if(call_con_checker_inbound == false)
						{
							$("#shadeOperationInbound").attr({disabled:"disabled"});							
						}*/						
						break;
					case "shademax":						
						cw.attr('class', 'callWrapper');
						cw.show();						
						minButton.show();
						maxButton.hide();
						shadeButton.show();
						shadeMaxButton.hide();
						$("#call_contact_div").show();					
						$("#user_ext_div").show();
						ct.show();
						acn.show();						
						$('#callWrapperInbound').css({top:"60%"});																			
						if(call_con_checker_inbound == true)
						{
							acn.show();						
						}
						else if(call_con_checker_inbound == false)
						{
							acn.hide();
						}	
						break;		
					
					case "close":
					if(call_con_checker_inbound == true)	
					{
						/*if(call_con_checker_inbound == true)
						{								
							$("#minimizeOperationInbound").removeAttr("disabled");*/																					
							cw.attr('class', 'callWrapperminimized');
							cw.show();						
							maxButton.show();
							shadeButton.show();		
							shadeMaxButton.show();	
							$("#user_ext_div").hide();
							minButton.hide();
							ct.show();							
							acn.hide();							
							$('#callWrapperInbound').css({top:"96%"});
						/*}
						else if(call_con_checker_inbound == false)
						{
							$("#minimizeOperationInbound").attr({disabled:"disabled"});														
						}*/
					}
					else if(call_con_checker_inbound == false)
					{
						incoming_call_flag = false; 					
						$("#contact_detail").attr({href:"#"});	
						$("#contact_detail").css({cursor:"default"});
						$("#callWrapperInbound").hide("slow");
						//incoming_connection.disconnect();//close or disconnect the current open connection 		
					}							
				}
			}
		})(jQuery);	
		
		//end inbound call plugin
		
		window.onload = function settingUpTwilioDeviceIncoming() {
				twilioDeviceSetupIncoming();
		}
				
		/*
		*	this function will check that if twilio JS library is not loaded in web page then inform end user 
		*	if loaded then verfiy the twilio capability token to make device capable to make outbound call and receive incoming call
		*/
		function twilioDeviceSetupIncoming() {	
			
			/*
			*	This will detect that whether twilio lib is properly loaded or not online
			*/
			if(!window.Twilio)
			{
				alert("Twilio Library is not loaded, Reload Page or Contact to Network Administrator");				
			}
			else
			{
				setupTimerIncoming = setInterval(function() {					
				
					var Setup_resIncoming = Twilio.Device.setup("<?php echo $token;?>"); 																	
					if(Setup_resIncoming != null) // means the token has verified perfectly and twilio is ready to initiate call by returning verified Device Object
					{						
						$('#outbound_log').text('Ready');
						clearInterval(setupTimerIncoming);//to stop the timer or setInterval()
					}
					else
					{
						console.log("setupTimeOutIncoming => "+setupTimeOutIncoming);
						setupTimeOutIncoming +=1;
						if(setupTimeOutIncoming == 120) //
						{
							alert("Twilio is not available, Refresh Page");
							clearInterval(setupTimerIncoming);//to stop the timer or setInterval()
							setupTimeOutIncoming = 0;
							$('#outbound_log').text('Invalid Connection,Refresh Page');			
						}							
					}					
				}, 1000);
			}// end else case in which twilio token authentication is verified			
			
			is_adobe_flash_installed(); // it will check whether adobe flash player is installed or not			
			
			is_safari_browser(); // it will check if browser is 		
			
		}// end twilio device capability token verification function
		
		/*
		*	This will detect whether adobe flash player is installed on browser or system 
		*	If not istalled then prompt user to install it to use twilio functionality 
		*/
		
		function is_adobe_flash_installed()
		{						
			if(!FlashDetect.installed){
				alert("Adobe Flash Player is required to use Twilio functionality.");  
			    $('#outbound_log').text('Unable to connect, Flash Player needed');
				isFlashInstalledError = true;
			}
		}
		
		/*
		*	This will detect whether the current browser is safari or someone else
		*	If underlying browser is safari then prompt user to install the Quick Time Player Plugin
		*/
		
		function is_safari_browser()
		{						
			var is_Safari = false;
			var is_Chrome = false;
			var val_browser = navigator.userAgent.toLowerCase();
						
		  	if(val_browser.indexOf("safari") > -1)
		  	{				
				is_Safari = true;			  		
		  	}
			if(val_browser.indexOf("chrome") > -1)
			{
				is_Chrome = true;	
			}
			if(is_Safari == true && is_Chrome == false)
			{
				if(is_quicktime_installed() == false)
					alert("Your browser is Safari, Download & install the Quick Time Player from apple.com to listen twilio recorded calls");	
			}	
		}
		
		/*
		*	check the presence of QuickTime Player plugin installed or not 
		*/
		function is_quicktime_installed()
		{
			
			var quicktime_installed = false;			
			if (navigator.plugins) {
				for (i=0; i < navigator.plugins.length; i++ ) 
				{
					if (navigator.plugins[i].name.indexOf("QuickTime") >= 0)
					{ 
						quicktime_installed = true; 
						return true;
					}
				}
			}
			return false;	
		}
		
		/*
		*	when called means, the javascript device is ready to listen incoming connection or event
		*/
		Twilio.Device.ready(function (device) {
			$("#log").text("Ready");
			$('#outbound_log').text('Ready');
			deviceReady = true;
			if (typeof sourceSelected != 'undefined')
			{
			if(sourceSelected){
				enableCallButton();
			}
		}
			// $(".call_maker").css({display:"block"});	
		});
		
		/*
		*	this will call, when there came an error during connection interaction
		*/
		Twilio.Device.error(function (error) {
			$("#log").text("Error: " + error.message);
			$('#outbound_log').text("Error, Refresh Page");
		});
	 
		/*
		*	this will call, when network connection is offline or switch between online or offline state
		*/
		Twilio.Device.offline(function() {
			 $("#log").text("Offline");		
			 $('#outbound_log').text('Offline, Refresh Page');
		});	
	  
    /*
	*	this will handle the rejected incoming call status 			
	*/
	function set_call_declined(declined_status)
	{		
		call_con_checker_inbound = false;
		incoming_call_flag = false;
		if(call_con_checker_inbound == false)
		{
			$("#call_points_div").show();						
		}
		$.ajax({ // update declined call status					
			url:"index.php",
			type:"POST",
			data:"module=Calls&action=call_tracker&sugar_body_only=true&call_status="+declined_status+"&call_id="+call_id,
			dataType:"html",
			async:true,
			cache:false,
			success:function(response)					
			{
				// ajax call if we need to display call history 
				fetch_call_detail();// fetch the ended call detail
			},
			error:function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem");						
				}
				else
				{
					console.log("Error occurred on server side(call declined status) :"+textStatus)
				}				
			}
		});
	}	
	
	/*	
	*	event handler that will catch the canceled/rejected call status
	*/
	Twilio.Device.cancel(function(conn) {
		if(conn.parameters.From){
			var declined_status = '';
			if(rejected == "rejected")
			{
				$("#log").text("Call Rejected");
				declined_status = rejected;
			}
			else
			{			
				$("#log").text("Call Canceled");
				declined_status = 'canceled';
			}
			set_call_declined(declined_status);
			
			$("#accept_call").attr("disabled","disabled");
			$("#accept_call").css({cursor:"default"});
			$("#reject_call").attr("disabled","disabled");			
			$("#reject_call").css({cursor:"default"});
			
			$("#call_points_div").hide();
			$("#quick_create_contact_label").hide();
			$("#quick_create_lead_label").hide();	
			$("#quick_create_contact").hide();
			$("#quick_create_lead").hide();		
		}
		else{
			call_con_checker = false;						
			$('#outbound_log').text("Call Canceled");
		}
				
	});	
		
	/*
	*	this will update the operator/user status in db to busy(executing call)
	*/
	function set_operator_status_busy()
	{
		$.ajax({
			url: 'index.php',
			type: 'POST',
			data:'module=Users&action=call_establish&sugar_body_only=true&connect=true',
			dataType: 'html',
			async: true,
			cache: false,		
			success: function(response){				
				//if(data){}				
			},
			error: function(jqXHR,textStatus,errorThrown)
			{	
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem, Connect Internet within 10 to 15 otherwise Call will be disconnected!");						
				}
				else
				{
					console.log("Problem occurred on Server side(connect call ) : "+textStatus); 
				}				
			}
		});
		
		set_call_established();//update call status to established				
	}
	
	/*
	*	this will update the currently incoming call status to established in db
	*/
	function set_call_established()
	{
		$.ajax({
			url:"index.php",
			type:"POST",
			data:"module=Calls&action=call_tracker&sugar_body_only=true&call_status=established&call_id="+call_id,
			dataType:"html",
			async:true,
			cache:false,
			success:function(response)
			{
				//getting true 
			},
			error:function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem, Connect Internet within 10 to 15 otherwise Call will be disconnected!");						
				}
				else
				{
					console.log("Error occurred on server side(established status) :"+textStatus);
				}				
			}
		});
	}
	
	/*
	*	The Event Handler that will catch the call connect event and establish connection between two parties
	*	and update the user/operator availability(busy) and call(establish) statuses to db
	*/
	Twilio.Device.connect(function (conn) {
		if(conn.parameters.From){
			$("#log").text("Successfully Established Call");
			call_con_checker_inbound = true;		
			if(call_con_checker_inbound == true)
			{
				$("#call_points_div").show();						
			}
			var final_encoded_number = get_encoded_numbers();//return the url-encoded phone number	
			set_call_dialing(final_encoded_number);//update call status to dialing
			set_operator_status_busy();	//update user status to busy
		}
		else{
			$(".call_maker").attr("disabled","disabled"); // disable all other buttons to make call while current one is in active state
			$("#phone_fax").attr("disabled","disabled"); // disable all other buttons to make call while current one is in active state
			if(call_canceled == true)
			{			
				conn.disconnect({debug : true}); // canceled and disconnected the current connection			
			}
			else if(conn.status() == "open")
			{								
				call_con_checker = true;				
				$('#outbound_log').text("Dialed");	
				
				set_operator_status_busy(); // it tells user is busy now to call
				//establish_browser_call();			
			}
		}
    });
 
	/*
	*	this will update the operator/user status in db to available(free to accept call)
	*/
	function set_operator_status_available()
	{
		$.ajax({
			url: 'index.php',
			type: 'POST',
			data:'module=Users&action=call_establish&sugar_body_only=true&connect=false',
			dataType: 'html',
			async: true,
			cache: false,
			success: function(response){
				//if(data){}				
			},
			error: function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem");						
				}
				else
				{
					console.log("Problem Occur on Server side (disconnect call) : "+textStatus);
				}				
			}			
	   });
	   
	   set_call_completed();//update call status to Held				
	}
	
	/*
	*	this will update the currently incoming call status to Held in db
	*/
	function set_call_completed()
	{
		$.ajax({// this will update call_status to Held and calculate the call duration 
			url:"index.php",
			type:"POST",
			data:"module=Calls&action=call_tracker&sugar_body_only=true&call_status=Held&call_id="+call_id,
			dataType:"html",
			async:true,
			cache:false,
			success:function(response)// response will be in the form of json
			{
				//console.log(response);				
			},
			error:function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem");						
				}
				else
				{
					console.log("Error occurred on server side:(Held status)"+errorThrown);
				}	
				
			}
	   });
	   
	   fetch_call_detail();// fetch the ended call detail
	}
	
	/*
	*	this will provide the link to visualise the currently ended call detail
	*/
	function display_call_detail(incoming_call_detail)
	{
		if(incoming_call_detail)
		{
			$("#call_detail").css({cursor:"pointer"});
			$("#call_detail").attr({href:"<?php echo $GLOBALS['sugar_config']['site_url'];?>"+"/index.php?action=DetailView&module=Calls&record="+incoming_call_detail.id});
			$("#call_detail").attr({title:"View Detail of the Call"});
			//$("#contact_detail").attr({href:"#"});
			//$("#contact_detail").css({cursor:"default"});
		}	
	}
	
	/*
	*	this will fetch the currently ended call detail with recordings and call duration 
	*/
	function fetch_call_detail()
	{
		$.ajax({ // this will fetch the currently Held call detail 
			url:"index.php",
			type:"POST",
			data:"module=Calls&action=call_detail&sugar_body_only=true&fetch=call_detail&call_id="+call_id,
			dataType:"json",
			async:true,
			cache:false,
			success:function(incoming_call_detail)					
			{ 
				display_call_detail(incoming_call_detail);//will display the call detail
			},
			error:function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem");						
				}
				else
				{
					console.log("Error occurred on server side(fetch call detail) :"+textStatus)
				}					
			}
		});
	}
		
	/*
	*	event handler that will catch the call disconnect event and disconnect(close) connection between two parties 
	*	and update the user/operator availability(available) and call(Held) statuses to db
	*/
	Twilio.Device.disconnect(function (conn) {
		if(conn.parameters.From){
			$("#log").text("Call Ended");
			$("#end_call").hide();
			$("#end_call").attr("disabled","disabled");	
			$("#end_call").css("cursor","default");
			$("#call_points_div").css({display:"none"});
			incoming_call_flag = false;
			call_con_checker_inbound = false;
			
			$("#call_points_div").hide();						
			
			set_operator_status_available();//update user status to available	
		}
		else{
			call_con_checker = false;
			$("#outbound_call_points_div").css({display:"none"});					
			$("#outbound_call_detail").css({display:"block"});			
			$("#browser_endcall").css({display:"none"});
			$("#source_call").attr({class:"outboundDisabled"});
			$("#source_call").attr({disabled:"disabled"});
			$("#source_call").css({cursor:"default"});
			$("#source_call").css({display:"block"});	
			$(".call_maker").removeAttr("disabled");//enabling the other calls buttons			
			$("#phone_fax").removeAttr("disabled");//enabling the other calls buttons			
			
			var final_call_status = 'Held';
			if(call_canceled == true)
			{
				$('#outbound_log').text("Call Canceled");	
				final_call_status = 'canceled';
			}
			else
			{
				$('#outbound_log').text("Call Ended");				
			}	
			
			$("#outbound_call_detail").css({display:"block"});					
			$("#outbound_call_detail").attr({href:"<?php echo $GLOBALS['sugar_config']['site_url'];?>"+"/index.php?action=DetailView&module=Calls&record="+ref_call_id});
			$("#outbound_call_detail").attr({title:"View Detail of the Call"});
						
			end_browser_call(final_call_status);//updating the ended call status to db
					
			set_operator_status_available(); // setting operator available to attend inbound call
		}
	  
    });	
	
	/*
	*	this will manage the incoming UI to become attractive and response for user to accept/reject/end call
	*/
	function manage_incoming_call_UI()
	{
		$("#accept_call").removeAttr("disabled");
		$("#accept_call").css({cursor:"pointer"});
		$("#reject_call").removeAttr("disabled");			
		$("#reject_call").css({cursor:"pointer"});
		
		$("#end_call").hide();
		$("#end_call").css({cursor:"pointer"});
		$("#end_call").removeAttr("disabled");			
		
		$("#accept_call").show();
		$("#reject_call").show();
		$("#accept_call").css({cursor:"pointer"});
		$("#reject_call").css({cursor:"pointer"});
	}
	
	/*
	*	this will set the icoming call status to dialing whenever call comes to this application 
	*/
	function set_call_dialing(final_encoded_number)
	{
		//setting the incoming call status
		$.ajax({
			url:"index.php",
			type:"POST",
			data:"module=Calls&action=call_tracker&sugar_body_only=true&call_status=dialing&RelatedModule="+related_module+"&RelatedId="+related_id+"&source="+final_encoded_number+"&destination="+incoming_connection.parameters.To+"&call_id="+call_id,
			dataType:"html",
			async:true,
			cache:false,
			success:function(response)
			{
				//console.log("response"+response);
			},
			error:function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem");						
				}
				else
				{
					console.log("Error occurred on server side(dialing status): "+textStatus);
				}				
			}		
		});
	}
	
	/*
	*	this will process the incoming phone number and convert it into different possible formats 
	*	to retrieve contact info from data base against formatted phone number
	*/
	function processPhone(country,phone) {
	
		/*phone = "+1 310-601-4696";
		country = "US";	*/
		//country = "US"; // for testing purposes
		var formatted_numbers = Array();
		formatted_numbers['format_zero'] = phone.replace('+','00');
		formatted_numbers['format_simple'] = formatE164(country, phone);
		formatted_numbers['format_international'] = formatInternational(country, phone);
		formatted_numbers['format_local'] = formatLocal(country, phone);
				
		return formatted_numbers;
	}
	
	/*
	*	this will return the final url-encoded phone number of the caller
	*/
	function get_encoded_numbers()
	{
		var phone_number = get_processed_inbound_number();	// return the processed number after excluding extra characters
		var final_encoded_number = phone_number.replace("+","%2B").replace(" ","%20"); //encoding +,space character	
		return final_encoded_number;
	}
	
	/*
	*	this will exclude 1 appended with any regional phone number coming with inbound connection from twilio
	*	and tries to return the only the valid number to display to front end as inbound caller detail	
	*/
	function get_processed_inbound_number()
	{
		var inbound_number = incoming_connection.parameters.From;
		if(inbound_number.length == 12) // 12 length number represents that number is actually of US
		{			
			var incoming_number = inbound_number;
		}
		else
		{
			if(inbound_number.substr(1,1) != 7 && inbound_number.substr(1,1) == 1)
			{
				var incoming_number = inbound_number.replace(inbound_number.substr(1,1),"");
			}
			else 
			{
				var incoming_number = inbound_number;
			}	
		}
		return incoming_number;
	}	
	
	/*
	*	this will fetch the caller detail if exist in one of the Sugar's modules
	*/
	function fetch_contact_detail()
	{
		var incoming_number = get_processed_inbound_number(); // return the processed number after excluding extra characters
				
		var incoming_country = countryForE164Number(incoming_number);		
		var incoming_num = incoming_number.replace("+",'');
		var formatted_numbers = processPhone(incoming_country,incoming_num);//return different formats of an incoming phone number
		
		formatted_numbers['format_simple'] = formatted_numbers['format_simple'].replace('+','%2B');
		formatted_numbers['format_international'] = formatted_numbers['format_international'].replace('+','%2B').replace(' ','%20').replace('-','%2D');
		formatted_numbers['format_local'] = formatted_numbers['format_local'].replace('(','%29').replace(')','%28').replace(' ','%20').replace('-','%2D');
		
		//getting contact detail from Contacts/Leads/Accounts/Users modules
		$.ajax({
			url: "index.php",
			type:"POST",
			data:"module=Contacts&action=get_contact_detail&sugar_body_only=true&format_zero="+formatted_numbers['format_zero']+"&format_simple="+formatted_numbers['format_simple']+"&format_international="+formatted_numbers['format_international']+"&format_local="+formatted_numbers['format_local'],
			dataType:"json",
			async: true,
			cache: false,
			success: function(response_contact){
				if($.isEmptyObject(response_contact)) // check that ajax call didn't take anything from contacts
				{
					display_unknown_contact_info(incoming_number);// if no contact record is found in Sugar
				}
				else
				{
					display_sugar_contact_info(response_contact,incoming_number);// display sugar contact info					
				}
				
				
				fetch_users_for_call_forwarding(); // fetch all logged in users capable of forwarding call to them
			},
			error: function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem");						
				}
				else
				{
					console.log("Problem occurred on Server side(getting contact detail): "+textStatus);
				}				
			}
		});
	}
	
	/*
	*	this will display the unknown caller info to user if no contact record is found in Sugar
	*/
	function display_unknown_contact_info(incoming_number)
	{
		$("#contact_name").text("Name : Unknown Contact");
		$("#contact_number").text("Phone# : "+incoming_number);	
		
		var inbound_number = get_processed_inbound_number();
		var incoming_number = inbound_number.replace("+","%2B");
		
		$("#quick_create_contact_label").css({display:"block"});
		$("#quick_create_lead_label").css({display:"block"});
		
		$("#quick_create_contact").css({display:"block"});
		$("#quick_create_lead").css({display:"block"});
		
		$("#quick_create_contact").attr({href:"<?php echo $GLOBALS['sugar_config']['site_url'];?>/index.php?module=Contacts&action=EditView&phone_work="+incoming_number+"&twilio_call_id="+call_id});
		$("#quick_create_lead").attr({href:"<?php echo $GLOBALS['sugar_config']['site_url'];?>/index.php?module=Leads&action=EditView&phone_work="+incoming_number+"&twilio_call_id="+call_id});
		
		$("#contact_detail").css({cursor:"default"});
		$("#call_detail").css({cursor:"default"});
	}
	
	/*
	*	this will display the caller detail info, if caller's record is found in sugar's modules
	*	like Contacts, Leads, Accounts, Users, and in any custom module if provided
	*/
	function display_sugar_contact_info(response_contact,incoming_number)
	{
		related_id = response_contact.id;
		related_module =  response_contact.moduleName;
		var caller_contact_name = '';
		caller_contact_name = response_contact.first_name+" ";
		caller_contact_name += response_contact.last_name;
		$("#contact_name").text("Name : "+caller_contact_name);
		$("#contact_number").text("Phone# : "+incoming_number);
		$("#contact_detail").attr({href:"#"});
		$("#contact_detail").attr({href:"<?php echo $GLOBALS['sugar_config']['site_url'];?>"+"/index.php?action=DetailView&module="+response_contact.moduleName+"&record="+response_contact.id});	
		$("#contact_detail").attr({title:"View Detail of the Caller"});
		$("#call_detail").css({cursor:"default"});
	}
		
	/*
	*	this will fetch all the logged in users for call forwarding and for viewing only to operator
	*/
	function fetch_users_for_call_forwarding()
	{
		//getting contact detail from Contacts/Leads/Accounts/Users modules
		$.ajax({
			url: "index.php",
			type:"POST",
			data:"module=Calls&action=fetch_users_for_call_forwarding&sugar_body_only=true",
			dataType:"json",
			async: true,
			cache: false,
			success: function(response_users){
				if(!$.isEmptyObject(response_users)) // check that ajax call didn't take anything from contacts
				{
					$("#user_ext_div").css({visibility:"visible"});
					display_logged_in_available_users(response_users);// if no contact record is found in Sugar
				}
				else
				{
					$("#user_ext_div").css({display:"none"});
				}
			},
			error: function(jqXHR,textStatus,errorThrown)
			{
				if(jqXHR.readyState == 0)
				{
					alert("Internet Connection Problem");						
				}
				else
				{
					console.log("No other user is Logged In"+textStatus);
				}				
			}
		});
	}

	/*
	*	this will display all logged in users in a side div for Operator to forward call to.
	*/
	function display_logged_in_available_users(response_users)
	{	
		users_div = '<div id="users_div" class="callFwdContents" >';
		
		users_div += '<div id="extWindow" style="overflow-y:auto;" >';
		
		users_div += '<div id="extLayer" >';
		
		users_div += '<ul >';
				
		$.each(response_users,function(user,user_detail){
			if(user_detail.availability == 1)
			{
				users_div += '<li class="disabled_item" style="cursor:default;" ><del>';
				if(!(user_detail.extension))
				{
					var user_name = user_detail.ext_name.replace("()",""); 
					users_div += user_name;
				}
				else 
				{
					users_div += user_detail.ext_name;
				}
				users_div += '</del></li>';

			}else
			{				
				users_div += '<li class="listitems" onclick="populate_user_extension(this);" id="'+user_detail.user_name+'">';
				if(!(user_detail.extension))
				{
					var user_name = user_detail.ext_name.replace("()",""); 
					users_div += user_name;				
				}
				else 
				{
					users_div += user_detail.ext_name;
					users_div += '</li>';
				}	
			} 			
		});		
						
		users_div += '</ul>';
		users_div += '</div>';	//end extLayer div
		users_div += '</div>';	//end extWindow div				
		users_div += '<div class="extention">';
        
        users_div += '<span id="user_extension" class="extFwd"></span>';
        
		users_div += '<div class="forward">';        
		users_div += '<span id="forward_call" title="Forward Call to User" class="fwdBtn" onclick="call_forwarding()" ></span>';
        users_div += '</div>'; // end forward div
		
        users_div += '</div>'; // end extention div
		
		
		users_div += '</div>'; // callFwdContents div 
		
		$("#user_ext_div").html(users_div);			
	}
		
	/*
	*	this will return the default settings of the incoming call popup div before any incoming call
	*/	
	function get_default_popup_settings(conn)
	{
		$("#log").text("Ready");	
		
		/*setting the default position and dimension of the incoming call popup after ending first call */	
		$('#callWrapperInbound').WindowStatesInbound({
				defaultState		:	'max' // max, min, shade 
		});
		
		/* initially hide quick create contact n lead icons */
		$("#quick_create_contact").css({display:"none"});
		$("#quick_create_lead").css({display:"none"});
		
		$("#quick_create_contact_label").css({display:"none"});
		$("#quick_create_lead_label").css({display:"none"});
		
		$("#call_points_div").css({display:"none"});
		$("#call_points").val("");
		$("#detail_box").css({display:"none"});			
		
		$("#user_ext_div").css({visibility:"hidden"});		
		$("#end_call").hide();			
		$("#accept_call").show();
		$("#reject_call").show();
		
		incoming_call_flag = true;
		rejected = '';
		incoming_connection = conn;
		call_id = incoming_connection.parameters.CallSid;	
				
		manage_incoming_call_UI();// update the incoming call UI	
			
		fetch_contact_detail();//fetch sugar contact detail
		
		fetch_users_for_call_forwarding();
		
		$("#callWrapperInbound").show('fast');
	}
	<?php
	/* Provide Access to only those users having VOIP access of inbound or both */
	if($GLOBALS['current_user']->voip_access == 'inbound' OR $GLOBALS['current_user']->voip_access == 'both')
	{
	?>
		/*
		*	The Main Entry Point for accepting Incoming call
		*	this will wait for the incoming call event that will be sent to this application 
		*	untill 1 hour passed by default, if there will occur no refresh in html page
		*/
		Twilio.Device.incoming(function (conn) 
		{
			get_default_popup_settings(conn); // this is to reset all default configurations before every incoming call		
		});
	<?php		
	}
	?>
	/*
	*	this will handle the hide/show properties of the users div
	*/
	function hide_user_div(){		
		$('.callForward').toggleClass('hide');
	}
	
	/*
	*	this will forward call to particular selected user via extension or username
	*/
	function call_forwarding()
	{			
		forward_current_call();	
	}		
	
	/*			
	*	this will provide selection to operator to select from user to which call is to be forwarded
	*/
	
	function populate_user_extension(current) {
		id = current.id;
		available_user_name = $("#"+id).attr("id"); // getting the selected user_name having no extension								
		var list_val = $("#"+id).html();
		var ext_end = list_val.indexOf(")");
		
		if(ext_end != -1)
		{
			var extension = list_val.substr(1,ext_end-1);
			$("#user_extension").css({"font-size":"25px"});			
			$("#user_extension").html(extension);
		}
		else
		{
			$("#user_extension").css({"font-size":"12px"});			
			$("#user_extension").html(available_user_name);
		}				
	}
	
		///////end previous code
</script>
	<div id="noscript"><noscript>Your Browser can not support Javascript!</noscript></div>
<!--<div id="overlay" class="callOverlay" style="display:none;" > -->
	<div id="callWrapperInbound" class="callWrapper" style="position:fixed;" >
	<!--<div title="Close" class="closeCWindow"></div>-->
		<div title="Close" class="windowActions">
			<input title="minimize" type="button" id="minimizeOperationInbound" />
			<input title="shade" type="button" id="shadeOperationInbound" />			
			<input type="button" title="Maximize" id="shadeMaxOperationInbound" />
			<input type="button" id="closeOperationInbound" />
		</div>
		<div id="call_content_div" class="callContent">
			<div class="callStatus">
				<h1 id="callType">Inbound Call</h1>
				<h2 id="log" class="green">Loading Connection Device...</h2>
			</div>
			<div class="callDetail">											
				<div id="detail_box" class="actionBox">	
					<img src="custom/include/call_images/fancy_close.png" alt="Close" id="call_contact_div" name="call_contact_div" title="Close" />				
					<a href="#" id="contact_detail" title="See Contact Detail" target="_blank" class="contactDetailLink">Contact Detail</a>
					<a href="#" id="call_detail" title="See Call Detail" target="_blank" class="callDetailLink">Call Detail</a>					
				</div>
				<div class="callDetail">
					<h3 id="contact_name" ></h3>
					<h3 id="contact_number"></h3>		
					
					<h3 id="quick_create_contact_label" for="contact create">Save As Contact :</h3><a href="#" id="quick_create_contact" style="float:right;margin-top:-32px;margin-right: 125px;display:none;" title="Save As Contact" target="_blank"><img src="custom/include/call_images/shortcut_create_contact.png" width=32 height=26 /></a>					
					<h3 id="quick_create_lead_label" for="Lead create">Save As Lead :</h3><a href="#" id="quick_create_lead" style="float:right;margin-top:-32px;margin-right: 125px;display:none;" title="Save As Lead" target="_blank"><img src="custom/include/call_images/shortcut_create_lead.png" width=30 height=30 /></a>					
				</div>				
				<div style="clear:both"></div>
				<div id="call_points_div" name="call_points_div" class="input">
					<label>Add Note:</label>
					<div id="inbound_call_points_save_div" ><span id="inbound_call_points_save_status" class="status_config"></span></div>
					<textarea id="call_points" name="call_points"></textarea>
					<input type="button" id="save_call_points" name="save_call_points" value="Save" />
				</div>
			</div>
			<div id="call_handler_div_inbound" class="callAction">
				<input type="button" title="End Call" id="end_call" class="endCall" />
				<input type="button" title="Accept Call" id="accept_call" class="accept" />
				<input type="button" title="Reject Call" id="reject_call" class="reject" />
				<div id="detail_action" title="Contact/Call Detail" class="moreActions enable"></div>
			</div>
		</div>		
		<div id="user_ext_div" class="callForward" style="visibility:hidden;" >
			<!-- here logged_in available users div will be displayed -->
		</div>			
	</div>
	
<!--</div>-->
