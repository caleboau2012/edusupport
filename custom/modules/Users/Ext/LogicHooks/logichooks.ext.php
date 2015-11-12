<?php 
 //WARNING: The contents of this file are auto-generated


// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
if(!isset($hook_version) || empty($hook_version))
 	$hook_version = 1; 

if(!isset($hook_array) || !is_array($hook_array))
	$hook_array = array();

if(!isset($hook_array['after_login']) || !is_array($hook_array['after_login']))
	$hook_array['after_login'] = array();	

$hook_array['after_login'][] = Array(1, 'User login status updater' , 'custom/modules/Users/user_login_status_updater.php','User_Login_Status_Updater','login_flag_updater');

if(!isset($hook_array['before_logout']) || !is_array($hook_array['before_logout']))
	$hook_array['before_logout'] = array();	

$hook_array['before_logout'][] = Array(1, 'User logout status updater' , 'custom/modules/Users/user_login_status_updater.php','User_Login_Status_Updater','logout_flag_updater');

?>