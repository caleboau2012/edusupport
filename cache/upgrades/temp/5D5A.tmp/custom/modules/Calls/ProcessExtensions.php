<?php
	/*
	*	this will handle the Dialed Extensions and transfer call control
	*	towards the dialed extension
	*/
	
		$GLOBALS['log']->debug("Dialed Extensions Url's values => ");
		$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	
	error_reporting(0);
	
	//$user_extension = $_REQUEST['Digits'];//gathering user input during call
	if(isset($_REQUEST['Digits']) AND !empty($_REQUEST['Digits']))
	{		
		$_SESSION['user_extension'] = $_REQUEST['Digits'];//gathering user input during call		
	}
	else if(!empty($_REQUEST['user_extension']) AND ($_REQUEST['user_extension'] != 'false'))	// getting user_extension from the forwarded call url to dial to desired extension user
	{			
		$_SESSION['user_extension'] = $_REQUEST['user_extension'];		
	}
	
	/* here request values may come from digits, from operator forwarding */
	//if($_REQUEST['user_extension'] == 'false' OR $_REQUEST['user_extension'] == $_SESSION['user_extension'])
	if(isset($_REQUEST['user_extension']) AND $_REQUEST['user_extension'] == 'false')
	{		
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{			
			$user_name = $_SESSION['username'];			
		}
		elseif(!empty($_REQUEST['user_name']))
		{			
			$_SESSION['username'] = $_REQUEST['user_name'];
			$user_name = $_SESSION['username'];			
		}
	}
	else /* here user_extension may come from session when extension holder is busy */
	{
		$user_extension = $_SESSION['user_extension'];
		$user_name = get_extension_holder($user_extension);
	}
	
	if(!empty($user_name))
	{			
		talk_to_extension($user_name);
	}	
	else //when caller selects wrong option from the menu
	{
		redirect_main_menu();			
	}
		
	/*
	*	this will return the Extension bean Object to manipulate with different database fields
	*	for the dynamic configuration of the TwiML for incoming call
	*/
	function get_ext_manager()
	{
		$moduleName = "rolus_Twilio_Extension_Manager";
		$ext_bean = BeanFactory::getBean($moduleName);
		$ext_bean->retrieve('1');
		return $ext_bean;
	}
	
	/*
	*	this will return the user_name of the User having the dialed extension
	*/
	function get_extension_holder($user_extension)
	{
		$user_name = '';
		$sql = "SELECT user_name FROM users WHERE extension='".$user_extension."'";
		$result = $GLOBALS['db']->query($sql);
		if($GLOBALS['db']->getRowCount($result)>0)
		{
			$row = $GLOBALS['db']->fetchByAssoc($result);
			$user_name = $row['user_name'];
		}
		return $user_name;
	}
	
	/*
	*	this will take the caller party to the main manu, because he/she has not entered any valid input
	*/
	function redirect_main_menu()
	{
		$ext_bean = get_ext_manager();
		
		header("Content-Type: text/xml");
		$data = "<?xml version='1.0' encoding='UTF-8'?>";	
		$data .= "<Response>";
		$data .= "<Pause />";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >Sorry, the dialed extension, is not available. Goodbye!</Say>";
		$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback</Redirect>";
		$data .= "</Response>";		
		print $data;
		
			$GLOBALS['log']->debug(print_r($data,1));
			
	}
	
	/*
	*	this will provide support to let the incoming call will connect to the entered extension
	*/
	function talk_to_extension($user_name)
	{
		$sql = "SELECT * from users WHERE logged_in=1 AND availability=0 AND user_name='".$user_name."'";
				
		$result = $GLOBALS['db']->query($sql);
		$user_array = $GLOBALS['db']->fetchByAssoc($result); 
		
			$GLOBALS['log']->debug("returned user row talk_to_extension SQL values => ");
			$GLOBALS['log']->debug(print_r($user_array,1));
		
		
		if(!empty($result->num_rows)) // means when any operator is available to attend call(connect incoming call to this operator)
		{
			dial_agent($user_array['user_name'],$user_array);
		}
		else 		
		{
			dial_busy();
		}		
	}
	
	/*
	*	this will provide TwiML to dial the caller's desired agent
	*/
	function dial_agent($user_name,$user_array = NULL)
	{		
		$GLOBALS['log']->debug("dialed user info  => ");
		$GLOBALS['log']->debug(print_r($user_array,1));
		
		$ext_bean = get_ext_manager();
		
		$recording_config = ($ext_bean->recording_config == '1')? true : false;
		$recording_msg_config = ($ext_bean->recording_msg_config == '1')? true : false;
		$simultaneous_dialing_config = ($ext_bean->simultaneous_dialing_config == '1')? true : false;
		
		header("Content-Type: text/xml");
		$data = "<?xml version='1.0' encoding='UTF-8'?>";	
		$data .= "<Response>";
		$data .= "<Pause />";
		if($recording_msg_config == true)
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >You are connecting to agent. Your call, may be recorded.</Say>";
		}	
		
		/*if simultaneous_dialing is enabled then allow to dial multiple destination numbers */
		if($user_array['voip_access'] == "inbound" OR $user_array['voip_access'] == "both")
		{			
			$data .= "<Dial record='".$recording_config."' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=inbound_call_recording' >";			
			
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
		
			$GLOBALS['log']->debug("Dialing the extension holder");
			$GLOBALS['log']->debug(print_r($data,1));
			
	}
	
	/*
	*	this will provide the TwiML instructions to inform caller that the callee is busy now
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
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >The user is busy.</Say>";
			$data .= "<Pause />";
			
			$data .= "<Gather timeout='15' numDigits='1' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=recording_voice_mail' >";
			
			if($voice_mail_inbound_call_config == 'true')
			{
				$data .= "<Say voice='".$ext_bean->ivr_voice."' >To record your message, Press 1.</Say>";
			}
			
			$data .= "<Say voice='".$ext_bean->ivr_voice."' loop='1'>To talk to agent, please wait.</Say>";
			$data .= "</Gather>";	
			
			$data .= "<Play>http://host2.rolustech.com/onholdmusic.mp3</Play>";
			$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessExtensions&amp;user_extension=".$_SESSION['user_extension']."</Redirect>";
		}		
		else
		{
			$data .= "<Reject reason='busy' />";
		}
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