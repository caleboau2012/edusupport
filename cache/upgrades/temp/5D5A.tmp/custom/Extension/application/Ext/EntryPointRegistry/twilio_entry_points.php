<?php
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
