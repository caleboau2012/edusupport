<?php
	/**
	*	this will provide the necessory TwiML instructions to Twilio in response to Call back 	
	*	while making outbound call through browser to traditional phone
	**/
	
	$GLOBALS['log']->debug("outbound_browser callback REQUSET values =>");
	$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	if(!empty($_REQUEST['CallSid']))
	{
		save_twilio_call_id($_REQUEST['CallSid']);
	}
	if(!empty($_REQUEST['destination']))
	{
		make_browser_call($_REQUEST['destination']);
	}
	
	/*
	*	this will save twilio call_id of current outbound call to database against RefCallId
	*/
	function save_twilio_call_id($call_id)
	{
		/*$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);
		$call_bean->retrieve($_REQUEST['RefCallId']);
		$call_bean->twilio_call_id = $call_id;
		$call_bean->save();*/
		$sql = "UPDATE calls SET twilio_call_id='".$call_id."' WHERE id='".$_REQUEST['RefCallId']."'";
		$GLOBALS['db']->query($sql);
	}
	
	/*
	*	this will provide TwiML Instructions to Twilio to make browser to phone outbound call
	*/
	function make_browser_call($destination)
	{
		global $db;
		$sql = "SELECT phone_number FROM rolus_twilio_account WHERE id=1";
		$result = $db->query($sql);
		if($db->getRowCount($result)>0)
		{
			$row = $db->fetchByAssoc($result);		
			
			$GLOBALS['log']->debug("outbound_browser_phone_number".$row['phone_number']);
			
			header("Content-Type:text/xml");
			$outbound_xml = '<?xml version="1.0" encoding="UTF-8" ?>';
			$outbound_xml .= '<Response>';
			$outbound_xml .= '<Dial callerId="'.$row['phone_number'].'" record="true" action="'.$GLOBALS['sugar_config']['site_url'].'/index.php?entryPoint=outbound_call_recording" >';	
			$outbound_xml .= $destination;
			$outbound_xml .= '</Dial>';
			$outbound_xml .= '</Response>';
			
			$GLOBALS['log']->debug(print_r($outbound_xml,1));
			
			print_r($outbound_xml);
		}
		else
		{
			
			$GLOBALS['log']->debug("twilio_number is not configured in the Database");
			
		}
	}	
?>