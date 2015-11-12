<style>
{literal}
#main{
	margin-right:20px;	
}
.bordering-row td
{
	border-bottom:1px solid #ABC3D7;
}
{/literal}
</style>
<!-- <script src="custom/include/datepicker/jquery-1.6.2.min.js"></script> -->
<script src="custom/include/datepicker/jquery-ui-1.8.15.custom.min.js"></script>
<link rel="stylesheet" href="custom/include/datepicker/jqueryCalendar.css">
<script type="text/javascript">
{literal}
	$(function() {
		/*
		*	this two lines of codes are for calender datepicker
		*/
		jQuery( "#start_date" ).datepicker();
		jQuery( "#end_date" ).datepicker();
	});	 
	
	$(document).ready(function(){
	
		/*
		*	this will send request to twilio server to verify a provided number and 
		*	display verification code to user to enter this code via phone to get proper verification
		*/		
		$("#verify_number").click(function(){
			
			var verifiable_phone_number = $("#verifiable_phone_number").val();
			
			if(!verifiable_phone_number)
			{
				$("#error_msg_div").html("<span>phone number should not be empty!</span>").show().fadeOut(2000);
			}
			else
			{	
				$("#error_msg_div").html("<span>processing Verification...</span>").show();
				var processed_number = process_number(verifiable_phone_number);
				if(processed_number == false)
				{
					$("#error_msg_div").html("<span>Invalid Phone Number!</span>").show().fadeOut(2000);
				}
				else
				{					
					var verifiable_number = verifiable_phone_number.replace("+","%2B");
					
					/* will send request to twilio for fetching verificaiton code to enter */
					$.ajax({
						url:"index.php",
						type:"POST",
						dataType:"json",
						data:"module=rolus_Twilio_Account&action=phone_verification&sugar_body_only=true&phone_number_to_verify="+verifiable_number,
						async:true,
						cache:false,
						success:function(caller_id_object)
						{
							if(!$.isEmptyObject(caller_id_object.validation_code))
							{
								$('#error_msg_div').html('<span>Enter Code :</span><b><span style="font-size:20px;" >'+caller_id_object.validation_code+'</span></b>');
							}
							else
							{
								$('#error_msg_div').html('<span>Account not authorized to verify this number!</span>').show().fadeOut(2000);	
							}
						},
						error:function(jqXHR,textStatus,errorThrown)
						{
							$('#error_msg_div').html('<span>Phone Number is already verified! or Invalid</span>').show().fadeOut(2000);
						}				
					});
				}
			}
				
		});
                $("#validate_key").click(function(){
			if($("#license_key").val().trim() == "")
			{
				$("#validation_msg").text("Key should not be empty").show().fadeOut(2000);				
			}
			else
			{
				$("#validation_msg").text("Validating License Key...").show();
				var twilio_key = '49ad23bff7c9cb22652196f8c7b7889a';
				var user_key = $("#license_key").val();
				if(user_key!=''){
					$.ajax({
						url:"index.php",
						type:"POST",
						dataType:"json",
						data:"module=rolus_SMS_log&action=outfitterscontroller&method=validate&sugar_body_only=true&key="+user_key,
						async:true,
						cache:false,
						success:function(response)
						{
							console.log(response);
							if(response.validated==true){
								$("#validation_msg").css({color:"DarkGreen"});
								$("#validation_msg").text("Validation: Successful").show().fadeOut(3000);
								$("#validation_msg").css({color:"Red"});
								$("#license_validator").val(true);
							}
							else{
								$("#validation_msg").text("Validation: Un-Successful").show().fadeOut(3000);
								$("#license_validator").val(false);
							}
							
						},
										
					});
				}
				/*
				 $.ajax('https://www.sugaroutfitters.com/api/v1/key/validate', {
					type: 'GET',
					dataType: 'jsonp',
					crossDomain: true,
					data: { format: 'jsonp',public_key: twilio_key,key: user_key},
					timeout: 5000 //work around for jsonp not returning errors
				
				}).success(function(response) 
				{				
					$("#validation_msg").css({color:"DarkGreen"});
					$("#validation_msg").text("Validation: Successful").show().fadeOut(3000);
					$("#validation_msg").css({color:"Red"});
					$("#license_validator").val(true);
				}).error(function() 
				{			
					$("#validation_msg").text("Validation: Un-Successful").show().fadeOut(3000);
					$("#license_validator").val(false);
				});*/
			}
		});

	});

	/*
	*	this will validate the entered user license and allow or restrict the call account settings (via save button validation)
	*/
	function validate_account_settings()
	{			
		var _form = document.getElementById('EditView');
		_form.action.value='Save'; 
		if(check_form('EditView'))
		{
			SUGAR.ajaxUI.submitForm(_form);	//submitting the form
		}
		else
		{					
			return false;
		}				
	}
	
	/*
	*	this will remove the special characters in the phone number n formate it accordingly
	*/
	function process_number(verifiable_phone_number)
	{
		var verifying_number ='';
		phone_original = verifiable_phone_number;
		phone_number = verifiable_phone_number.replace(/[^0-9]/g,'');		
		if(phone_number.substr(0,2) == "00") 
		{
			verifying_number = phone_number.replace("00","+");
			if(verifying_number.length < 8 || is_repeated_digit(verifying_number)) ///check for invalid number
			{				
				verifying_number = false;
			}
		}
		else if(phone_original.substr(0,1) == "+")
		{
			verifying_number = "+"+phone_number;
			if(verifying_number.length < 8 || is_repeated_digit(verifying_number))///check for invalid number(include alphabetical or alphanumerical phone number or single digit repeated phone number)
			{
				verifying_number = false;
			}
		}
		else
		{
			if(phone_number.length < 6 || is_repeated_digit(phone_number))///check for invalid number
			{
				verifying_number = false;
			}
			else
			{
				{/literal}
				{php} 
					require_once('modules/Administration/Administration.php');
					$admin = new Administration();
					$admin->retrieveSettings(); //will retrieve all settings from db
					$twilio_country_code = $admin->settings['MySettings_twilio_country_code'];
				{/php}
				{literal}			
				verifying_number = {/literal}{php} echo $twilio_country_code;{/php}{literal}+phone_number;				
				verifying_number = "+"+verifying_number;
			}
		}			
		return verifying_number;
	}
	
	/*
	*	this will check the source or destination phone number whether it consists on repetition of any single digit or not
	*	returns true upon repetition and false otherwise
	*/
	function is_repeated_digit(phone_number)
	{
		var arr = '';
		arr = phone_number.split(''); //convert string to array
		var freq_of_num = 0;
		var rep_num ='';
		for(var i=0;i<arr.length;i++)
		{
			if(freq_of_num == 0)
			{
				rep_num = arr[i];
				freq_of_num++;
			}
			else if(freq_of_num >0)
			{
				if(arr[i]== rep_num)
				{
					freq_of_num++;
				}
				rep_num = arr[i];
			}
		}
		if(freq_of_num >= 6)
		{
			return true;        
		}
		else
		{
			return false;
		}
	}
		
{/literal}		
</script>

<div class="moduleTitle">
	<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_TITLE' module='rolus_Twilio_Account'}{/capture}{$label|strip_semicolon}:</h2>
<div class="clear"></div>
</div>

<!-- start twilio account settings-->
<form action="index.php" method="POST" name="EditView" id="EditView">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="dcQuickEdit">
<tbody><tr>
<td class="buttons">
<input type="hidden" name="module" value="rolus_Twilio_Account">
<input type="hidden" name="record" value="1">
<input type="hidden" name="action">
<input type="hidden" name="return_module" value="rolus_Twilio_Account">
<input type="hidden" name="return_action" value="index">
<input type="hidden" name="return_id" value="1">
<div class="action_buttons">
<input title="Save" accesskey="a" class="button primary" onclick="validate_account_settings();" type="button" name="button" value="Save" id="save_account_settings" name="save_account_settings" >
<input title="" id="account_cancel_button" onclick="document.location.href='index.php?module=Administration&amp;action=index'" class="button" type="button" name="cancel" value="  Cancel  ">
<div class="clear"></div></div>
</td>
<td align="right">
</td>
</tr>
</tbody></table>


<div id="EditView_tabs">
    <div>
        <div id="detailpanel_1">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Account_Subpanel" class="edit view panelContainer">
                <tbody>
                    <tr>
                        <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_USERNAME' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td>
                        <td valign="top" width="37.5%">
                            <input type="text" name="username" id="username" size="100" maxlength="255" value="{$bean->username}" title="" accesskey="7">
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_PASS' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td>
                        <td valign="top" width="37.5%">
                            <input type="password" name="pass" id="pass" size="100" maxlength="255" value="{if !empty($bean->pass)}**************************{/if}" title="" accesskey="7">
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_PHONE_NUMBER' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}:<span class="required">*</span>
                        </td>
                        <td valign="top" width="37.5%">
                            <input type="text" name="phone_number" id="phone_number" size="100" maxlength="255" value="{$bean->phone_number}" title="" accesskey="7">
                        </td>
                    </tr>
					<tr>
                        <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_APPLICATION_SID' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}:<span class="required">*</span>
                        </td>
                        <td valign="top" width="37.5%">
                            <input type="text" name="appsid" id="appsid" size="100" maxlength="255" value="{$bean->appsid}" title="" accesskey="7">
                        </td>

                    </tr>
                    <tr>
                        <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_LICENSE_KEY' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td>
                        <td valign="top" width="30.5%">
                            <input type="text" name="license_key" id="license_key" size="100" maxlength="255" value="{$bean->license_key}" title="" accesskey="7">
                        </td>
						
						<input type="hidden" id="license_validator" name="license_validator" value="{$bean->license_validator}"/>
						
						<td valign="top" id="name_label" width="8.5%" scope="col">
							<div class="action_buttons" style="width:60px;">
								<input title="Validate License Key" accesskey="v" class="button primary" type="button" name="button" value="Validate" id="validate_key" name="validate_key">
							<div class="clear"></div></div>
						</td>
						<td valign="top" id="name_label" width="16%" scope="col">
							<span id="validation_msg" name="validation_msg" style="color:red;"></span>
						</td>							
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
<!-- end twilio account settings-->
<br />
<!-- start twilio country code settings-->
<div class="moduleTitle">
	<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_EXT_TITLE' module='rolus_Twilio_Account'}{/capture}{$label|strip_semicolon}:</h2>
<div class="clear"></div>	
</div>
<form action="index.php" method="POST" name="EditViewConfig" id="EditViewConfig">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="dcQuickEdit">
	<tbody>
		<tr>		
			<td class="buttons">		
				<input type="hidden" name="module" value="rolus_Twilio_Account" />
				<input type="hidden" name="action" value="" />
				
				<div class="action_buttons">
					<input title="Save" accesskey="s" class="button primary" onclick="var _form_config = document.getElementById('EditViewConfig'); _form_config.action.value='saveCountry'; if(check_form('EditViewConfig'))SUGAR.ajaxUI.submitForm(_form_config);return false;" type="submit" name="button" value="Save" id="SAVE_HEADER">
					<div class="clear">
					</div>
				</div>
			</td>		
			<td align="right">
			</td>
		</tr>		
	</tbody>
</table>
<div class="clear"></div>
<div id="EditViewConfig_tab">
	<div>
		<div id="detail_panel_2">
			
			<table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Country_Code_Subpanel" class="edit view panelContainer">	
				<tbody>
					<tr>
						<td valign="top" id="name_label" width="11.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_TWILIO_COUNTRY_CODE' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td>
                        <td valign="top" width="37.5%">
							<select id="twilio_country_code" name="twilio_country_code">							
								{$twilio_country_code}
							</select>					
                        </td>			
					</tr>
				</tbody>	
			</table>	
		</div>
	</div>
</div>
</form>
<!-- end twilio country code settings-->
<br />
<!-- start twilio phone verification -->
<div class="moduleTitle">
	<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_PHONE_VERIFICATION' module='rolus_Twilio_Account'}{/capture}{$label|strip_semicolon}:</h2>
<div class="clear"></div>	
</div>

<div id="EditViewPhoneVerification_tab">
	<div>
		<div id="detail_panel_3">
			
			<table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Phone_Verification_Subpanel" class="edit view panelContainer">	
				<tbody>
					<tr>							
						<td valign="top" id="name_label" width="11.5%" scope="col">
							{capture name="label" assign="label"}{sugar_translate label='LBL_TWILIO_VERIFIABLE_NUMBER' module='rolus_Twilio_Account'}{/capture}
							{$label|strip_semicolon}: <span class="required">*</span>
						</td>
						<td valign="top" width="10.5%">				
							<input type="text" name="verifiable_phone_number" id="verifiable_phone_number" size="25" maxlength="25" value="" title="" accesskey="p">
						</td>							
						<td valign="top" id="name_label" width="9.5%" scope="col">
							<div class="action_buttons">
								<input title="Verify" accesskey="a" class="button primary" type="button" name="button" value="Verify Number" id="verify_number">
							<div class="clear"></div></div>
						</td>								
						<td valign="top" id="name_label" width="16%" scope="col">
							<div id="error_msg_div" style="color:red;">
								
							<div class="clear"></div></div>
						</td>								
					</tr>
					{if $twilio_outbound_numbers}	
					<tr>
						<th style="text-align:left;"> {capture name="label" assign="label"}{sugar_translate label='LBL_TWILIO_VERIFIED_NUMBER' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_TWILIO_FORMATTED_NUMBER' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_TWILIO_DATE_CREATED' module='rolus_Twilio_Account'}{/capture}
                            {$label|strip_semicolon}</th>
					</tr>
					{foreach from=$twilio_outbound_numbers key=index item=number}
						<tr>
							<td valign="top" id="name_label" width="11.5%" scope="col">                           
								{$number.Phone_Number}
							</td>
							<td valign="top" id="name_label" width="11.5%" scope="col">                           
								{$number.Formatted_Number}
							</td>
							<td valign="top" id="name_label" width="11.5%" scope="col">                           
								{$number.DateCreated}
							</td>
						</tr>
					{/foreach}			
					{/if}	
				</tbody>	
			</table>			
		</div>
	</div>
</div>
<!-- end twilio phone verification -->
<br />
<!-- start twilio usage records -->
<div class="moduleTitle">
	<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_ACCOUNT_USAGE' module='rolus_Twilio_Account'}{/capture}{$label|strip_semicolon}:</h2>
<div class="clear"></div>	
</div>

<div id="EditViewAccountUsage_tab">
	<div>
		<div id="detail_panel_4">
			
			<table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Account_Usage_Subpanel" class="edit view panelContainer">	
				<tbody>						
					<form action="index.php?module=rolus_Twilio_Account" method="POST" id="DetailViewUsage" name="DetailViewUsage">
					
						<input type="hidden" name="module" value="rolus_Twilio_Account" />
						<input type="hidden" name="action" value="" />
						<input type="hidden" name="return_module" value="rolus_Twilio_Account">
						<input type="hidden" name="return_action" value="index">						
						
						<tr class="bordering-row">
							<td valign="top" id="name_label" width="15.5%" scope="col">                           
								{capture name="label" assign="label"}{sugar_translate label='LBL_START_DATE' module='rolus_Twilio_Account'}{/capture}{$label|strip_semicolon}: <span class="required">*</span>
							</td>
							<td valign="top" id="name_label" width="11.5%" scope="col">                           
								<input type="text" id="start_date" name="start_date" value="{$start_date}" />
							</td>
							<td valign="top" id="name_label" width="15.5%" scope="col">                           								
								{capture name="label" assign="label"}{sugar_translate label='LBL_END_DATE' module='rolus_Twilio_Account'}{/capture}{$label|strip_semicolon}: <span class="required">*</span>
							</td>
							<td valign="top" id="name_label" width="11.5%" scope="col">                           
								<input type="text" id="end_date" name="end_date" value="{$end_date}" />
							</td>
							<td valign="top" id="name_label" width="11.5%" scope="col">
								<div class="action_buttons">
									<input title="Retrieve Usage Record" accesskey="a" class="button primary" onclick="var _form_DetailViewUsage = document.getElementById('DetailViewUsage'); _form_DetailViewUsage.action.value='index'; if(check_form('DetailViewUsage'))SUGAR.ajaxUI.submitForm(_form_DetailViewUsage);return false;" type="submit" name="button" value="Retrieve Record" id="SAVE_HEADER">
								<div class="clear"></div></div>
							</td>	
						</tr>
					</form>
						<tr>
							<th style="text-align:left;"> {capture name="label" assign="label"}{sugar_translate label='LBL_TWILIO_CATEGORY' module='rolus_Twilio_Account'}{/capture}
								{$label|strip_semicolon}</th>
							<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_CATEGORY_USAGE' module='rolus_Twilio_Account'}{/capture}
								{$label|strip_semicolon}</th>
							<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_CATEGORY_AMOUNT' module='rolus_Twilio_Account'}{/capture}
								{$label|strip_semicolon}</th>
						</tr>
						{foreach from=$usage_records key=index item=resource}
							
						<tr>
							<td valign="top" id="name_label" width="11.5%" scope="col"> 
							{if $resource.category eq 'recordings'}  
								Recordings
							{/if}
							{if $resource.category eq 'sms'}  
								SMS
							{/if}
							{if $resource.category eq 'calls'}  
								Calls
							{/if}
							{if $resource.category eq 'phonenumbers'}  
								Phone Numbers
							{/if}
							{if $resource.category eq 'totalprice'}  
								Total Price
							{/if}                        								
								
							</td>
							<td valign="top" id="name_label" width="11.5%" scope="col">                           
								{$resource.usage}
							</td>
							<td valign="top" id="name_label" width="11.5%" scope="col">                           								
								{$resource.price}
							</td> 
						</tr>
						{/foreach}
				</tbody>	
			</table>			
		</div>
	</div>
</div>
<!-- end twilio usage records -->

<script type="text/javascript" language="javascript">
{literal}
addToValidate('EditView','username','varchar',true,'Account Sid' );
addToValidate('EditView', 'pass', 'varchar', true,'Auth Token' );
addToValidate('EditView', 'phone_number', 'varchar', true,'Source Phone Number' );
addToValidate('EditView', 'appsid', 'varchar', true,'Application Sid' );
addToValidate('EditView', 'license_key', 'varchar', true,'License Key' );

/*
addToValidate('EditView','username','varchar',true,'{capture name="label" assign="label"}{sugar_translate label=LBL_USERNAME module=rolus_Twilio_Account}{/capture}{/capture}{$label|strip_semicolon}' );
addToValidate('EditView', 'pass', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_PASS module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );
addToValidate('EditView', 'phone_number', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_PHONE_NUMBER module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );
addToValidate('EditView', 'appsid', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_LINCENSE_KEY module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );
addToValidate('EditView', 'license_key', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_LICENSE_KEY module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );
*/
//addToValidate('EditViewConfig', 'twilio_country_code', 'enum', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_TWILIO_COUNTRY_CODE module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );
addToValidate('EditViewConfig', 'twilio_country_code', 'enum', true,'Default Country Code' );
addToValidate('VerifyNumber', 'verifiable_phone_number', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_TWILIO_VERIFIABLE_NUMBER module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );
/*addToValidate('DetailViewUsage', 'start_date', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_START_DATE module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );
addToValidate('DetailViewUsage', 'end_date', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label=LBL_END_DATE module=rolus_Twilio_Account}{/capture}{$label|strip_semicolon}' );*/
addToValidate('DetailViewUsage', 'start_date', 'varchar', true,'Start Date' );
addToValidate('DetailViewUsage', 'end_date', 'varchar', true,'End Date' );
{/literal}
</script>

