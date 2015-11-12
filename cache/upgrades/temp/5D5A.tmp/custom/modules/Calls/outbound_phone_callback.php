<?php
	/*
	*	this will update the outgoing call status n required values to Db,
	*	when the current call is answered by Human,
	*	Also will provide the TwiML instructions required for making outbound call
	**/
	//error_reporting(0);
	global $db;
	global $current_user;
	$current_date = date("Y-m-d H:i:s",time()); //current date n time
	
	//this is the TwiML instruction that twilio will require for making outbound call 
	header("Content-Type: text/xml");
	
	$callback_xml = "<?xml version='1.0' encoding='UTF-8'?>";
	$callback_xml .= "<Response>";
	$callback_xml .= "<Dial record='true' callerId='".$_REQUEST['source']."' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=outbound_call_recording'>";
	$callback_xml .= $_REQUEST['dest'];
	$callback_xml .= "</Dial>";
	$callback_xml .= "</Response>";
	
	$GLOBALS['log']->debug("make_call_callBack_dial_source => ");
	$GLOBALS['log']->debug(print_r($callback_xml,1));
	
	print_r($callback_xml);
?>