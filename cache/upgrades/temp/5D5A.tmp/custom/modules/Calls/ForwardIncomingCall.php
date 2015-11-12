<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/*
	*	this will get the currently Held incoming call by its CallSid and modify the call and redirect it to the desired party 
	*	to pick the call
	*/
	$GLOBALS['log']->debug("call forwarding file request values =>");
	$GLOBALS['log']->debug(print_r($_REQUEST,1));		
			
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
		
		if(isset($_REQUEST['user_extension']) AND !empty($_REQUEST['user_extension']))
		{				
			$user_extension = $_REQUEST['user_extension'];
			$caller_call_sid = $_REQUEST['call_sid']; 
			$user_name = $_REQUEST['available_user_name'];
			
			$call = $client->account->calls->get($caller_call_sid); 	
			
			$GLOBALS['log']->debug("browser callid's object");
			$GLOBALS['log']->debug(print_r($call,1));		
			/*
			*	here we will get parent call id of current call and modify call with parent call id and forward to new named client or user
			*/
			
			$url = $GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=ProcessExtensions&user_extension=".$user_extension."&user_name=".$user_name;
			
			$parent_call_id = (string)$call->parent_call_sid;			
			
			$to_number = (string)$call->to;
			
			$GLOBALS['log']->debug("parent callid's object to modify call =>");
			$GLOBALS['log']->debug(print_r($parent_call,1));		
			$parent_call = $client->account->calls->get($parent_call_id);
			$parent_modified_call = $parent_call->update(
					array(
						"Method"=>"POST",
						"Url"=>$url
					)); 
			
			if(isset($to_number))
			{
				print "forwarded";
			}
		}
		else
		{			
			$GLOBALS['log']->debug("no extension is received in Request from front end so unable to forward call =>");
			print "empty";
		}
	} catch (communicaitonException $e) {
		print $e->getMessage();
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		print $e->getMessage();
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		print $e->getMessage();
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}
	exit;
?>