<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
if(!isset($hook_version) || empty($hook_version))
 	$hook_version = 1; 

if(!isset($hook_array) || !is_array($hook_array))
	$hook_array = array();

if(!isset($hook_array['before_save']) || !is_array($hook_array['before_save']))
	$hook_array['before_save'] = array();	

$hook_array['before_save'][] = Array(1, 'Managing Users for VOIP', 'custom/modules/rolus_Twilio_Extension_Manager/ManagingUsersForVOIP.php','ManagingUsersForVOIP', 'ManagingUsers'); 
?>