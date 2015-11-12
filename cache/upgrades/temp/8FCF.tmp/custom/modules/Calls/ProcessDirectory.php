<?php
	/*
	*	this will process the user's entered directory digits
	*	and will evaluate that digits by mapping with the user's (first_name::last_name)
	*	if no match found then evaluate the digits by mapping the user's last_name only
	*	if match is found in either case, then check that the particular user is available or not
	*	if available then incoming call is transferred to that user
	*	if not available then there will be a busy signal
	*	On the other hand if no match is found, then incoming call is redirected to main Menu 
	*/
	
	
	$GLOBALS['log']->debug("Process Directory's Request values");
	$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	
	error_reporting(0);
	
	if(isset($_REQUEST['Digits']) AND !empty($_REQUEST['Digits']))
	{
		$_SESSION['caller_digits'] = $_REQUEST['Digits']; //getting the caller's entered digits to map to callee's name
	}	
	$caller_digits = $_SESSION['caller_digits'];
	
	if(!empty($caller_digits)) //if caller has not entered any digits but hash sign only 
	{
		dial_directory_user($caller_digits);	
	}
	else
	{
		redirect_main_menu();
	}
	
	/*
	*	if caller has entered digits that will need to map to dial the desired contact
	*	then this will evalute that digits and then try to locate all possible contacts related to digits
	*	it will provide the availability of max of seven possible contacts to caller,
	*	IVR will announce all that contacts to caller to facilitate her/him to dial the choosen one
	*	if that will be available otherwise this will return the busy status
	*/
	function dial_directory_user($caller_digits)
	{
		require_once('custom/modules/Calls/DialDirectoryUser.php');
		
		if(!empty($users_for_say))
		{
			dial_contact($users_for_say);
		}
		else if($_SESSION['user_state'] != 'busy')
		{
			redirect_main_menu();
		}	
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
	*	this will dial the matched directory user(contact) that was filtered out 
	*	against dialing callee from directory
	*/
	function dial_contact($users_for_say)
	{
		$ext_bean = get_ext_manager();
		
		$main_time_out = !empty($ext_bean->main_menu_gather_delay)? $ext_bean->main_menu_gather_delay : 10; 
		$loop = !empty($ext_bean->instructions_loop)? $ext_bean->instructions_loop : 1;	
		
		header("Content-Type: text/xml");
		
		$data = "<?xml version='1.0' encoding='UTF-8'?>";	
		$data .= "<Response>";
		$data .= "<Pause />";		
		$data .= "<Say voice='".$ext_bean->ivr_voice."' loop='".$loop."'>Please wait, while system is exploring the phone directory.</Say>";		
		
		$data .= "<Gather timeout='100' numDigits='1' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=TalkToDirectoryAgent'>";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >Please, choose your desired agent, from  this menu, by pressing the corresponding digits for that.</Say>";
		if(array_key_exists(0,$users_for_say) != FALSE)		
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk to, ".$users_for_say[0]['speaking_name'].", Press 1 </Say>";
			$_SESSION['one'] = array('id'=>$users_for_say[0]['id'],'user_name'=>$users_for_say[0]['user_name']); //placing directory user info in SESSION array to get on the redirected page to make call to
			$data .= "<Pause />";
		}	
		if(array_key_exists(1,$users_for_say) != FALSE)		
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk to, ".$users_for_say[1]['speaking_name'].", Press 2 </Say>";
			$_SESSION['two'] = array('id'=>$users_for_say[1]['id'],'user_name'=>$users_for_say[1]['user_name']); //placing directory user info in SESSION array to get on the redirected page to make call to
			$data .= "<Pause />";
		}
		if(array_key_exists(2,$users_for_say) != FALSE)		
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk to, ".$users_for_say[2]['speaking_name'].", Press 3 </Say>";
			$_SESSION['three'] = array('id'=>$users_for_say[2]['id'],'user_name'=>$users_for_say[2]['user_name']); //placing directory user info in SESSION array to get on the redirected page to make call to
			$data .= "<Pause />";
		}
		if(array_key_exists(3,$users_for_say) != FALSE)		
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk to, ".$users_for_say[3]['speaking_name'].", Press 4 </Say>";
			$_SESSION['four'] = array('id'=>$users_for_say[3]['id'],'user_name'=>$users_for_say[3]['user_name']); //placing directory user info in SESSION array to get on the redirected page to make call to
			$data .= "<Pause />";
		}
		if(array_key_exists(4,$users_for_say) != FALSE)		
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk to, ".$users_for_say[4]['speaking_name'].", Press 5 </Say>";
			$_SESSION['five'] = array('id'=>$users_for_say[4]['id'],'user_name'=>$users_for_say[4]['user_name']); //placing directory user info in SESSION array to get on the redirected page to make call to
			$data .= "<Pause />";
		}
		if(array_key_exists(5,$users_for_say) != FALSE)		
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk to, ".$users_for_say[5]['speaking_name'].", Press 6 </Say>";
			$_SESSION['six'] = array('id'=>$users_for_say[5]['id'],'user_name'=>$users_for_say[5]['user_name']); //placing directory user info in SESSION array to get on the redirected page to make call to
			$data .= "<Pause />";
		}
		if(array_key_exists(6,$users_for_say) != FALSE)		
		{
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk to, ".$users_for_say[6]['speaking_name'].", Press 7 </Say>";
			$_SESSION['seven'] = array('id'=>$users_for_say[6]['id'],'user_name'=>$users_for_say[6]['user_name']); //placing directory user info in SESSION array to get on the redirected page to make call to
			$data .= "<Pause />";
		}
		
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >To go to Previous Menu, Press 8 </Say>";
		$data .= "<Pause />";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >To go to Main Menu, Press 9 </Say>";
		$data .= "<Pause />";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >To Talk to Operator, Press ".$ext_bean->operator_dial_symbol." </Say>";
		$data .= "<Pause />";				
		$data .= "</Gather>";
		
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >Sorry! I did not get your response.</Say>";
		$data .= "<Pause />";					
		$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback</Redirect>";
		$data .= "</Response>";		
		print_r($data);
		
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
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >The user is busy, please wait.</Say>";
			$data .= "<Pause />";
			
			$data .= "<Gather timeout='10' numDigits='1' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=recording_voice_mail' >";
			
			if($voice_mail_inbound_call_config == 'true')
			{
				$data .= "<Say voice='".$ext_bean->ivr_voice."' >To record your message, Press 1.</Say>";
			}
			
			$data .= "<Say voice='".$ext_bean->ivr_voice."' loop='1'>To talk to agent, please wait.</Say>";
			$data .= "</Gather>";	
			
			$data .= "<Play>http://host2.rolustech.com/onholdmusic.mp3</Play>";
			$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessDirectory</Redirect>";
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
	*	if caller has not entered any digit to dial to specific contact name then
	*	this will redirect the caller to main menu
	*/
	function redirect_main_menu()
	{
		$ext_bean = get_ext_manager();
		
		header('Content-Type: text/xml');
		$data = "<?xml version='1.0' encoding='UTF-8' ?>";
		$data .="<Response>";
		$data .= "<Say voice='".$ext_bean->ivr_voice."' >Sorry, The entered digits could not dial your desired name, Good bye!</Say>";
		$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback</Redirect>";
		$data .="</Response>";
		print $data;
		
		$GLOBALS['log']->debug(print_r($data,1));
		
	}
?>