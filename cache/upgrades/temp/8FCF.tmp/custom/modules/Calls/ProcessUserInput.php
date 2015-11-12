<?php
	/*
	*	this will handle the Dialed Extensions and transfer call control
	*	towards the dialed extension
	*/
	
	
		$GLOBALS['log']->debug("Dialed Extensions Url's values => ");
		$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	error_reporting(0);
	
	$user_entered = (int)$_REQUEST['Digits'];//gathering user input during call
	$operator_symbol = $_REQUEST['Digits'];
	
	$ext_bean = get_ext_manager();
	
	if($user_entered == 1)
	{
		process_extensions();
	}
	else if($user_entered == 2)
	{
		process_directory();
	}
	else if($operator_symbol == $ext_bean->operator_dial_symbol)
	{			
		talk_to_operator();
	}
	else //when caller selects wrong option from the menu
	{
		redirect_main_menu();
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
	*	this will return the user_name against provided id otherwise return false 
	*/
	function get_logged_in_user_name($user_id = NULL)
	{	
		$moduleName = 'Users';
		$user_bean = BeanFactory::getBean($moduleName);
		$user_bean->retrieve($user_id);
			
		return $user_bean->user_name;
	}
			
	/*
	*	this will provide support to let the incoming caller will talk to operator, when he doesn't enter any extension
	*/
	function talk_to_operator()
	{		
		$ext_bean = get_ext_manager();
		
		if(empty($ext_bean->operator_name) AND $ext_bean->operator_name == NULL)
		{			
			dial_general_operator();
		}
		else
		{						
			dial_configured_operator();
		}		
	}
	
	/*
	*	this will provide support that, if there is not set any user as Opertaor so it will try to dial any available user
	*/
	function dial_general_operator($user_name = NULL)
	{		
		if($user_name == NULL)
		{			
			$sql = "SELECT user_name from users WHERE logged_in=1 AND availability=0 LIMIT 1";
		}
		else		
		{			
			$sql = "SELECT * from users WHERE logged_in=1 AND availability=0 AND user_name='".$user_name."'";
		}
		
		$GLOBALS['log']->debug("dial operator sql => ".$sql);
		
		$result = $GLOBALS['db']->query($sql);
		$user_array = $GLOBALS['db']->fetchByAssoc($result); 
		
		$GLOBALS['log']->debug("selected dialable operator username=> ".$user_array['user_name']);
		
		if(!empty($result->num_rows)) // means when any operator is available to attend call(connect incoming call to this operator)
		{
			$GLOBALS['log']->debug("In dial operator case =>");
			dial_operator($user_array['user_name'],$user_array);
			
		}
		else 		
		{
			$GLOBALS['log']->debug("in Busy Case =>");
			dial_busy();
		}
	}
	
	/*
	*	this will provide support to dial to operator that is configured or set in IVR Configuration module
	*/
	function dial_configured_operator()
	{
		$ext_bean = get_ext_manager(); // getting operator_name's value that is selected userId from extension manager's bean		
		
		$user_name = get_logged_in_user_name($ext_bean->operator_name);	
		
		dial_general_operator($user_name);		
	}
	
	/*
	*	this will provide the required TwiML instructions to dial operator
	*/
	function dial_operator($user_name,$user_array = NULL)
	{		
		$ext_bean = get_ext_manager();
		
		$GLOBALS['log']->debug("dialed user info  => ");
		$GLOBALS['log']->debug(print_r($user_array,1));
		
		$recording_config = ($ext_bean->recording_config == '1')? "true" : "false";
		$recording_msg_config = ($ext_bean->recording_msg_config == '1')? true : false;
		$simultaneous_dialing_config = ($ext_bean->simultaneous_dialing_config == '1')? true : false;
		
		header("Content-Type: text/xml");
		$data = "<?xml version='1.0' encoding='UTF-8'?>";	
		$data .= "<Response>";
		if($recording_msg_config == true)
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >You are connecting to operator. Your call, may be recorded.</Say>";
		}	
			
		/*if simultaneous_dialing is enabled then allow to dial multiple destination numbers */
		if($user_array['voip_access'] == "inbound" OR $user_array['voip_access'] == "both")
		{		
			$GLOBALS['log']->debug("voip_access case dialing operator =>");
			$data .= "<Dial record='".$recording_config."' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=inbound_call_recording'>";			
			
			if($simultaneous_dialing_config == true)
			{			
				if($user_array['allow_phone_mobile'] == '1' AND !empty($user_array['phone_mobile']))
				{		
					$formatted_phone_mobile = process_number($user_array['phone_mobile']);
					if($formatted_phone_mobile != "false")
					{
						$data .= "<Number>";
						$data .= $formatted_phone_mobile;
						$data .= "</Number>";		
					}	
				}
				if($user_array['allow_phone_work'] == '1' AND !empty($user_array['phone_work']))
				{	
					$formatted_phone_work = process_number($user_array['phone_work']);
					if($formatted_phone_work != "false")
					{
						$data .= "<Number>";
						$data .= $formatted_phone_work;
						$data .= "</Number>";		
					}	
				}
				if($user_array['allow_phone_home'] == '1' AND !empty($user_array['phone_home']))
				{	
					$formatted_phone_home = process_number($user_array['phone_home']);
					if($formatted_phone_home != "false")
					{		
						$data .= "<Number>";
						$data .= $formatted_phone_home;
						$data .= "</Number>";		
					}	
				}
				if($user_array['allow_phone_other'] == '1' AND !empty($user_array['phone_other']))
				{	
					$formatted_phone_other = process_number($user_array['phone_other']);
					if($formatted_phone_other != "false")
					{		
						$data .= "<Number>";
						$data .= $formatted_phone_other;
						$data .= "</Number>";		
					}	
				}
				if($user_array['allow_browser'] == '1' OR $user_array['allow_browser'] == '0')
				{			
					$data .= "<Client>";
					$data .= $user_name;
					$data .= "</Client>";
				}
			}
			else
			{
				if($user_array['allow_browser'] == '1')
				{			
					$data .= "<Client>";
					$data .= $user_name;
					$data .= "</Client>";
				}				
			}
			
			$data .= "</Dial>";
		}
		
		$data .= "</Response>";		
		print $data;
		
			$GLOBALS['log']->debug("simultaneous dialing XML => ");
			$GLOBALS['log']->debug(print_r($data,1));
		
	}
	
	/*
	*	this will provide TwiML instructions to inform caller that callee is busy now
	*/
	function dial_busy()
	{
		$ext_bean = get_ext_manager();
		
		/*if voice mail transcription is enabled for Outbound call then use lower settings */
		$voice_mail_inbound_call_config = ($ext_bean->voice_mail_inbound_call_config == '1')? 'true' : 'false';		
		$beep_sound_config = ($ext_bean->beep_sound_config == '1')? 'true' : 'false';
		$silence_time_out = (!empty($ext_bean->silence_time_out))? $ext_bean->silence_time_out : 5;
		$finish_on_key = (!empty($ext_bean->finish_on_key))? $ext_bean->finish_on_key : '#';
		$recording_duration = (!empty($ext_bean->recording_duration))? $ext_bean->recording_duration : 30;
		
		//to do when all operators are busy and no one is available to handle call
		header("Content-Type:text/xml");
		$data = "<?xml version='1.0' encoding='UTF-8' ?>";
		$data .= "<Response>";
		
		if($ext_bean->call_waiting_config == "1")
		{		
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >All operators are busy.</Say>";		
			$data .= "<Pause />";			
			$data .= "<Gather timeout='10' numDigits='1' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=recording_voice_mail' >";

			if($voice_mail_inbound_call_config == 'true')
			{
				$data .= "<Say voice='".$ext_bean->ivr_voice."' >To record your message, Press 1.</Say>";
			}
			
			$data .= "<Say voice='".$ext_bean->ivr_voice."' loop='1'>To talk to operator, please wait.</Say>";
			$data .= "</Gather>";				
			$data .= "<Play>http://host2.rolustech.com/onholdmusic.mp3</Play>";
			$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessUserInput&amp;Digits=".$ext_bean->operator_dial_symbol."</Redirect>";
		}
		else
		{
			$data .= "<Reject reason='busy' />";
		}
		
		
			
		/* Here we will handle the voice mail or transcription */	
		/*if($voice_mail_inbound_call_config == 'true')
		{
			//$data .= "<Say voice='".$ext_bean->ivr_voice."' >All operators are busy.</Say>";		
			$data .= "<Pause />";
			if($beep_sound_config == 'true')
			{
				$data .= "<Say>Please leave a message at the beep. Press ".$finish_on_key." when finished.</Say>";
			}
			else
				$data .= "<Say>Please leave a message. Press ".$finish_on_key." when finished.</Say>";
				
			$data .= "<Record action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=inbound_call_recording' method='GET' playBeep='".$beep_sound_config."' timeout='".$silence_time_out."' maxLength='".$recording_duration."' finishOnKey='".$finish_on_key."' />";
			$data .= "<Say>I did not receive a recording</Say>";
		}*/		
		
		$data .= "</Response>";
		print $data;
		
		$GLOBALS['log']->debug("all operators are busy and initialize call waiting if enabled otherwise call ended");
		$GLOBALS['log']->debug(print_r($data,1));
		
	}
	
	/*
	*	this will provide support to let the one will enter one's desired extension to talk to specific party
	*/
	function process_extensions()
	{
		$ext_bean = get_ext_manager();
		
		$ext_time_out = !empty($ext_bean->ext_menu_gather_delay)? $ext_bean->ext_menu_gather_delay : 10; 
		$main_time_out = !empty($ext_bean->main_menu_gather_delay)? $ext_bean->main_menu_gather_delay : 10; 
		$loop = !empty($ext_bean->instructions_loop)? $ext_bean->instructions_loop : 1;	
		
		header("Content-Type: text/xml");
    	$data = "<?xml version='1.0' encoding='UTF-8'?>";	
		$data .= "<Response>";
		$data .= "<Gather timeout='".$ext_time_out."' numDigits='".$ext_bean->extension_digits."' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessExtensions' >";
		$data .= "<Pause />";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' loop='".$loop."'>Please, Enter your, desired extension.</Say>";
		$data .= "</Gather>";
		$data .= "<Gather timeout='".$main_time_out."' numDigits='1' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback' >";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' loop='1'>Press 0, to return to, main menu.</Say>";
		$data .= "</Gather>";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >Sorry, I didn't get your response.</Say>";		
		$data .= "<Redirect >".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessUserInput&amp;Digits=1</Redirect>";
		$data .= "</Response>";		
		print $data;
		
			$GLOBALS['log']->debug(print_r($data,1));
			
	}
	
	/*
	*	this will provide support to Caller to dial from the directory(dial the callee's name) in the organization 
	*/
	function process_directory()
	{
		$ext_bean = get_ext_manager();
		
		$ext_time_out = !empty($ext_bean->ext_menu_gather_delay)? $ext_bean->ext_menu_gather_delay : 10; 
		$main_time_out = !empty($ext_bean->main_menu_gather_delay)? $ext_bean->main_menu_gather_delay : 10; 
		$loop = !empty($ext_bean->instructions_loop)? $ext_bean->instructions_loop : 1;	
		
		header('Content-Type: text/xml');
		$data = "<?xml version='1.0' encoding='UTF-8' ?>";
		$data .="<Response>";
		$data .= "<Gather timeout='".$ext_time_out."' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessDirectory'>";
		$data .="<Say voice='".$ext_bean->ivr_voice."' loop='".$loop."'>Please, Enter the digits, that corresponds, your desired contact name. Then press Hash sign.</Say>";
		$data .= "</Gather>";
		$data .= "<Gather timeout='".$main_time_out."' numDigits='1' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback' >";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' loop='1'>Press 0, to return to, main menu.</Say>";
		$data .= "</Gather>";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >Sorry, I didn't get your response.</Say>";			
		$data .= "<Redirect >".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessUserInput&amp;Digits=2</Redirect>";
		$data .="</Response>";
		print $data;
		
			$GLOBALS['log']->debug(print_r($data,1));
			
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
		
			$GLOBALS['log']->debug(print_r($data,1));
			
	}
	
	/*
	*	this will process destination phone number in case of incoming call and format it according to specified country code
	*/
	function process_number($phone_number)
	{
			$formated_number ='';
			$original_number = $phone_number;
			$num_to_format = preg_replace('/[^0-9]/','',$phone_number);		
			
			if(substr($num_to_format,0,2) == "00") 
			{
				$formated_number = str_replace($num_to_format,"00","+");
				if(strlen($formated_number) < 8 || is_repeated_digit($formated_number)) ///check for invalid number
				{				
					$formated_number = 'false';
				}
			}
			else if(substr($original_number,0,1) == "+")
			{
				$formated_number = "+".$num_to_format;
				if(strlen($formated_number) < 8 || is_repeated_digit($formated_number))///check for invalid number(include alphabetical or alphanumerical phone number or single digit repeated phone number)
				{
					$formated_number = 'false';
				}
			}
			else
			{
				if(strlen($num_to_format) < 6 || is_repeated_digit($num_to_format))///check for invalid number
				{
					$formated_number = 'false';
				}
				else
				{
					require_once('modules/Administration/Administration.php');
					$admin = new Administration();
					$admin->retrieveSettings(); //will retrieve all settings from db
					$twilio_country_code = $admin->settings['MySettings_twilio_country_code'];
					
					$formated_number = $twilio_country_code.$num_to_format;									
				}
			}			
		return $formated_number;
	}

	/*
	*	this will check the repetition of the same digit in the phone number that was entered mistakenly
	*/	
	function is_repeated_digit($repeating_number)
	{
		$arr = '';
		//$arr = explode('',$repeating_number); //convert string to array doesn't support empty delimiter
		$arr = preg_split('//', $repeating_number, -1,PREG_SPLIT_NO_EMPTY);//convert string to array with empty delimiter 
		$arr_len = count($arr);
		$freq_of_num = 0;
		$rep_num ='';
		for($i=0; $i<$arr_len;$i++)
		{
			if($freq_of_num == 0)
			{
				$rep_num = $arr[$i];
				$freq_of_num++;
			}
			else if($freq_of_num >0)
			{
				if($arr[$i] == $rep_num)
				{
					$freq_of_num++;
				}
				$rep_num = $arr[$i];
			}
		}
		
		if($freq_of_num >= 6)
		{
			return true;        
		}
		else
		{
			return false;
		}
	}
?>
