<style>
{literal}
#main{
	margin-right:20px;	
}
{/literal}
</style>

<div class="moduleTitle" >
	<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_TITLE' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
<div class="clear"></div>
</div>
<form action="index.php" method="POST" name="EditView" id="EditView">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="dcQuickEdit">
<tbody><tr>
<td class="buttons">
<input type="hidden" name="module" value="rolus_Twilio_Extension_Manager">
<input type="hidden" name="record" value="1">
<input type="hidden" name="action">
<input type="hidden" name="return_module" value="rolus_Twilio_Extension_Manager">
<input type="hidden" name="return_action" value="index">
<input type="hidden" name="return_id" value="1">
<div class="action_buttons">
	<input title="Save" accesskey="a" class="button primary" onclick="var _form = document.getElementById('EditView'); _form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="Save" id="SAVE_HEADER">
	<input title="" id="ivr_cancel_button" onclick="document.location.href='index.php?module=Administration&amp;action=index'" class="button" type="button" name="cancel" value="  Cancel  ">
	<div class="clear"></div>
</div>
</td>
<td align="right">
</td>
</tr>
</tbody></table>


<div id="EditView_tabs">
    <div>
		<!-- Start GLOBAL Settings  -->		
		<div id="detailpanel_1">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Extension_Manager_Subpanel" class="edit view panelContainer">
                <tbody>
					<tr>
						<td>
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_GLOBAL_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>	
					</tr>
					<tr>
						<td valign="top" id="name_label" width="12.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_WELCOME_MESSAGE' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td>
                        <td valign="top" width="12.5%">
                            <input type="text" name="welcome_message" id="welcome_message" size="40" maxlength="300" value="{$bean->welcome_message}" title="" accesskey="7">
                        </td>
						<td valign="top" id="name_label" width="12.5%" scope="col">
							{capture name="label" assign="label"}{sugar_translate label='LBL_RECORDING_CONFIG' module='rolus_Twilio_Extension_Manager'}{/capture}
							{$label|strip_semicolon}:
						</td>
						<td valign="top" width="20%">
							<input type="hidden" name="recording_config" id="recording_config" value="{$bean->recording_config}" >
							<input type="checkbox" id="recording_config_chk" onclick="handle_recording_disable()" />
						</td>
					</tr>					
					<tr>	
						<td valign="top" id="name_label" width="12.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_IVR_VOICE' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="20%">
							<select id="ivr_voice" name="ivr_voice">							
								{$ivr_voice}
							</select>
						</td>	
						
						<td valign="top" id="name_label" width="12.5%" scope="col">
							{capture name="label" assign="label"}{sugar_translate label='LBL_RECORDING_MSG_CONFIG' module='rolus_Twilio_Extension_Manager'}{/capture}
							{$label|strip_semicolon}:
						</td>
						<td valign="top" width="20%">
							<input type="hidden" name="recording_msg_config" id="recording_msg_config" value="{$bean->recording_msg_config}" >
							<input type="checkbox" id="recording_msg_config_chk" onclick="handle_recording_msg_disable()" />
						</td>
					</tr>	
					<tr>
						<td valign="top" id="name_label" width="12.5%" scope="col">
							{capture name="label" assign="label"}{sugar_translate label='LBL_OPERATOR_NAME' module='rolus_Twilio_Extension_Manager'}{/capture}
							{$label|strip_semicolon}:
						</td>
						<td valign="top" width="20%">
							<select id="operator_name" name="operator_name">							
								{$operator_name}
							</select>
						</td>
						                        
                    </tr>          										                  	
                </tbody>
            </table>
        </div>
		<!-- End GLOBAL Settings  -->
		<br />
		<!-- Start Extensions Settings  -->
        <div id="detailpanel_2">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Extension_Manager_Subpanel" class="edit view panelContainer">
                <tbody>
					<tr>
						<td valign="top" id="name_label" width="12.5%" scope="col">
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_EXTENSIONS_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>	
						<td valign="top" width="12.5%">
						</td>
						
						<td valign="top" id="name_label" width="12.5%" scope="col">
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_DIRECTORY_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>	
						<td valign="top" width="12.5%">
						</td>
						
					</tr>
					<tr>
						<td valign="top" id="name_label" width="12.5%" scope="col">
							{capture name="label" assign="label"}{sugar_translate label='LBL_IVRCONFIG' module='rolus_Twilio_Extension_Manager'}{/capture}
							{$label|strip_semicolon}:
						</td>
						<td valign="top" width="12.5%">
							<input type="hidden" name="ivr_config" id="ivr_config" value="{$bean->ivr_config}" >
							<input type="checkbox" id="ivr_config_chk" onclick="handle_ivrdisable()" />
						</td>
						<td valign="top" id="name_label" width="12.5%" scope="col">
							{capture name="label" assign="label"}{sugar_translate label='LBL_DIRECTORY_CONFIG' module='rolus_Twilio_Extension_Manager'}{/capture}
							{$label|strip_semicolon}:
						</td>
						<td valign="top" width="12.5%">
							<input type="hidden" name="directory_config" id="directory_config" value="{$bean->directory_config}" >
							<input type="checkbox" id="directory_config_chk" onclick="handle_directory_disable()" />
						</td>
					</tr>
					<tr>	
						 <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_EXTENSION_DIGITS' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td>
                        <td valign="top" width="20%">
                            <input type="text" name="extension_digits" id="extension_digits" size="10" maxlength="7" value="{$bean->extension_digits}" title="" accesskey="7">
                        </td>	
						 <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_OPERATOR_DIAL_SYMBOL' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}: <span class="required">*</span>
                        </td>
                        <td valign="top" width="20%">
                            <input type="text" name="operator_dial_symbol" id="operator_dial_symbol" size="10" maxlength="1" value="{$bean->operator_dial_symbol}" title="" accesskey="7">
                        </td>						
					</tr>					
					<tr>		
                        <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_INSTRUCTIONS_LOOP' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
                        <td valign="top" width="20%">
                            <input type="text" name="instructions_loop" id="instructions_loop" size="10" maxlength="7" value="{$bean->instructions_loop}" title="" accesskey="7">
                        </td>						
						<td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_PAUSE_BW_INSTRUCTIONS' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
                        <td valign="top" width="20%">
                            <input type="text" name="pause_bw_instructions" id="pause_bw_instructions" size="10" maxlength="2" value="{$bean->pause_bw_instructions}" title="" accesskey="7">
                        </td>	
					</tr>	
					<tr>	
                        <td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_EXT_MENU_GATHER_DELAY' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
                        <td valign="top" width="20%">
                            <input type="text" name="ext_menu_gather_delay" id="ext_menu_gather_delay" size="10" maxlength="7" value="{$bean->ext_menu_gather_delay}" title="" accesskey="7">
                        </td>					
						<td valign="top" id="name_label" width="12.5%" scope="col">
                            {capture name="label" assign="label"}{sugar_translate label='LBL_MAIN_MENU_GATHER_DELAY' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
                        <td valign="top" width="20%">
                            <input type="text" name="main_menu_gather_delay" id="main_menu_gather_delay" size="10" maxlength="2" value="{$bean->main_menu_gather_delay}" title="" accesskey="7">
                        </td>	
					</tr>						        										                  
                </tbody>
            </table>
        </div>
		<!-- End Extensions Settings  -->
		<br />
		<!-- Start Call Waiting Settings  -->
		<div id="detailpanel_3">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Extension_Manager_Subpanel" class="edit view panelContainer">
                <tbody>
					<tr>
						<td>
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_CALL_WAITING_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>							
					</tr>			
					<tr>	
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_CALL_WAITING' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="20%">
							<input type="hidden" name="call_waiting_config" id="call_waiting_config" value="{$bean->call_waiting_config}" >
							<input type="checkbox" id="call_waiting_config_chk" onclick="handle_call_waiting_disable()" />
						</td>
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           
                        </td>
						<td valign="top" width="12.5%">
							
						</td>		
                    </tr>          										                  	
                </tbody>
            </table>
        </div>
		<!-- End Call Waiting Settings  -->
		<br />
		<!-- Start Call Forwarding Settings  -->
		<div id="detailpanel_3">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Extension_Manager_Subpanel" class="edit view panelContainer">
                <tbody>
					<tr>						
						<td>
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_CALL_FORWARDING_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>	
					</tr>			
					<tr>							
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_CALL_FORWARDING' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="20%">
							<input type="hidden" name="call_forwarding_config" id="call_forwarding_config" value="{$bean->call_forwarding_config}" >
							<input type="checkbox" id="call_forwarding_config_chk" onclick="handle_call_forwarding_disable()" />
						</td>	
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           
                        </td>
						<td valign="top" width="12.5%">
							
						</td>		
                    </tr>          										                  	
                </tbody>
            </table>
        </div>
		<!-- End Call Forwarding Settings  -->
		<br />
		<!-- Start Simultaneous Dialing Settings  -->
		<div id="detailpanel_4">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Extension_Manager_Subpanel" class="edit view panelContainer">
                <tbody>
					<tr>						
						<td>
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_SIMULTANEOUS_DIALING_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>	
					</tr>			
					<tr>							
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_SIMULTANEOUS_DIALING' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="20%">
							<input type="hidden" name="simultaneous_dialing_config" id="simultaneous_dialing_config" value="{$bean->simultaneous_dialing_config}" >
							<input type="checkbox" id="simultaneous_dialing_config_chk" onclick="handle_simultaneous_dialing_disable()" />
						</td>	
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           
                        </td>
						<td valign="top" width="12.5%">
							
						</td>		
                    </tr>          										                  	
                </tbody>
            </table>
        </div>
		<!-- End Simultaneous Dialing Settings  -->
		<br />
		<!-- Start Voice Mail Transcription Settings  -->
		<div id="detailpanel_5">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Extension_Manager_Subpanel" class="edit view panelContainer">
                <tbody>
					<tr>						
						<td>
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_VOICE_MAIL_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>	
					</tr>			
					<tr>							
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_VOICE_MAIL_OUTBOUND_CALL' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="12.5%">
							<input type="hidden" name="voice_mail_outbound_call_config" id="voice_mail_outbound_call_config" value="{$bean->voice_mail_outbound_call_config}" >
							<input type="checkbox" id="voice_mail_outbound_call_config_chk" onclick="handle_voice_mail_outbound_call_disable()" />
						</td>	
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_VOICE_MAIL_INBOUND_CALL' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="12.5%">
							<input type="hidden" name="voice_mail_inbound_call_config" id="voice_mail_inbound_call_config" value="{$bean->voice_mail_inbound_call_config}" >
							<input type="checkbox" id="voice_mail_inbound_call_config_chk" onclick="handle_voice_mail_inbound_call_disable()" />
						</td>		
                    </tr>  
					<tr>							
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_BEEP_SOUND_CONFIG' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="12.5%">
							<input type="hidden" name="beep_sound_config" id="beep_sound_config" value="{$bean->beep_sound_config}" >
							<input type="checkbox" id="beep_sound_config_chk" onclick="handle_beep_sound_config_disable()" />
						</td>	
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_SILENCE_TIME_OUT' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="12.5%">
							<input type="text" name="silence_time_out" id="silence_time_out" size="10" maxlength="7" value="{$bean->silence_time_out}" title="" accesskey="7">
						</td>		
                    </tr>       		
					<tr>							
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_FINISH_ON_KEY' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="12.5%">
							<input type="text" name="finish_on_key" id="finish_on_key" size="10" maxlength="7" value="{$bean->finish_on_key}" title="" accesskey="7">
						</td>
						<td valign="top" id="name_label" width="10.5%" scope="col">
                           {capture name="label" assign="label"}{sugar_translate label='LBL_RECORDING_DURATION' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}:
                        </td>
						<td valign="top" width="12.5%">
							<input type="text" name="recording_duration" id="recording_duration" size="10" maxlength="7" value="{$bean->recording_duration}" title="" accesskey="7">
						</td>	
					</tr>
					
                </tbody>
            </table>
        </div>
		<!-- End Voice Mail Transcription Settings  -->
		<!-- Start Voice Mail Transcription Settings  -->
		<div id="detailpanel_5" style="overflow-y:auto;height:200px;">
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Default_rolus_Twilio_Extension_Manager_Subpanel" class="edit view panelContainer">
                <tbody>
					<tr>						
						<td>
							<div class="moduleTitle" style="height:1em;">
								<h2>{capture name="label" assign="label"}{sugar_translate label='LBL_MODULE_SYSTEM_USERS_SETTINGS' module='rolus_Twilio_Extension_Manager'}{/capture}{$label|strip_semicolon}:</h2>
							</div>
						</td>	
					</tr>
					{if $users_list}
					<tr>												
						<th style="text-align:left;"> {capture name="label" assign="label"}{sugar_translate label='LBL_USER_NAME' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_VOIP_ACCESS' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_USER_EXTENSION' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_ALLOW_PHONE_MOBILE' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_ALLOW_PHONE_WORK' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_ALLOW_PHONE_HOME' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_ALLOW_PHONE_OTHER' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>	
						<th style="text-align:left;">{capture name="label" assign="label"}{sugar_translate label='LBL_ALLOW_BROWSER' module='rolus_Twilio_Extension_Manager'}{/capture}
                            {$label|strip_semicolon}</th>		
					</tr>
					{foreach from=$users_list key=index item=user}		
					<tr>
						<input type="hidden" id="user_id" name="user_id" value="{$user.id}" />
						<td style="text-align:left;"> 
							{$user.full_name}
						</td>
						<td style="text-align:left;">
							<SELECT id="{$user.id}" name="{$user.id}_voip_access" onchange="handle_access_rights(this)">
								{$user.voip_access}
							</SELECT>
						</td>
						<td style="text-align:left;">
							<input type="text" class="extension_class" id="{$user.id}_extension" name="{$user.id}_extension" value="{$user.extension}" />
						</td>
						<td style="text-align:left;">
							<input type="hidden" name="{$user.id}_phone_mobile" id="{$user.id}_phone_mobile" value="{$user.allow_phone_mobile}" />
							{if $user.allow_phone_mobile eq 0}
							<input type="checkbox" class="phone_mobile" onclick="handle_phone_mobile(this)" id="{$user.id}_phone_mobile_chk" />
							{else}
							<input type="checkbox" class="phone_mobile" onclick="handle_phone_mobile(this)" id="{$user.id}_phone_mobile_chk" checked />
							{/if}							
						</td>
						<td style="text-align:left;">
							<input type="hidden" name="{$user.id}_phone_work" id="{$user.id}_phone_work" value="{$user.allow_phone_work}" />
							{if $user.allow_phone_work eq 0}
							<input type="checkbox" class="phone_work" onclick="handle_phone_work(this)" id="{$user.id}_phone_work_chk" />
							{else}
							<input type="checkbox" class="phone_work" onclick="handle_phone_work(this)" id="{$user.id}_phone_work_chk" checked />
							{/if}	
						</td>
						<td style="text-align:left;">
							<input type="hidden" name="{$user.id}_phone_home" id="{$user.id}_phone_home" value="{$user.allow_phone_home}" />
							{if $user.allow_phone_home eq 0}
							<input type="checkbox" class="phone_home" onclick="handle_phone_home(this)" id="{$user.id}_phone_home_chk" />
							{else}
							<input type="checkbox" class="phone_home" onclick="handle_phone_home(this)" id="{$user.id}_phone_home_chk" checked />
							{/if}	
						</td>
						<td style="text-align:left;">
							<input type="hidden" name="{$user.id}_phone_other" id="{$user.id}_phone_other" value="{$user.allow_phone_other}" />
							{if $user.allow_phone_other eq 0}
							<input type="checkbox" class="phone_other" onclick="handle_phone_other(this)" id="{$user.id}_phone_other_chk" />
							{else}
							<input type="checkbox" class="phone_other" onclick="handle_phone_other(this)" id="{$user.id}_phone_other_chk" checked />
							{/if}	
						</td>
						<td style="text-align:left;">
							<input type="hidden" name="{$user.id}_browser" id="{$user.id}_browser" value="{$user.allow_browser}" />
							{if $user.allow_browser eq 0}
							<input type="checkbox" class="phone_browser" onclick="handle_phone_browser(this)" id="{$user.id}_browser_chk" />
							{else}
							<input type="checkbox" class="phone_browser" onclick="handle_phone_browser(this)" id="{$user.id}_browser_chk" checked />
							{/if}	
						</td>
					</tr>	
					{/foreach}
					{/if}	
                </tbody>
            </table>
        </div>
		<!-- End Voice Mail Transcription Settings  -->
		
		
    </div>
</div>
</form>
{literal}
<script type="text/javascript" >
addToValidate('EditView', 'operator_dial_symbol', 'varchar', true, 'Operator Digit' );
addToValidate('EditView', 'extension_digits', 'varchar', true,'Number of Digits' );
addToValidate('EditView', 'welcome_message', 'varchar', true,'Welcome Message' );

/*
addToValidate('EditView', 'operator_dial_symbol', 'varchar', true, '{capture name="label" assign="label"}{sugar_translate label="LBL_OPERATOR_DIAL_SYMBOL" module="rolus_Twilio_Extension_Manager"}{/capture}{$label|strip_semicolon}' );
addToValidate('EditView', 'extension_digits', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label="LBL_EXTENSION_DIGITS" module="rolus_Twilio_Extension_Manager"}{/capture}{$label|strip_semicolon}' );
addToValidate('EditView', 'welcome_message', 'varchar', true,'{capture name="label" assign="label"}{sugar_translate label="LBL_WELCOME_MESSAGE" module="rolus_Twilio_Extension_Manager"}{/capture}{$label|strip_semicolon}' );
*/

	/*
	*	update the check box(IVR config)and (Directory Config) value to enable/disable IVR & Directory support on client side
	*/
	function handle_ivrconfig()
	{
		// updating the IVR config on client side
		if({/literal}{$bean->ivr_config eq 1}{literal})
		{
			document.getElementById("ivr_config_chk").checked = true;
		}
		else
		{
			document.getElementById("ivr_config_chk").checked = false;
		}
		// updating the user Directory support config on client side	
		if({/literal}{$bean->directory_config eq 1}{literal})
		{
			document.getElementById("directory_config_chk").checked = true;
		}
		else
		{
			document.getElementById("directory_config_chk").checked = false;
		}
		// updating the user recording config on client side	
		if({/literal}{$bean->recording_config eq 1}{literal})
		{
			document.getElementById("recording_config_chk").checked = true;
		}
		else
		{
			document.getElementById("recording_config_chk").checked = false;
		}
		// updating the user recording msg config on client side	
		if({/literal}{$bean->recording_msg_config eq 1}{literal})
		{
			document.getElementById("recording_msg_config_chk").checked = true;
		}
		else
		{
			document.getElementById("recording_msg_config_chk").checked = false;
		}
		// updating the call waiting config on client side	
		if({/literal}{$bean->call_waiting_config eq 1}{literal})
		{
			document.getElementById("call_waiting_config_chk").checked = true;
		}
		else
		{
			document.getElementById("call_waiting_config_chk").checked = false;
		}
		// updating the call forwarding config on client side	
		if({/literal}{$bean->call_forwarding_config eq 1}{literal})
		{
			document.getElementById("call_forwarding_config_chk").checked = true;
		}
		else
		{
			document.getElementById("call_forwarding_config_chk").checked = false;
		}	
		// updating the simultaneous_dialing config on client side	
		if({/literal}{$bean->simultaneous_dialing_config eq 1}{literal})
		{
			document.getElementById("simultaneous_dialing_config_chk").checked = true;
		}
		else
		{
			document.getElementById("simultaneous_dialing_config_chk").checked = false;
		}		
		// updating the voice mail transcription config for outbound call on client side	
		if({/literal}{$bean->voice_mail_outbound_call_config eq 1}{literal})
		{
			document.getElementById("voice_mail_outbound_call_config_chk").checked = true;
		}
		else
		{
			document.getElementById("voice_mail_outbound_call_config_chk").checked = false;
		}
		// updating the voice mail transcription config for inbound call on client side	
		if({/literal}{$bean->voice_mail_inbound_call_config eq 1}{literal})
		{
			document.getElementById("voice_mail_inbound_call_config_chk").checked = true;
		}
		else
		{
			document.getElementById("voice_mail_inbound_call_config_chk").checked = false;
		}			
		// updating the beep sound config for voice mail transcription on client side	
		if({/literal}{$bean->beep_sound_config eq 1}{literal})
		{
			
			document.getElementById("beep_sound_config_chk").checked = true;
		}
		else
		{
			document.getElementById("beep_sound_config_chk").checked = false;
		}
		/*here handling the enable/disable feature of the user related fields upon particular access rights*/
		{/literal}
			{foreach from=$voip_access_list key=index item=user}	
				
				{if $user.voip_access eq 'no-access' or $user.voip_access eq 'outbound' or $user.voip_access eq ''}
					{literal}document.getElementById("{/literal}{$user.id}_extension{literal}").readOnly = true;
					document.getElementById("{/literal}{$user.id}_phone_mobile_chk{literal}").disabled = true;	
					document.getElementById("{/literal}{$user.id}_phone_work_chk{literal}").disabled = true;	
					document.getElementById("{/literal}{$user.id}_phone_home_chk{literal}").disabled = true;	
					document.getElementById("{/literal}{$user.id}_phone_other_chk{literal}").disabled = true;	
					document.getElementById("{/literal}{$user.id}_browser_chk{literal}").disabled = true;	
					{/literal}
				{/if}
			{/foreach}
		{literal}	
	}

/*window.onload = function()
	{
		
		handle_ivrconfig();
	}*/
	$(document).ready(function(){
				
		handle_ivrconfig();		
	});
	
	/*
	*	update the check box state(IVR config) to enable/disable IVR in the DB
	*/
	function handle_ivrdisable()
	{
		if(document.getElementById("ivr_config_chk").checked == true)
		{
			document.getElementById("ivr_config").value = 1;
		}
		else
		{
			document.getElementById("ivr_config").value = 0;
		}
	}
	
	/*
	*	update the check box state (Directory Config) to enable/disable User Directory Support in the DB
	*/
	function handle_directory_disable()
	{
		if(document.getElementById("directory_config_chk").checked == true)
		{
			document.getElementById("directory_config").value = 1;
		}
		else
		{
			document.getElementById("directory_config").value = 0;
		}
	}
	
	/*
	*	update the check box state(Recording Config) to enable/disable call recording support in db and before establishing call
	*/
	function handle_recording_disable()
	{
		if(document.getElementById("recording_config_chk").checked == true)
		{
			document.getElementById("recording_config").value = 1;
		}
		else
		{
			document.getElementById("recording_config").value = 0;
		}
	}
	
	/*
	*	update the check box state(Recording message Config) to enable/disable call recording message in db and before establishing call
	*/
	function handle_recording_msg_disable()
	{
		if(document.getElementById("recording_msg_config_chk").checked == true)
		{
			document.getElementById("recording_msg_config").value = 1;
		}
		else
		{
			document.getElementById("recording_msg_config").value = 0;
		}
	}
	
	/*
	*	update the check box state(Call waiting Config) to enable/disable call waiting support in db and before establishing call
	*/
	function handle_call_waiting_disable()
	{
		if(document.getElementById('call_waiting_config_chk').checked == true)
		{
			document.getElementById('call_waiting_config').value = 1;
		}
		else
		{
			document.getElementById('call_waiting_config').value = 0;
		}
	}
	
	/*
	*	update the check box state(Call forwarding Config) to enable/disable call forwarding support in db and during established call
	*/
	function handle_call_forwarding_disable()
	{
		if(document.getElementById('call_forwarding_config_chk').checked == true)
		{
			document.getElementById('call_forwarding_config').value = 1;
		}
		else
		{
			document.getElementById('call_forwarding_config').value = 0;
		}
	}
	
	/*
	*	update the check box state(simultaneous dialing Config) to enable/disable simultaneous dialing support in db and upon incoming call for mobile no and Twilio number
	*/
	function handle_simultaneous_dialing_disable()
	{
		if(document.getElementById('simultaneous_dialing_config_chk').checked == true)
		{
			document.getElementById('simultaneous_dialing_config').value = 1;
		}
		else
		{
			document.getElementById('simultaneous_dialing_config').value = 0;
		}
	}
	
	/*
	*	update the check box state(voice mail outbound call Config) to enable/disable voice mail transcription support in db and at the end of outbound call
	*/
	function handle_voice_mail_outbound_call_disable()
	{
		if(document.getElementById('voice_mail_outbound_call_config_chk').checked == true)
		{
			document.getElementById('voice_mail_outbound_call_config').value = 1;
		}
		else
		{
			document.getElementById('voice_mail_outbound_call_config').value = 0;
		}
	}
	
	/*
	*	update the check box state(voice mail outbound call Config) to enable/disable voice mail transcription support in db and at the end of inbound call
	*/
	function handle_voice_mail_inbound_call_disable()
	{
		if(document.getElementById('voice_mail_inbound_call_config_chk').checked == true)
		{
			document.getElementById('voice_mail_inbound_call_config').value = 1;
		}
		else
		{
			document.getElementById('voice_mail_inbound_call_config').value = 0;
		}
	}
	
	/*
	*	update the check box state(beep sound Config) to enable/disable beep_sound support in db for recording voice message and at the end of outbound/inbound call
	*/
	function handle_beep_sound_config_disable()
	{
		if(document.getElementById('beep_sound_config_chk').checked == true)
		{
			document.getElementById('beep_sound_config').value = 1;
		}
		else
		{
			document.getElementById('beep_sound_config').value = 0;
		}
	}

	/*
	*	this will handle phone_mobile config for alll the users
	*/	
	function handle_phone_mobile(checkbox)
	{
		checkbox_id = checkbox.getAttribute("id");
		hidden_element_id = checkbox_id.slice(0,-4);
		
		if(checkbox.checked == true)
		{
			document.getElementById(hidden_element_id).value = 1;	
		}
		else if(checkbox.checked == false) 
		{
			document.getElementById(hidden_element_id).value = 0;
		}
	}
	
	/*
	*	this will handle phone_work config for alll the users
	*/	
	function handle_phone_work(checkbox)
	{
		checkbox_id = checkbox.getAttribute("id");
		hidden_element_id = checkbox_id.slice(0,-4);
		
		if(checkbox.checked == true)
		{
			document.getElementById(hidden_element_id).value = 1;	
		}
		else if(checkbox.checked == false) 
		{
			document.getElementById(hidden_element_id).value = 0;
		}
	}
	
	/*
	*	this will handle phone_home config for alll the users
	*/	
	function handle_phone_home(checkbox)
	{
		checkbox_id = checkbox.getAttribute("id");
		hidden_element_id = checkbox_id.slice(0,-4);
		
		if(checkbox.checked == true)
		{
			document.getElementById(hidden_element_id).value = 1;	
		}
		else if(checkbox.checked == false) 
		{
			document.getElementById(hidden_element_id).value = 0;
		}
	}
	
	/*
	*	this will handle phone_other config for alll the users
	*/	
	function handle_phone_other(checkbox)
	{
		checkbox_id = checkbox.getAttribute("id");
		hidden_element_id = checkbox_id.slice(0,-4);
		
		if(checkbox.checked == true)
		{
			document.getElementById(hidden_element_id).value = 1;	
		}
		else if(checkbox.checked == false) 
		{
			document.getElementById(hidden_element_id).value = 0;
		}
	}
	
	/*
	*	this will handle phone_mobile config for alll the users
	*/	
	function handle_phone_browser(checkbox)
	{
		checkbox_id = checkbox.getAttribute("id");
		hidden_element_id = checkbox_id.slice(0,-4);
		
		if(checkbox.checked == true)
		{
			document.getElementById(hidden_element_id).value = 1;	
		}
		else if(checkbox.checked == false) 
		{
			document.getElementById(hidden_element_id).value = 0;
		}
	}
	
	/*
	*	this will handle the users Access Rights w.r.t VOIP usibility 
	*/
	function handle_access_rights(dropdown)
	{
		//alert("dropdown id =>"+dropdown.getAttribute("id"));
		dropdown_id = dropdown.getAttribute("id");
		dropdown_element = document.getElementById(dropdown.getAttribute("id"));
		if(dropdown_element.value == '' || dropdown_element.value == 'no-access' || dropdown_element.value == 'outbound')
		{		
			document.getElementById(dropdown_id+"_extension").readOnly = true;
			document.getElementById(dropdown_id+"_phone_mobile_chk").disabled = true;
			document.getElementById(dropdown_id+"_phone_work_chk").disabled = true;
			document.getElementById(dropdown_id+"_phone_home_chk").disabled = true;
			document.getElementById(dropdown_id+"_phone_other_chk").disabled = true;
			document.getElementById(dropdown_id+"_browser_chk").disabled = true;
		}
		else
		{
			document.getElementById(dropdown_id+"_extension").readOnly = false;
			document.getElementById(dropdown_id+"_phone_mobile_chk").disabled = false;
			document.getElementById(dropdown_id+"_phone_work_chk").disabled = false;
			document.getElementById(dropdown_id+"_phone_home_chk").disabled = false;
			document.getElementById(dropdown_id+"_phone_other_chk").disabled = false;
			document.getElementById(dropdown_id+"_browser_chk").disabled = false;
		}
	}
	
</script>
{/literal}