<?php
  /**
  *  For Multiple Operators 
  *		this will provide the requested TwiML instructions to Twilio for making Incoming call,
  *		and will tackle multiple incoming call requests, fullfil by available online users(operators)
  *		otherwise this will give busy status
  *		This will also provide support to forward incoming call to desired possible extensions
  **/		
		error_reporting(0);
		
		$GLOBALS['log']->debug("twilio callback Request values => ");
		$GLOBALS['log']->debug(print_r($_REQUEST,1));
		
		$ext_bean = get_ext_manager();		
		
		if(isset($_REQUEST['SmsSid']) AND !empty($_REQUEST['SmsSid']))
		{
			handle_inbound_sms();	
		}
		else
		{
			if($ext_bean->ivr_config == "1")
			{
				dial_ivr();
			}
			else 
			{
				dial_agent();
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
		*	this will call when administrator has enabled IVR 
		*/
		function dial_ivr()
		{
			$ext_bean = get_ext_manager();
			
			$main_timeout = !empty($ext_bean->main_menu_gather_delay)? $ext_bean->main_menu_gather_delay : 10;
			
			header("Content-Type: text/xml");
			$data = "<?xml version='1.0' encoding='UTF-8'?>";	
			$data .= "<Response>";
			$data .= "<Gather timeout='".$main_timeout."' numDigits='1' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessUserInput'>";
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >".$ext_bean->welcome_message."</Say>";
			$data .= "<Pause />";
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >Please enter, your desired option, from this menu.</Say>";
			$data .= "<Pause />";			
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To dial, your desired extension. Press 1.</Say>";			
			$data .= "<Pause />";
			
			if($ext_bean->directory_config == "1")
			{
				$data .= "<Say voice='".$ext_bean->ivr_voice."' >To dial, from phone directory. Press 2.</Say>";			
				$data .= "<Pause />";
			}
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >To talk, to Operator. Press ".$ext_bean->operator_dial_symbol.".</Say>";
			$data .= "</Gather>";
			$data .= "<Say voice='".$ext_bean->ivr_voice."' >Sorry, I didn't get, your response.</Say>";
			$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback</Redirect>";
			$data .= "</Response>";		
			print $data;
		
			$GLOBALS['log']->debug(print_r($data,1));
		
		}
			
		/*
		*	this will call when administrator has disabled IVR 
		*/		
		function dial_agent()
		{
			$sql = "SELECT user_name from users WHERE logged_in=1 AND availability=0 LIMIT 1";
			$result = $GLOBALS['db']->query($sql);
			$row = $GLOBALS['db']->fetchByAssoc($result); 
			
				$GLOBALS['log']->debug("logged in and available users");
				$GLOBALS['log']->debug(print_r($row,1));
			
			
			if(!empty($result->num_rows)) // means when any operator is available to attend call(connect incoming call to this operator)
			{
				dial_operator($row['user_name']);
			}
			else 		
			{
				dial_busy();
			}
		}
		
		/*
		*	this will provide the required TwiML instructions to dial operator
		*/
		function dial_operator($user_name)
		{
			/*$ext_bean = get_ext_manager();
			
			$recording_config = ($ext_bean->recording_config == '1')? true : false;
			$recording_msg_config = ($ext_bean->recording_msg_config == '1')? true : false;*/
			
			header("Content-Type: text/xml");
			$data = "<?xml version='1.0' encoding='UTF-8'?>";	
			$data .= "<Response>";
			
			/*if($recording_msg_config == true)
			{
				$data .= "<Say voice='".$ext_bean->ivr_voice."' >You are connecting to operator. Your call, may be recorded.</Say>";
			}*/
				
			//$data .= "<Dial record='".$recording_config."' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=inbound_call_recording' >";
			$data .= "<Dial record='true' action='".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=inbound_call_recording' >";
			
			$data .= "<Client>";
			$data .= $user_name;
			$data .= "</Client>";
			
			$data .= "</Dial>";
			$data .= "</Response>";		
			print $data;
			
				$GLOBALS['log']->debug("simultaneous dialing => ");
				$GLOBALS['log']->debug(print_r($data,1));
				
		}
		
		/*
		*	this will provide TwiML instructions to inform caller that callee is busy now
		*/
		function dial_busy()
		{
			//to do when all operators are busy and no one is available to handle call
			header("Content-Type:text/xml");
			$data = "<?xml version='1.0' encoding='UTF-8' ?>";
			$data .= "<Response>";
			
			$data .= "<Say voice='man' >All operators are busy. Please wait.</Say>";						
			$data .= "<Play>http://host2.rolustech.com/onholdmusic.mp3</Play>";
			$data .= "<Redirect>".$GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=twilio_callback</Redirect>";
			
			$data .= "</Response>";
			print $data;
			
				$GLOBALS['log']->debug(print_r($data,1));
				
		}
		
		/*
		*	this will handle the inbound SMS reponse 
		*/
		function handle_inbound_sms()
		{
			header("Content-Type:text/xml");
			$data = "<?xml version='1.0' encoding='UTF-8' ?>";
			$data .= "<Response>";
			$data .= "</Response>";
			print $data;
			$GLOBALS['log']->debug(print_r($data,1));
		}
		
?>

