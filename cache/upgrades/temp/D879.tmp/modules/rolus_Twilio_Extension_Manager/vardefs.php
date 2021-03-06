<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

$dictionary['rolus_Twilio_Extension_Manager'] = array(
	'table'=>'rolus_twilio_extension_manager',
	'audited'=>true,
		'duplicate_merge'=>true,
		'fields'=>array (
		  'ivr_config' =>
			array(
			'required' => true,
			'name' => 'ivr_config',
			'vname' => 'LBL_IVRCONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
			),
		  'directory_config' =>
			array(
			'required' => true,
			'name' => 'directory_config',
			'vname' => 'LBL_DIRECTORY_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
			),
		  'recording_config' =>
			array(
			'required' => true,
			'name' => 'recording_config',
			'vname' => 'LBL_RECORDING_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
			),
		 'recording_msg_config' =>
		  array(
			'required' => true,
			'name' => 'recording_msg_config',
			'vname' => 'LBL_RECORDING_MSG_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
		 ),	
		  'extension_digits' => 
		  array (
			'required' => true,
			'name' => 'extension_digits',
			'vname' => 'LBL_EXTENSION_DIGITS',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '10',
			'size' => '10',
		  ),
		 'operator_dial_symbol' => 
		   array (
			'required' => true,
			'name' => 'operator_dial_symbol',
			'vname' => 'LBL_OPERATOR_DIAL_SYMBOL',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
		  ),		 
		 'pause_bw_instructions' =>
		   array (
			'required' => true,
			'name' => 'pause_bw_instructions',
			'vname' => 'LBL_PAUSE_BW_INSTRUCTIONS',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '100',
			'size' => '20',	
		  ),
		  'instructions_loop' => 
		    array (
			'required' => true,
			'name' => 'instructions_loop',
			'vname' => 'LBL_INSTRUCTIONS_LOOP',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '2',
			'size' => '10',
		  ),
		 'main_menu_gather_delay' => 
		    array (
			'required' => true,
			'name' => 'main_menu_gather_delay',
			'vname' => 'LBL_MAIN_MENU_GATHER_DELAY',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '2',
			'size' => '10',
		  ),
		  'ext_menu_gather_delay' => 
		    array (
			'required' => true,
			'name' => 'ext_menu_gather_delay',
			'vname' => 'LBL_EXT_MENU_GATHER_DELAY',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '2',
			'size' => '10',
		  ),
		 'ivr_voice' => 
		   array (
			'required' => false,
			'name' => 'ivr_voice',
			'vname' => 'LBL_IVR_VOICE',
			'type' => 'enum',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '10',
			'size' => '10',
			'studio' => 'visible',
			'options' => 'ivr_voice_dom',
		  ),
		  'operator_name' => 
		   array (
			'required' => false,
			'name' => 'operator_name',
			'vname' => 'LBL_OPERATOR_NAME',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '100',
			'size' => '100',
			'studio' => 'visible',			
		  ),
		 'welcome_message' => 
		   array (
			'required' => true,
			'name' => 'welcome_message',
			'vname' => 'LBL_WELCOME_MESSAGE',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '300',
			'size' => '50',
		  ),
		  'call_waiting_config' =>
		   array(
			'required' => true,
			'name' => 'call_waiting_config',
			'vname' => 'LBL_CALL_WAITING_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
			),	
		  'call_forwarding_config' =>
		   array(
			'required' => true,
			'name' => 'call_forwarding_config',
			'vname' => 'LBL_CALL_FORWARDING_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
		  ),		  
		 'simultaneous_dialing_config' =>
		   array(
			'required' => true,
			'name' => 'simultaneous_dialing_config',
			'vname' => 'LBL_SIMULTANEOUS_DIALING_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
		  ),
		  'voice_mail_outbound_call_config' =>
		   array(
			'required' => true,
			'name' => 'voice_mail_outbound_call_config',
			'vname' => 'LBL_VOICE_MAIL_OUTBOUND_CALL_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
		  ),
		  'voice_mail_inbound_call_config' =>
		   array(
			'required' => true,
			'name' => 'voice_mail_inbound_call_config',
			'vname' => 'LBL_VOICE_MAIL_INBOUND_CALL_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
		  ),
		  'beep_sound_config' =>
		   array(
			'required' => true,
			'name' => 'beep_sound_config',
			'vname' => 'LBL_BEEP_SOUND_CONFIG',
			'type' => 'bool',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '1',
			'size' => '1',
		  ),
		 'silence_time_out' => 
		   array (
			'required' => true,
			'name' => 'silence_time_out',
			'vname' => 'LBL_SILENCE_TIME_OUT',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '3',
			'size' => '10',
		  ),
		 'finish_on_key' => 
		   array (
			'required' => true,
			'name' => 'finish_on_key',
			'vname' => 'LBL_FINISH_ON_KEY',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '3',
			'size' => '10',
		  ),
		 'recording_duration' => 
		   array (
			'required' => true,
			'name' => 'recording_duration',
			'vname' => 'LBL_RECORDING_DURATION',
			'type' => 'varchar',
			'massupdate' => 0,
			'no_default' => false,
			'comments' => '',
			'help' => '',
			'importable' => true,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'unified_search' => false,
			'merge_filter' => 'disabled',
			'len' => '3',
			'size' => '10',
		  ),
		),
	'relationships'=>array (
		),
	'optimistic_locking'=>true,
		'unified_search'=>true,
	);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('rolus_Twilio_Extension_Manager','rolus_Twilio_Extension_Manager', array('basic','assignable'));