<?php
	/**
	*	this will update the data base fields values 
	* 	when call is Held 
	*	.. moreover this will save (inbound)call key points to DB
	**/	
	
	/* implementing no record of incoming call when attended by operator */	
	
	/*$module_name = 'rolus_Twilio_Extension_Manager';
	$ext_bean = BeanFactory::getBean($module_name);
	if($GLOBALS['current_user']->id != $ext_bean->operator_name)
	{*/		
	require_once("modules/rolus_Twilio_Account/rolus_Twilio_Account.php");
			
		// this will save call key points in the db 
		if(!empty($_REQUEST['call_id']))
		{
			
			save_call_points($_REQUEST['call_id']);
		}
		else
		{
			
			
				$GLOBALS['log']->debug("final inbound call callback params=>");
				$GLOBALS['log']->debug(print_r($_REQUEST,1));
			/* if twilio hit this url after call ended then call id will use to 
			*  save the call recording otherwise in case of cancelled call or voice mail 
			*  no call sid is passed to save call recording rather use CallSid(parent call sid) to save 
			*  voice mail recording because here onlye one leg of twilio call is being created parent call leg
			*/				
				
			$call_sid = (isset($_REQUEST['DialCallSid']))? $_REQUEST['DialCallSid'] : ''; // if  
			save_recordings($call_sid);
		}
	//}	
	/*
	*	this will save the key points of currently Held inbound call
	*/
	function save_call_points($call_id)
	{
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);
		$call_bean->retrieve_by_string_fields(array("twilio_call_id"=>$call_id));
		$call_bean->description = "Notes Message: ".$_REQUEST['call_points'];
		$call_bean->save();
		print("true");
	}
	
	/*
	*	this will save the recording url of currently Held inbound call or voice mail recording
	*/
	function save_recordings($call_id)
	{
		
		$rolus_Twilio_Account = new rolus_Twilio_Account();
		if(empty($call_id)) // means here need to save voice mail call with parent callsid
		{			
			$call_id = $_REQUEST['CallSid'];
			save_voice_mail($call_id); // this will save the voice mail call 	
						
		}
		if(isset($_REQUEST['RecordingUrl']))
		{
			
			$moduleName = "Calls";
			$call_bean = BeanFactory::getBean($moduleName);
			$call_bean->retrieve_by_string_fields(array("twilio_call_id"=>$call_id));
			try{
				
					$client = $rolus_Twilio_Account->getClient();
				if(!(is_object($client) && $client instanceof Services_Twilio))
						throw new settingsException('Cannot connect to Twilio','3');
				$current_call = $client->account->calls->get($call_id);
			
			if (!isset($call_bean->twilio_call_id) || empty($call_bean->twilio_call_id) || ($call_bean->twilio_call_id == NULL))
			{
				
				$call_bean_new = BeanFactory::getBean($moduleName);
				$call_bean_new->source = process_number($current_call->from);
				$call_bean_new->destination = $current_call->to;
				$call_bean_new->recordings = $_REQUEST['RecordingUrl'];
				if(isset($_REQUEST['RecordingDuration']))
				{
			 	$call_bean_new->duration_minutes = ceil($_REQUEST['RecordingDuration']/60);
				}
				$call_bean_new->status = $current_call->status;
				$call_bean_new->direction = "Inbound";
				$call_bean_new->price= (string)$current_call->price;
				
				$call_bean_new->save();

			}	
				
				$twilio_call_price = (string)$current_call->price;
				$call_bean->price=$twilio_call_price;
			}
			catch (communicaitonException $e) {			
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
			} catch (settingsException $e) {	
				$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
			} catch (Exception $e) {		
				$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
			}
			$call_bean->recordings = $_REQUEST['RecordingUrl'];
			if(isset($_REQUEST['RecordingDuration']))
			{
			 $call_bean->duration_minutes = ceil($_REQUEST['RecordingDuration']/60);
			}
			
			//$call_bean->sync = 1;

			if (isset($call_bean->twilio_call_id) && !empty($call_bean->twilio_call_id) && ($call_bean->twilio_call_id != NULL))
			{
				
				$call_bean->save();
			}
			
		}
		
		else if (isset($_REQUEST['DialCallDuration']) && !isset($_REQUEST['RecordingUrl']))
		{
		 	
			$moduleName = "Calls";
			$call_bean = BeanFactory::getBean($moduleName);
			$call_bean->retrieve_by_string_fields(array("twilio_call_id"=>$call_id));
			try{
				$client = $rolus_Twilio_Account->getClient();
				if(!(is_object($client) && $client instanceof Services_Twilio))
						throw new settingsException('Cannot connect to Twilio','3');
				
				$current_call = $client->account->calls->get($call_id);
			
				if (!isset($call_bean->twilio_call_id) || empty($call_bean->twilio_call_id) || ($call_bean->twilio_call_id == NULL))
			{
				$call_bean_new = BeanFactory::getBean($moduleName);
				$call_bean_new->source = process_number($current_call->from);
				$call_bean_new->destination = $current_call->to;
				$call_bean_new->recordings = $_REQUEST['RecordingUrl'];
				if(isset($_REQUEST['RecordingDuration']))
				{
			 	$call_bean_new->duration_minutes = ceil($_REQUEST['RecordingDuration']/60);
				}
				$call_bean_new->status = $current_call->status;
				$call_bean_new->direction = "Inbound";
				
				$call_bean_new->price= (string)$current_call->price;
				$call_bean_new->save();

			}
				
				$twilio_call_price = (string)$current_call->price;
				$call_bean->price=$twilio_call_price;
			}
			catch (communicaitonException $e) {			
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
			} catch (settingsException $e) {	
				$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
			} catch (Exception $e) {		
				$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
			}

			if (isset($call_bean->twilio_call_id) && !empty($call_bean->twilio_call_id) && ($call_bean->twilio_call_id != NULL))
			{
				$call_bean->duration_minutes = ceil($_REQUEST['DialCallDuration']/60);
				$call_bean->save();
			}
			
		}
		/*if voice mail transcription is enabled for Outbound call then use lower settings */
		/*$ext_bean = get_ext_manager();
		
		$voice_mail_inbound_call_config = ($ext_bean->voice_mail_inbound_call_config == '1')? 'true' : 'false';
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
			if($voice_mail_inbound_call_config == 'true')
			{
				if($beep_sound_config == 'true')
				{
					$data .= "<Say>Please record a message at the beep. Press ".$finish_on_key." when finished.</Say>";
				}
				else
					$data .= "<Say>Please record a message. Press ".$finish_on_key." when finished.</Say>";
					
				$data .= "<Record action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=inbound_call_recording' method='GET' playBeep='".$beep_sound_config."' timeout='".$silence_time_out."' maxLength='".$recording_duration."' finishOnKey='".$finish_on_key."' />";				
				$data .= "<Say>I did not receive a recording</Say>";
			}
		}*/	
		$data .= '</Response>';
		
		$GLOBALS['log']->debug("final inbound call transcription XML =>");
		$GLOBALS['log']->debug(print_r($data,1));
		
		print_r($data);	
		
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
	*	this will voice mail call in database because here only one leg of twilioInboundCall is generated
	*/
	function save_voice_mail($call_id)
	{
		global $current_user;
		$rolus_Twilio_Account = new rolus_Twilio_Account();
		$current_date = gmdate("Y-m-d H:i:s",time()); //current date n time
		
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);	
		
		$call_bean->name="Inbound Voice Mail ".$current_user->last_name;
		$call_bean->duration_hours = 00;
		$call_bean->date_start = $current_date;		
		$call_bean->status = "Held";// to place the call log in history sub panel
		$call_bean->direction = "Inbound";		
		$call_bean->twilio_call_id = $call_id;
		$call_bean->source = process_number($_REQUEST['From']);
		$call_bean->destination = $_REQUEST['To'];
		$call_bean->duration_minutes = ceil($_REQUEST['RecordingDuration']/60);				
		$call_bean->sync = 1;			
			try{
				$client = $rolus_Twilio_Account->getClient();
				if(!(is_object($client) && $client instanceof Services_Twilio))
						throw new settingsException('Cannot connect to Twilio','3');
				$current_call = $client->account->calls->get($call_id);
				if (!isset($call_bean->twilio_call_id) || empty($call_bean->twilio_call_id) || ($call_bean->twilio_call_id == NULL))
			{
				$call_bean_new = BeanFactory::getBean($moduleName);	
				$call_bean_new->source = process_number($current_call->from);
				$call_bean_new->destination = $current_call->to;
				$call_bean_new->recordings = $_REQUEST['RecordingUrl'];
				if(isset($_REQUEST['RecordingDuration']))
				{
			 	$call_bean_new->duration_minutes = ceil($_REQUEST['RecordingDuration']/60);
				}
				$call_bean_new->status = $current_call->status;
				$call_bean_new->direction = "Inbound";
				
				$call_bean_new->price= (string)$current_call->price;
				$call_bean_new->save();

			}
				$twilio_call_price = (string)$current_call->price;
				$call_bean->price=$twilio_call_price;
			}
			catch (communicaitonException $e) {			
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
			} catch (settingsException $e) {	
				$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
			} catch (Exception $e) {		
				$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
			}

			if (isset($call_bean->twilio_call_id) && !empty($call_bean->twilio_call_id) && ($call_bean->twilio_call_id != NULL))
			{
              $call_bean->save();
			}
		
		$GLOBALS['log']->debug("<=>voice mail as call object after saving(inbound)=>");
		$GLOBALS['log']->debug(print_r($call_bean,1));
	}

	function process_number($number)
	{
		$formatted_number;
		if(strlen($number) == 12) // 12 length number represents that number is actually of US
		{			
			$formatted_number = $number;
		}
		else
		{
			if(substr($number, 1, 1)!= 7 && substr($number, 1, 1) == 1)
			{
				$number[1] = "";
				$formatted_number = $number;
			}
			else 
			{
				$formatted_number = $number;
			}	
		}
		return $formatted_number;
	}	
?>

