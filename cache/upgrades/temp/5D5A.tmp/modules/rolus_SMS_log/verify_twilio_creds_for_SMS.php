<?php
	/*
	*	this will make request to twilio server to verify twilio account credentials as well as
	*	the application sid that will be used  for making Outbound Call later on 
	*	Moreover, this will also handle the twilio server's unavailability
	*/


	$GLOBALS['log']->debug("twilio credentials verification for sending mass sms =>");
	
	require_once('modules/rolus_Twilio_Account/rolus_Twilio_Account.php');
	$rolus_Twilio_Account = new rolus_Twilio_Account();
	
	$twilio_creds = ''; // will contain the twilio credentials verification response result 
	$source_phone_number = ''; //source number that will be used for sms campaigns
	$Twilio_Response = ''; // this will contain the twilio response against each REST request to twilio
	try{
		$client = $rolus_Twilio_Account->getClient();
		if(!(is_object($client) && $client instanceof Services_Twilio))
				throw new settingsException('Cannot connect to Twilio','3');	
			
			$moduleName = 'rolus_Twilio_Account';
			$account_bean = BeanFactory::getBean($moduleName);
			
			$account_bean->retrieve('1');
			$account_sid = $account_bean->user_name;
			$auth_token = $account_bean->pass;		
			$source_phone_number = $account_bean->phone_number; // soruce number that will be used for sms campaigns
			
			$GLOBALS['log']->debug('Twilio Account Sid :: '.$account_sid);
			$GLOBALS['log']->debug('Twilio Auth Token :: '.$auth_token);
			$GLOBALS['log']->debug('Twilio Account Phone Number or Source Number :: '.$source_phone_number);
			
			/*requesting twilio for sms account verificatoin */
			$Twilio_Response = $client->verify_twilio_creds($account_sid,$auth_token);
			
			/* SMS Account Credentials are verified and server is unavailable and return 503 HttpStatus*/
			if($Twilio_Response->HttpStatus == 503 AND $Twilio_Response->IsError == 1)
			{
				$twilio_creds = "Twilio Server is temporarily unavailable, Please try later";
			}
			/* SMS Account Credentials are verified and invalid and return 401 HttpStatus and Error code*/
			elseif($Twilio_Response->HttpStatus == 401 AND $Twilio_Response->IsError == 1)
			{				
				$twilio_creds = "Call Account Settings are Invalid or missing";	
			}
			/* SMS Account Credentials are verified and correct and return 200 HttpStatus*/
			elseif($Twilio_Response->HttpStatus == 200 AND empty($Twilio_Response->IsError))
			{
				$twilio_creds = 'true';	
				
				$Twilio_Response = $client->verify_source_number();
				
				$GLOBALS['log']->debug("twilio Inbound source numbers Reponse =>");
				$GLOBALS['log']->debug(print_r($Twilio_Response,1));				
			}
		
			$GLOBALS['log']->debug("twilio credentials verification =>");
			$GLOBALS['log']->debug(print_r(json_encode(array("twilio_creds"=>$twilio_creds)),1));
					
	} catch (communicaitonException $e) {
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}	
?>