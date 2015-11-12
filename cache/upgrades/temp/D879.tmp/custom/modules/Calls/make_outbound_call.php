<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/**
	*	this will actually make outbound call to the provided destination twilio(verified/registered)number
	*
	**/
	 ob_clean();

	$source = $_REQUEST['source'];
	
	$GLOBALS['log']->debug("source number =>".$_REQUEST['source']);
	
	$destination = $_REQUEST['destination'];
	
	$GLOBALS['log']->debug("destination number =>".$_REQUEST['destination']);
	
	$dest = urlencode($destination);
	$sourc = urlencode($source);
	$call_back_url = $GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=outbound_phone_callback&source=$sourc&dest=$dest";


	$GLOBALS['log']->debug("call_back_url =>".$call_back_url);	
	
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
	
		$call = $client->account->calls->create($source, $source, $call_back_url, array());
		$GLOBALS['log']->debug("make_call_initial_call_status => ");
		$GLOBALS['log']->debug(print_r(json_encode($call),1));
		$call_detail['ResponseXml']['Call']['Sid'] = $call->sid;
		print_r(json_encode($call_detail));
		
	} catch (communicaitonException $e) {
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		$call['ResponseXml']['RestException']['Code'] = $e->getCode();
		$call['ResponseXml']['RestException']['Message'] = $e->getMessage();
		print_r(json_encode($call));
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}	
	exit();	
?>