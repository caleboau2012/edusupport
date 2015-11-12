<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
?>
<?php
	/*
	*	This will be responsible to fetch all the twilio verified outbound phone numbers related to particular Account
	* 	if exists in verified numbers portion of a particular Account
	*/

	/*$target_module = 'rolus_Twilio_Account';
	$class = $GLOBALS['beanList'][$target_module];
	require_once($GLOBALS['beanFiles'][$class]);
	$rolus_Twilio_Account = new $class();*/
	
	require_once('modules/rolus_Twilio_Account/rolus_Twilio_Account.php');
	$rolus_Twilio_Account = new rolus_Twilio_Account();
	
	$twilio_outbound_numbers_response = ''; // it will contain the all outbound numbers resource fetched from twilio 
	$twilio_outbound_numbers_array = ''; // it will contain all twilio verified numbers array 
	$twilio_outbound_numbers = ''; // it will contain the required attributes to be displayed in tpl
	try{
		$client = $rolus_Twilio_Account->getClient();
		if(!(is_object($client) && $client instanceof Services_Twilio))
				throw new settingsException('Cannot connect to Twilio','3');
		//getting outbound verified numbers from twilio
		$count=0;

			
		foreach ($client->account->outgoing_caller_ids as $caller_id) 
		{			
			$twilio_outbound_numbers[$count]['Phone_Number'] = $caller_id->phone_number;
			$twilio_outbound_numbers[$count]['Formatted_Number'] = $caller_id->friendly_name;
			$twilio_outbound_numbers[$count]['DateCreated'] = $caller_id->date_created;
			$count++;
		}			
		$GLOBALS['log']->debug("All Twilio Verified Outbound Numbers => ");
		$GLOBALS['log']->debug(print_r($twilio_outbound_numbers,1));
	} catch (communicaitonException $e) {
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}	
?>