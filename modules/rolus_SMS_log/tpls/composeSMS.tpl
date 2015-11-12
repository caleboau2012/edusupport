{php}	
	
	/*
	*	here licensing is being implemented to ensure that user has a validated license key to use this product
	*/
	
	$moduleName = "rolus_Twilio_Account";
	$account_bean = BeanFactory::getBean($moduleName);
	$account_bean->retrieve('1');	
	
	//if($account_bean->license_validator == true AND !empty($account_bean->license_key))
	if(isset($account_bean->license_validator))
	{
	
		
		$twilio_key = '49ad23bff7c9cb22652196f8c7b7889a';
		$user_key = $account_bean->license_key; // user input in settings
		$user_key = str_replace(' ', '', $user_key);
		$_REQUEST['key']=$user_key;
		require_once('modules/rolus_SMS_log/license/OutfittersLicense.php');
        $result = OutfittersLicense::validate(1);
    	if($result!='"Key does not exist."')	
		{	
		{/php}
		{literal}
			<script type="text/javascript">					
				//$(".error_msgg").text("Validation: Successful").show().fadeOut(5000);					
				$(".call_maker").css({display:"block"});
			</script>				
		{/literal}	
		{php}
	// licensing if case ...
		if($GLOBALS['current_user']->voip_access == 'outbound' OR $GLOBALS['current_user']->voip_access == 'both')	
		{	
		/*$target_module = 'rolus_Twilio_Account';
		$class = $GLOBALS['beanList'][$target_module];
		require_once($GLOBALS['beanFiles'][$class]);
		$rolus_Twilio_Account = new $class();*/
		
		require_once("modules/rolus_Twilio_Account/rolus_Twilio_Account.php");
		$rolus_Twilio_Account = new rolus_Twilio_Account();
		
			
		try{
			$capability = $rolus_Twilio_Account->getCapability();
			$appsid = $rolus_Twilio_Account->getApplicationSid();	
			if(!(is_object($capability) && $capability instanceof Services_Twilio_Capability))
					throw new settingsException('Cannot connect to Twilio','3');
					
			$capability->allowClientOutgoing($appsid);
			$capability->allowClientIncoming($GLOBALS['current_user']->user_name);
			$token = $capability->generateToken();			
			
		} catch (communicaitonException $e) {		
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
		} catch (settingsException $e) {		
			$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
		} catch (Exception $e) {		
			$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
		}
{/php}

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />	
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->

<style>
	{literal}
	  .ui-autocomplete-loading 
	  {
		   /*background: white url('custom/include/call_images/ui-anim_basic_16x16.gif') right center no-repeat;*/
	  }
	  #message
	  { 
		max-width:1175px;
		max-height:270px; 		
	  }  
	  .SMScomposebutton
	  {
		background: #6db3f2;
		background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzZkYjNmMiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUwJSIgc3RvcC1jb2xvcj0iIzU0YTNlZSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUwJSIgc3RvcC1jb2xvcj0iIzM2OTBmMCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMxZTY5ZGUiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
		background: -moz-linear-gradient(top,  #6db3f2 0%, #54a3ee 50%, #3690f0 50%, #1e69de 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6db3f2), color-stop(50%,#54a3ee), color-stop(50%,#3690f0), color-stop(100%,#1e69de));
		background: -webkit-linear-gradient(top,  #6db3f2 0%,#54a3ee 50%,#3690f0 50%,#1e69de 100%);
		background: -o-linear-gradient(top,  #6db3f2 0%,#54a3ee 50%,#3690f0 50%,#1e69de 100%);
		background: -ms-linear-gradient(top,  #6db3f2 0%,#54a3ee 50%,#3690f0 50%,#1e69de 100%);
		background: linear-gradient(to bottom,  #6db3f2 0%,#54a3ee 50%,#3690f0 50%,#1e69de 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6db3f2', endColorstr='#1e69de',GradientType=0 );
		border:1px solid #1e69de;
		width:200px;
		/*height:90px;*/
		height:50px;
		border-radius:3px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		-o-border-radius:3px;
		-ms-border-radius:3px;
		padding:0;
		margin:0;
		font:normal 20px Arial, Helvetica, sans-serif;
		color:#fff;
		text-shadow:1px 1px 0px #06F;
	}
	  
	{/literal}	
</style>

<script type="text/javascript">
{literal}
	/*
	*	this will create the sugar calender field in the custom tpl file and handle the related functionality 
	*/
    Calendar.setup ({
		inputField : "date_sent",
		ifFormat : "%m/%d/%Y %I:%M%P",
		daFormat : "%m/%d/%Y %I:%M%P",
		button : "date_sent_trigger",
		singleClick : true,
		dateStr : "",
		startWeekday: 0,
		step : 1,
		weekNumbers:false
	});
	
function sendSMSToMany()
{		
	//var no_error = false;
	/*if(check_sms_length("false") == true)
	{*/
		var _form = document.getElementById('EditView');
		if(document.getElementById('message').value!='' && document.getElementById('too').value!=''){
                    document.getElementById('EditView').style.display = "none";
                }
                
		document.getElementById('message').value=window.btoa(document.getElementById('message').value);
		_form.action.value='saveMultipleSms'; 
		if(check_form('EditView'))
		{						
			SUGAR.ajaxUI.submitForm(_form);	//submitting the form		
   			//no_error = true;
			return true;
		}
		else
		{
		    return false;	
		}		
	/*}
	else
	{
		return false;
		$("#sms_error").text("SMS with no characters cannot be sent!").show().fadeOut(3000);		
	}*/			
	//return no_error;
}

/*
*	this will handle the visibility of date picker upon checkbox click for SMS scheduling
*/
function SchduleSMS(checkboxElem)
{	
	if(checkboxElem.checked == true)
	{
		document.getElementById("dateTime").style.visibility = 'visible'; 
		document.getElementById("date_sent_time_section").style.visibility = 'visible';
		document.getElementById("date_sent_trigger").style.visibility = 'visible';
		//document.getElementById("date_sent_label").style.visibility = 'visible';
		document.getElementById("time_hinter").style.visibility = 'visible';			
		document.getElementById("schedule_sms_label").style.display = 'none';	
		addToValidate('EditView', 'date_sent', 'id', 'true', 'Date.');		
		addToValidate('EditView', 'date_sent_hours', 'id', 'true', 'Hour.');		
		addToValidate('EditView', 'date_sent_minutes', 'id', 'true', 'Minutes.');		
		addToValidate('EditView', 'date_sent_meridiem', 'id', 'true', 'Seconds.');		
	}	
	else
	{
		document.getElementById("dateTime").style.visibility = 'hidden'; 
		document.getElementById("date_sent_time_section").style.visibility = 'hidden';
		document.getElementById("date_sent_trigger").style.visibility = 'hidden';
		//document.getElementById("date_sent_label").style.visibility = 'hidden';	
		document.getElementById("time_hinter").style.visibility = 'hidden';			
		document.getElementById("schedule_sms_label").style.display = 'block';	
		document.getElementById("schedule_sms_label").style.marginTop = '-33px';
		document.getElementById("schedule_sms_label").style.marginLeft = '128px';
		removeFromValidate('EditView', 'date_sent');
		removeFromValidate('EditView', 'date_sent_hours');
		removeFromValidate('EditView', 'date_sent_minutes');
		removeFromValidate('EditView', 'date_sent_meridiem');
		document.getElementById('date_sent_hours').value="";
		document.getElementById('date_sent_minutes').value="";
		document.getElementById('date_sent_meridiem').value="";
		document.getElementById('date_sent').value="";
	}
}

/*
*	this will check the length of the sms that is to be sent 
*	returns true with <= 160 characters
*   returns false with > 160 characters
*/
function check_sms_length(sms_count_flag)
{
	var sms_val = document.getElementById("message").value;
	var sms_len = sms_val.length;
	
	if(sms_count_flag == "true")
	{
		return sms_len;
	}
	else
	{
		//if(sms_len <= 160 && sms_len != 0)
		if(sms_len != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	
}

	var documentReadycheck = false; // will be true if document.ready exectues first time

/* jquery on ready method */
$(document).ready(function(){
	documentReadycheck= true;
    // x functionality when window loads
	//$("select, textarea").uniform();	
	//$("input").uniform({inputClass: "button"});

	var max_sms_len = unit_sms_length = 160; // this will the max characters length of the Compose sms text area	
	var sms_count = 1;

	/*
	*	this will handle the sms counting characters and adjust the increment and decrement of the sms counter
	*	upon key press by calculating the count of characters every time
	*/
	$("#message").keyup(function(event){		
		if (event.which < 0x20) {
            // event.which < 0x20, then it's not a printable character
            // event.which === 0 - Not a character			
            // BACKSPACE key
			var curr_sms_count = check_sms_length("true");
			if(curr_sms_count==0){
				curr_sms_count=160;
			}								
			$("#sms_char_counter").html(curr_sms_count);						
			
			var sms_count_num = Math.ceil(this.value.length/unit_sms_length);
			sms_count = sms_count_num;
			$("#sms_counter").html(sms_count);
			
            return;
        }		
        if (this.value.length == max_sms_len) 
		{			
            event.preventDefault();
        }
		/*else if (this.value.length > max_sms_len)     // Maximum exceeded
		{     
			max_sms_len += max_sms_len;
        }*/		
		/* counting the no the sms messages */
		var sms_count_num = Math.ceil(this.value.length/unit_sms_length);
		sms_count = sms_count_num;			
		/* counting the number of characters in a message */
		var valid_curr_sms_count = check_sms_length("true");											
		$("#sms_char_counter").html(valid_curr_sms_count);	
		$("#sms_counter").html(sms_count);	
		
	}); //end keypress event handler

}); // end document.ready event handler

 if (documentReadycheck == false)
 {	
	var max_sms_len = unit_sms_length = 160; // this will the max characters length of the Compose sms text area	
	var sms_count = 1;

	/*
	*	this will handle the sms counting characters and adjust the increment and decrement of the sms counter
	*	upon key press by calculating the count of characters every time
	*/
	$("#message").keyup(function(event){		
		if (event.which < 0x20) {
            // event.which < 0x20, then it's not a printable character
            // event.which === 0 - Not a character			
            // BACKSPACE key
			var curr_sms_count = check_sms_length("true");
			if(curr_sms_count==0){
				curr_sms_count=160;
			}								
			$("#sms_char_counter").html(curr_sms_count);						
			
			var sms_count_num = Math.ceil(this.value.length/unit_sms_length);
			sms_count = sms_count_num;
			$("#sms_counter").html(sms_count);
			
            return;
        }		
        if (this.value.length == max_sms_len) 
		{			
            event.preventDefault();
        }
		/*else if (this.value.length > max_sms_len)     // Maximum exceeded
		{     
			max_sms_len += max_sms_len;
        }*/		
		/* counting the no the sms messages */
		var sms_count_num = Math.ceil(this.value.length/unit_sms_length);
		sms_count = sms_count_num;			
		/* counting the number of characters in a message */
		var valid_curr_sms_count = check_sms_length("true");											
		$("#sms_char_counter").html(valid_curr_sms_count);	
		$("#sms_counter").html(sms_count);	
		
	}); //end keypress event handler
}
/*
*	this will send the continuous Ajax Calls to data base to fetch all related contacts 
*	to whom user wants to send sms
*/	
$(function() {
	var zero_index = false;
    function split( val ) {		
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {		
        return split( term ).pop();
    }
 
   // don't navigate away from the field on tab when selecting an item
    $( "#too" ).bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).data( "ui-autocomplete" ).menu.active ) {
          event.preventDefault();
        }
      }).autocomplete({
			source: function( request, response ) 
			{					
			    var last_index = request.term.lastIndexOf(";"); //getting the index of last semi-colon sign
				if(last_index != -1)
				{
					request.term = request.term.slice(last_index+1); // getting the string value after last semi-colon to be considered the next value to search in database tables
				}
			
				$.getJSON( "index.php?module=rolus_SMS_log&action=search_sms_recipients&sugar_body_only=true", {
					term: extractLast( request.term )
				}, response );
			},
			search: function() {
			  // custom minLength
			  var term = extractLast( this.value );			 
			  
			  var last_index_search = term.lastIndexOf(";"); //getting the index of last semi-colon sign
			  if(last_index_search != -1)
			  {
				term_with_zero = term.slice(last_index_search+1); // getting the string value after last semi-colon to be considered the next value to search in database tables
			  }
			  else
			  {
				term_with_zero = term.slice(0,1);
				zero_index = true;				 
			  }
			  
			  if ( term.length < 2) 
			  {											
				return false;
			  }	
			  /* if user has entered 0 at start or after any phone number entered manually or got from database */
			  //if(term_with_zero.length <2 && (term_with_zero == "+" || term_with_zero == "0"))
			  if(term_with_zero.length <2 && term_with_zero == "0")
			  {
				 
				 this.value = (zero_index)? term.replace('0','+') : term.replace(term.slice(last_index_search+1),'+');
				 term = this.value;					
								
				 if(term_with_zero == "0")					
					$("phone_error_tr").css({display:"block"});
		
					$("#phone_error").text("phone number should be in E.164 Format! e.g(+CountryCode AreaCode PhoneNumber)(+1310XXXXXXX)");		
				  				  				 
				 return false;				  
			  }			  			 		  
			},
			focus: function() {
			  // prevent value inserted on focus
			  return false;
			},
			select: function( event, ui ) {			
		      var terms = this.value.split(";");				 
			  // remove the last value from terms ui 	 
		      terms.pop();
					 
		      // add the selected item
		      terms.push( ui.item.value );
		      // add placeholder to get the comma-and-space at the end
		      terms.push("");
		
     		  this.value = terms.join( ";" ); 
			  			
			  return false;
			}
      });
});	
	
{/literal}
</script> 
 
 <div class="moduleTitle">
	<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_COMPOSESMS' module='rolus_SMS_log'}{/capture}{$label|strip_semicolon}:</h2>
<div class="clear"></div>
</div>

<!-- start Compose SMS -->
<form action="index.php" method="POST" name="EditView" id="EditView">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="dcQuickEdit">
<tbody><tr>
<td class="buttons">
	<input type="hidden" name="module" value="rolus_SMS_log">
	<input type="hidden" name="action" >
	<input type="hidden" name="return_module" value="rolus_SMS_log">
	<input type="hidden" name="return_action" value="index">	

</td>
<td align="right">
</td>
</tr>
</tbody>
</table>


<div id="EditView_tabs">
    <div>
        <div id="detailpanel_1">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_SMS_log_Subpanel" class="edit view panelContainer">
                <tbody>
                    <tr>
                        <!-- <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_TO' module='rolus_SMS_log'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td> -->
                        <td valign="top" width="100%">                            
							<textarea id="too" name="too" placeholder="Type Recipient(s) to send SMS" style="font-size:15pt;" cols=96 rows=2 ></textarea>
                        </td>
						<!-- <td valign="top" width="40.5%" scope="col">
                            <span id="phone_error" style="color:red;"></span>
                        </td> -->
                        <!-- <td valign="top" width="12.5%">
                            
                        </td> -->
                    </tr>
                    <tr id="phone_error_tr" style="display:none;">
                    	<!--<td valign="top" width="40.5%" scope="col">-->
                            <span id="phone_error" style="color:red;"></span>
                        <!--</td>-->
                    </tr>	
                    <tr>
                        <!-- <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_MESSAGE' module='rolus_SMS_log'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td> -->
                        <td valign="top" width="100%">                            
							<textarea id="message" name="message" placeholder="Type to Compose SMS" cols=96 rows=10 style="font-size:25pt;" ></textarea>							
                        </td>
						<!--  <td valign="top" width="40.5%" scope="col">
                            
                        </td>
                       <td valign="top" width="12.5%">
                            
                        </td> -->
                    </tr>
                    <tr>
                       <!--  <td valign="top" id="name_label" width="12.5%" scope="col">
                            
                        </td> -->
                        <!-- <td valign="top" width="100%">                            
							<span id="sms_counter" style="color:red;font-size:35px;">160</span>
                        </td> -->
						<!-- <td valign="top" width="40.5%" scope="col">
                            <span id="sms_error" style="color:red;"></span>
                        </td> -->
                        <!-- <td valign="top" width="12.5%">
                            
                        </td> -->
                    </tr>
					<tr>
                        <!-- <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_SCHEDULECONFIG' module='rolus_SMS_log'}{/capture}
                            {$label|strip_semicolon}:
                        </td> -->
                        <td valign="top" width="100%">	

							<span id="sms_char_counter" style="color:red;font-size:35px;">160</span>
							<span id="slash_sms" style="color:red;font-size:35px;">/</span>
							<span id="sms_counter" style="color:red;font-size:35px;">1</span>
							&nbsp;&nbsp;
							<input type="checkbox" id="schedule_sms" onclick="SchduleSMS(this);" />
						
							&nbsp;&nbsp;
							<label id="schedule_sms_label" style="font-size:29px;hight:30px;width:200px;position:absolute;margin:10px 0px 0px 0px;">Schedule SMS</label>
							<span class="dateTime" id="dateTime" style="visibility:hidden;" >								
								<input type="text" maxlength="10" size="11" id="date_sent" name="date_sent" autocomplete="off" class="date_input"> &nbsp;
								<img border="0" id="date_sent_trigger" style="position:relative; top:6px" alt="Enter Date" src="themes/Suite7/images/Calendar.gif">
							</span>&nbsp;
							
							<!--<div id="date_sent_time_section">-->
								<span id="date_sent_time_section" style="position:relative;visibility:hidden; top:0px;">
								  <select class="datetimecombo_time" size="1" id="date_sent_hours" name="date_sent_hours" tabindex="0" >
									  <option ></option>
									  <option value="01">01</option>
									  <option value="02">02</option>
									  <option value="03">03</option>
									  <option value="04">04</option>
									  <option value="05">05</option>
									  <option value="06">06</option>
									  <option value="07">07</option>
									  <option value="08">08</option>
									  <option value="09">09</option>
									  <option value="10">10</option>
									  <option value="11">11</option>
									  <option value="12">12</option>
								  </select>&nbsp;:
									&nbsp;<select class="datetimecombo_time" size="1" id="date_sent_minutes" name="date_sent_minutes" tabindex="0" >
									<option></option>
									<option value="00">00</option>
									<option value="15">15</option>
									<option value="30">30</option>
									<option value="45">45</option>
									</select>
									&nbsp;
									<select class="datetimecombo_time" size="1" id="date_sent_meridiem" name="date_sent_meridiem" tabindex="0" >
									<option></option>
									<option value="am">am</option>
									<option value="pm">pm</option>
									</select>
								</span>
                                <span id="time_hinter" style="color:red;font-style:italic;visibility:hidden;">(11:00 pm)</span>
							<!--</div>-->
							
							<!--<div class="action_buttons">-->
								<!--<input title="Save" accesskey="a" class="button primary" type="submit" onclick="return sendSMSToMany();" type="button" value="Send" id="send_sms" style="float:right;" >-->
								<input title="Save" accesskey="a" class="SMScomposebutton" onclick="return sendSMSToMany();" type="button" value="Send" id="send_sms" style="float:right;margin-right:20px;" >								
							<!--</div>-->
                        </td>
						<!-- <td valign="top" width="40.5%" scope="col">
                            
                        </td> -->
                       <!--  <td valign="top" width="12.5%">
                            
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
	
<script type="text/javascript">
{literal}
addToValidate('EditView','too','text',true,'{capture name="label" assign="label"}{sugar_translate label=LBL_TO module=rolus_SMS_log}{/capture}{/capture}{$label|strip_semicolon}' );
addToValidate('EditView', 'message', 'text', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_MESSAGE module=rolus_SMS_log}{/capture}{$label|strip_semicolon}' );
{/literal}
</script>
 {php}
		 }//for user management		
	 	   else
		   {
			{/php}
			{literal}				
				<script type="text/javascript">	
					$(".call_maker").css({display:"none"});
				</script>
			{/literal}
			{php}
		    }
		}
		else
		{
			{/php}
			{literal}				
				<script type="text/javascript">	
                                        alert('RT Telephony LICENSE EXPIRED');				
					$(".error_msgg").text("License is required").show().fadeOut(5000);					
					$(".call_maker").css({display:"none"});
				        $("#phone_fax").css({display:"none"});
				</script>
			{/literal}
			{php}
		}
	}	
{/php}

