<?php
	/*
	*	this will make request to twilio server to verify a number for making outbound calls
	* 	and return verification code to user to enter verification code when his/her phone will ring
	*/


	$GLOBALS['log']->debug("phone verification url values =>");
	$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	/*$target_module = 'rolus_Twilio_Account';
	$class = $GLOBALS['beanList'][$target_module];
	require_once($GLOBALS['beanFiles'][$class]);
	$rolus_Twilio_Account = new $class();*/
	
	require_once('modules/rolus_Twilio_Account/rolus_Twilio_Account.php');
	$rolus_Twilio_Account = new rolus_Twilio_Account();
	
	$verifiable_phone_number = $_REQUEST['phone_number_to_verify'];
	
	try{
		$client = $rolus_Twilio_Account->getClient();
		if(!(is_object($client) && $client instanceof Services_Twilio))
				throw new settingsException('Cannot connect to Twilio','3');	
		try
		{			
			$GLOBALS['log']->debug("verifiable_phone_number => ");
			$GLOBALS['log']->debug(print_r(json_encode($verifiable_phone_number),1));
				
			$caller_id_resource = $client->account->outgoing_caller_ids->create($verifiable_phone_number);
			$GLOBALS['log']->debug("outbound calller id or phone number object => ");			
			$GLOBALS['log']->debug(print_r($caller_id_resource,1));	
		
		}
		catch(Services_Twilio_RestException $e)
		{	
			print_r("Phone Number is already verified !");
		}		
			
		if(isset($caller_id_resource) AND !empty($caller_id_resource))	
		{
			$caller_id_array = get_array_from_caller_id_resource($caller_id_resource);//returns array extracting relevant properties from caller id resoruce

			$GLOBALS['log']->debug("outbound calller id or phone number object => ");
			$GLOBALS['log']->debug(print_r(json_encode($caller_id_array),1));
			
			print_r(json_encode($caller_id_array));die;			
		}		
	} catch (communicaitonException $e) {
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}
	
	/*
	*	this will take twilio caller id resource as a parameter and return caller id array having relevant properties of twilio caller id resoruce
	*/
	function get_array_from_caller_id_resource($caller_id)
	{		
		$caller_id_array['phone_number'] = (array)$caller_id->phone_number;
		$caller_id_array['validation_code'] = (array) $caller_id->validation_code;
		$caller_id_array['call_sid'] = (array)$caller_id->call_sid;
				
		return $caller_id_array;
	}
	
	/*
	*	this will save call record as Number Verification Call,call sid to track verification call in future 
	*/
	/*function save_call_progress($verification_call_sid,$verifying_phone_number)
	{	
		global $current_user;
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);
		$current_date = date("Y-m-d H:i:s",time()); //current date n time
		
		$call_bean->name="Number Verification Call, ".$current_user->last_name;
		$call_bean->duration_hours = 00;
		$call_bean->date_start = $current_date;
		$call_bean->parent_type = "Users";
		$call_bean->direction = "Inbound";
		$call_bean->parent_id = $current_user->id;
		$call_bean->twilio_call_id = $verification_call_sid;
		$call_bean->source = "twilio";
		$call_bean->destination = $verifying_phone_number;
		$call_bean->save();

		$GLOBALS['log']->debug("<=>verification call object=>");
		$GLOBALS['log']->debug(print_r($call_bean,1));
		
		return true;
	}*/
	
exit;	
?>