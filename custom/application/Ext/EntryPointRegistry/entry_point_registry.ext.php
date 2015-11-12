<?php 
 //WARNING: The contents of this file are auto-generated

 
	$entry_point_registry['responseEntryPoint'] = array(
	    'file' => 'modules/FP_events/responseEntryPoint.php',
	    'auth' => false
	);

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


$entry_point_registry['deleteAttachment'] = array('file' => 'include/SugarFields/Fields/Image/deleteAttachment.php' , 'auth' => '1');


$entry_point_registry['QuickCRMgetConfig'] = array(
	'file' => 'custom/QuickCRM/getConfig.php',
	'auth' => false
);


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/Controller/entry_point_registry.php');

$entry_point_registry['twilioSMS'] = array('file' => 'modules/rolus_SMS_log/smsUpdates.php', 'auth' => false);
$entry_point_registry['twilio_callback'] = array('file'=>'custom/modules/Calls/twilio_callback.php', 'auth' => false);
$entry_point_registry['ProcessUserInput'] = array('file'=>'custom/modules/Calls/ProcessUserInput.php', 'auth' => false);
$entry_point_registry['ProcessExtensions'] = array('file'=>'custom/modules/Calls/ProcessExtensions.php', 'auth' => false);
$entry_point_registry['ProcessDirectory'] = array('file'=>'custom/modules/Calls/ProcessDirectory.php', 'auth' => false);
$entry_point_registry['TalkToDirectoryAgent'] = array('file'=>'custom/modules/Calls/TalkToDirectoryAgent.php', 'auth' => false);
$entry_point_registry['inbound_call_recording'] = array('file'=>'custom/modules/Calls/inbound_call_recording.php', 'auth'=>false);
$entry_point_registry['outbound_phone_callback'] = array('file'=>'custom/modules/Calls/outbound_phone_callback.php', 'auth' => false);
$entry_point_registry['outbound_browser_callback'] = array('file'=>'custom/modules/Calls/outbound_browser_callback.php','auth'=>false);
$entry_point_registry['outbound_endcall_status'] = array('file'=>'custom/modules/Calls/outbound_endcall_status.php','auth'=>false);
$entry_point_registry['outbound_call_recording'] = array('file'=>'custom/modules/Calls/outbound_call_recording.php','auth'=>false);
$entry_point_registry['recording_voice_mail'] = array('file'=>'custom/modules/Calls/recording_voice_mail.php','auth'=>false);
$entry_point_registry['phone_verification'] = array('file'=>'modules/rolus_Twilio_Account/phone_verification.php','auth'=>false);


?>