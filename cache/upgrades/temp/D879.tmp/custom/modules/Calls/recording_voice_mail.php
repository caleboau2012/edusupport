<?php
	/*
	*	this will handle getting voice mail message from caller and save in database
	*/
	
	
		$GLOBALS['log']->debug("voice mail request values => ");
		$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	error_reporting(0);
	
	$user_entered = (int)$_REQUEST['Digits'];//gathering user input during call
	
	$ext_bean = get_ext_manager();
	
	if($user_entered == 1)
	{
		record_voice_mail();
	}
	else //when caller selects wrong option from the menu
	{
		redirect_main_menu();
	}
	
	/*
	*	this will handle the voice mail message functionality
	*/
	function record_voice_mail()
	{
		$ext_bean = get_ext_manager();
		
		/*if voice mail transcription is enabled for Outbound call then use lower settings */
		$voice_mail_inbound_call_config = ($ext_bean->voice_mail_inbound_call_config == '1')? 'true' : 'false';
		$beep_sound_config = ($ext_bean->beep_sound_config == '1')? 'true' : 'false';
		$silence_time_out = (!empty($ext_bean->silence_time_out))? $ext_bean->silence_time_out : 5;
		$finish_on_key = (!empty($ext_bean->finish_on_key))? $ext_bean->finish_on_key : '#';
		$recording_duration = (!empty($ext_bean->recording_duration))? $ext_bean->recording_duration : 30;
		
		header("Content-Type:text/xml");
		$data = "<?xml version='1.0' encoding='UTF-8' ?>";
		$data .= "<Response>";
		
		/* Here we will handle the voice mail or transcription */	
		if($voice_mail_inbound_call_config == 'true')
		{
			if($beep_sound_config == 'true')
			{
				$data .= "<Say>Please leave a message at the beep. Press ".$finish_on_key." when finished.</Say>";
			}
			else
				$data .= "<Say>Please leave a message. Press ".$finish_on_key." when finished.</Say>";
				
			$data .= "<Record action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=inbound_call_recording' method='GET' playBeep='".$beep_sound_config."' timeout='".$silence_time_out."' maxLength='".$recording_duration."' finishOnKey='".$finish_on_key."' />";
			$data .= "<Say>I did not receive a recording</Say>";
		}		
		
		$data .= "</Response>";
		
		print $data;
		$GLOBALS['log']->debug("record_voice_mail xml => ");
		$GLOBALS['log']->debug(print_r($data,1));
	}
	
	/*
	*	this will return the Extension bean Object to manipulate with different database fields
	*	for the dynamic configuration of the TwiML for incoming call
	*	and also provide support to get operator's username based upon username
	*/
	function get_ext_manager()
	{
		$moduleName = "rolus_Twilio_Extension_Manager";
		$ext_bean = BeanFactory::getBean($moduleName);
		$ext_bean->retrieve('1');
				
		return $ext_bean;
	}
	
	/*
	*	this will provide TwiML instructions to redirect caller to main menu if he/she entered invalid input
	*/
	function redirect_main_menu()
	{
		$ext_bean = get_ext_manager();
		
		header("Content-Type: text/xml");
		$data = "<?xml version='1.0' encoding='UTF-8'?>";	
		$data .= "<Response>";
		$data .= "<Pause length='2'/>";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >Sorry, the selected option, is not available, in this menu. Goodbye!</Say>";
    		$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback</Redirect>";
		$data .= "</Response>";		
		print $data;
			$GLOBALS['log']->debug("redirect to main menu in case user has entered invalid digit => ");
			$GLOBALS['log']->debug(print_r($data,1));
		
	}
?>	