<?php 

// Twilio Account Settings
$admin_option_defs=array();													// image file name(gif) //besides img link text              // description  related to module          // url of the module(opens upon clicking besides image text)            
$admin_option_defs['Administration']['rolus_twilio_account_settings']= array('rolus_Twilio_Account','LBL_ROLUS_TWILIO_ACCOUNT_SETTINGS','LBL_ROLUS_TWILIO_ACCOUNT_SETTINGS_DESC','./index.php?module=rolus_Twilio_Account');
$admin_option_defs['Administration']['rolus_twilio_ivr_settings']= array('rolus_Twilio_Extension_Manager','LBL_ROLUS_TWILIO_IVR_SETTINGS','LBL_ROLUS_TWILIO_IVR_SETTINGS_DESC','./index.php?module=rolus_Twilio_Extension_Manager');
$admin_group_header[]= array('RT Telephony','',false,$admin_option_defs, 'Modify Call Account Settings');

?>