<?php
	/**
	*	this will update the call ended status to DB after getting callEnded callback from twilio server
	*
	*/	

		$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	
	if(!empty($_REQUEST['RefCallId'])) // this will save the outbound call(browser & phone) points to db
	{
		save_call_points($_REQUEST['RefCallId']);
	}
	else
	{
		if(isset($_REQUEST['DialCallDuration']))
		{
			//$call_status = $_REQUEST['DialCallStatus'];
			$call_status = ($_REQUEST['DialCallStatus'] == 'completed')? 'Held' : $_REQUEST['DialCallStatus'];
			$call_duration = ceil($_REQUEST['DialCallDuration']/60);	 			
		}
		elseif(isset($_REQUEST['RecordingDuration']))
		{
			$call_status = "Held"; // to place the call log in history sub panel
			$call_duration = ceil($_REQUEST['RecordingDuration']/60);
			
			save_voice_message($_REQUEST['CallSid']); // this will save the outbound voice message
		}		
		
		$current_date = gmdate('Y-m-d H:i:s');	
		$time_end = strtotime($current_date);	
		$twilio_call_price = (string)$_REQUEST["price"];
		//get Current Call details to get price
		require_once("modules/rolus_Twilio_Account/rolus_Twilio_Account.php");
		$rolus_Twilio_Account = new rolus_Twilio_Account();
	
		try{
			$client = $rolus_Twilio_Account->getClient();
			if(!(is_object($client) && $client instanceof Services_Twilio))
					throw new settingsException('Cannot connect to Twilio','3');
			$call_sid_price = (isset($_REQUEST['DialCallSid']))? $_REQUEST['DialCallSid'] : $_REQUEST['CallSid'];
			$current_call = $client->account->calls->get($call_sid_price);
			$twilio_call_price = (string)$current_call->price;
		
		} catch (communicaitonException $e) {
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
		} catch (settingsException $e) {
			$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
		} catch (Exception $e) {
			$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
		}
		//$sql = "UPDATE calls SET date_end='".$time_end."',status='".$call_status."',duration_minutes='".$call_duration."',recordings='".$_REQUEST['RecordingUrl']."',sync=1 WHERE twilio_call_id='".$_REQUEST['CallSid']."'";
		//$sql = "UPDATE calls SET date_end='".$time_end."',status='".$call_status."',duration_minutes='".$call_duration."',price='".$twilio_call_price."',recordings='".$_REQUEST['RecordingUrl']."' WHERE twilio_call_id='".$_REQUEST['CallSid']."'";
		$sql = "UPDATE calls SET date_end= date_start + INTERVAL '".$call_duration."' MINUTE ,status='".$call_status."',duration_minutes='".$call_duration."',price='".$twilio_call_price."',recordings='".$_REQUEST['RecordingUrl']."' WHERE twilio_call_id='".$_REQUEST['CallSid']."'";
		$GLOBALS['db']->query($sql);
		
		/*if voice mail transcription is enabled for Outbound call then use lower settings */
		/*$ext_bean = get_ext_manager();
		
		$voice_mail_outbound_call_config = ($ext_bean->voice_mail_outbound_call_config == '1')? 'true' : 'false';
		$beep_sound_config = ($ext_bean->beep_sound_config == '1')? 'true' : 'false';
		$silence_time_out = (!empty($ext_bean->silence_time_out))? $ext_bean->silence_time_out : 5;
		$finish_on_key = (!empty($ext_bean->finish_on_key))? $ext_bean->finish_on_key : '#';
		$recording_duration = (!empty($ext_bean->recording_duration))? $ext_bean->recording_duration : 30;*/
		
		header('Content-Type: text/xml');
		$data  = '<?xml version="1.0" encoding="UTF-8"?>';
		$data .= '<Response>';
		
		/* Here we will handle the voice mail or transcription */	
		/*if(!isset($_REQUEST['DialCallDuration']) AND !isset($_REQUEST['Digits']))
		{
			if($voice_mail_outbound_call_config == 'true')
			{
				if($beep_sound_config == 'true')
				{
					$data .= "<Say>Please leave a message at the beep. Press ".$finish_on_key." when finished.</Say>";
				}
				else
					$data .= "<Say>Please leave a message. Press ".$finish_on_key." when finished.</Say>";
					
				$data .= "<Record action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=outbound_call_recording' method='GET' playBeep='".$beep_sound_config."' timeout='".$silence_time_out."' maxLength='".$recording_duration."' finishOnKey='".$finish_on_key."' />";
				$data .= "<Say>I did not receive a recording</Say>";
			}	
		}*/	
		$data .= '</Response>';
		
		print_r($data);
	}
	
	/*
	*	this will save call key points to database
	*/
	function save_call_points($ref_call_id)
	{
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);
		$call_bean->retrieve($ref_call_id);
		$call_bean->description = "Notes Message: ".$_REQUEST['call_points'];
		$call_bean->save();
		print("true");
	}
	
	/*
	*	this will return the Extension bean Object to manipulate with different database fields
	*	for the dynamic configuration of the TwiML for incoming call
	*	and also provide support to get operator's username based upon username
	*/
	/*function get_ext_manager()
	{
		$moduleName = "rolus_Twilio_Extension_Manager";
		$ext_bean = BeanFactory::getBean($moduleName);
		$ext_bean->retrieve('1');
				
		return $ext_bean;
	}*/
	
	/*
	*	this will save the voice message in case of the outbound call and destination party is busy
	*/
	function save_voice_message($call_id)
	{
		global $current_user;
		$current_date = gmdate("Y-m-d H:i:s",time()); //current date n time
		
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);	
		
		$call_bean->name="Outbound Voice Message ".$current_user->last_name;
		$call_bean->duration_hours = 00;
		$call_bean->date_start = $current_date;				
		$call_bean->direction = "Outbound";		
		$call_bean->twilio_call_id = $call_id;
		$call_bean->source = $_REQUEST['From'];
		$call_bean->destination = $_REQUEST['To'];
		$call_bean->duration_minutes = ceil($_REQUEST['RecordingDuration']/60);				
		$call_bean->sync = 1;
	
		$call_bean->save();
		
		$GLOBALS['log']->debug("<=>voice message as call object after saving(outbound)=>");
		$GLOBALS['log']->debug(print_r($call_bean,1));
	}
?>
