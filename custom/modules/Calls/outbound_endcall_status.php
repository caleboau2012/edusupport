<?php
	
	/**
	*	this will be executing periodically due to periodic ajax calls from client-side 
	*	using long polling technique to update call ended status to caller on client side
	*   moreover,this will return the final call status currently initiated	
	*/
	
	$GLOBALS['log']->debug("getting end call status request values => ");
	$GLOBALS['log']->debug(print_r($_REQUEST,1));	
	
	if($_REQUEST['source'] == "db")
	{
		get_status_from_db($_REQUEST['call_sid']);
	}	
	else if($_REQUEST['source'] == 'twilio')
	{		
		get_status_from_twilio($_REQUEST['call_sid']);
	}
	
	/*
	*	this will try to fetch the current call status from db and display to user on client side
	*/
	function get_status_from_db($call_sid)
	{
		global $db;
		$sql = "SELECT status FROM calls WHERE twilio_call_id='".$call_sid."'";
		$result = $db->query($sql);
		$call_status = $db->fetchByAssoc($result);
		if($call_status['status'] == "dialing")		
		{
			$call_status_db = "dialing";			
		}
		else if($call_status['status'] == "in-progress" OR $call_status['status'] == "dialed")
		{
			$call_status_db = "dialed";
		}
		else
		{
			$call_status_db = $call_status['status'];
		}
		if($call_status_db == 'completed')// to place the call log in history sub panel
		    $call_status_db = 'Held';   
	
		$GLOBALS['log']->debug("getting end call status (db)=> ");
		$GLOBALS['log']->debug(print_r($call_status_db,1));	
		
		print_r($call_status_db);
	}
	
	/*
	*	this will try to fetch the current call status from Twilio and display to user on client side
	*/
	function get_status_from_twilio($call_sid)
	{
		global $db;
		$twilio_call_status = '';
		/*$target_module = 'rolus_Twilio_Account';
		$class = $GLOBALS['beanList'][$target_module];
		require_once($GLOBALS['beanFiles'][$class]);
		$rolus_Twilio_Account = new $class();*/
		
		require_once("modules/rolus_Twilio_Account/rolus_Twilio_Account.php");
		$rolus_Twilio_Account = new rolus_Twilio_Account();
			
		try{
			$client = $rolus_Twilio_Account->getClient();
			if(!(is_object($client) && $client instanceof Services_Twilio))
					throw new settingsException('Cannot connect to Twilio','3');
								
			$current_call = $client->account->calls->get($call_sid);
			$GLOBALS['log']->debug("getting end call status fetching object (twilio)=> ");
			$GLOBALS['log']->debug(print_r($current_call,1));
						
			$twilio_call_status = (string)$current_call->status;
			
			if($twilio_call_status == "ringing" || $twilio_call_status == "queued")
			{
				$call_status = "dialing";
			}
			else if($twilio_call_status == "in-progress")
			{							
				$call_status = "dialed";				
			}
			else if($twilio_call_status == 'completed')
			{
				$call_status = 'Held'; //Held status to place completed call in History subpanel
			}
			else
			{
				$call_status = $twilio_call_status;
			}					
			$sql = 'UPDATE calls SET status="'.$call_status.'" WHERE twilio_call_id="'.$_REQUEST['call_sid'].'"';
			$db->query($sql);
			
			print($call_status);
			
			$GLOBALS['log']->debug("getting end call status (twilio)=> ");
			$GLOBALS['log']->debug(print_r($call_status,1));
			
		} catch (communicaitonException $e) {			
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
		} catch (settingsException $e) {	
			$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
		} catch (Exception $e) {		
			$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
		}
	}
?>