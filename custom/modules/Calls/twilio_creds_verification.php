<?php
	/*
	*	this will make request to twilio server to verify twilio account credentials as well as
	*	the application sid that will be used  for making Outbound Call later on 
	*	Moreover, this will also handle the twilio server's unavailability
	*/
function verify_twilio_creds($account_sid , $auth_token, $client, $appsid=null){
	$url = 'https://' . $account_sid . ':' . $auth_token . '@api.twilio.com/'.$client->version.'/Accounts';
	$url .= ($appsid==null)?'':'/'.$account_sid . '/Applications/' . $appsid;
	$url .= (FALSE === strpos($url, '?')?"?":"&").'';
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
	$result = curl_exec($curl);
	$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	return $responseCode;
}
	$GLOBALS['log']->debug("twilio credentials verification =>");
	$GLOBALS['log']->debug(print_r($_REQUEST,1));
	
	require_once('modules/rolus_Twilio_Account/rolus_Twilio_Account.php');
	$rolus_Twilio_Account = new rolus_Twilio_Account();
	$rolus_Twilio_Account->retrieve('1');
	$twilio_creds = ''; // will contain the twilio credentials verification response result 
	$appsid = ''; // will contatin the appsid verification result

	try{
		$client = $rolus_Twilio_Account->getClient();
		$account_sid = $rolus_Twilio_Account->username;
		$auth_token = $rolus_Twilio_Account->pass;			
		$appsid = $rolus_Twilio_Account->appsid;
		if(!(is_object($client) && $client instanceof Services_Twilio))
				throw new settingsException('Cannot connect to Twilio','3');	
		$responseCode = verify_twilio_creds($account_sid , $auth_token, $client);

		/* Call Account Credentials are verified and server is unavailable and return 503 HttpStatus*/
		if($responseCode == 503)
		{
			$twilio_creds = "Twilio Server is temporarily unavailable, Please try later";
			$appsid = "Making Call is not allowed, because Twilio Server is down";
		}
		/* Call Account Credentials are verified and invalid and return 401 HttpStatus and Error code*/
		elseif($responseCode == 401)
		{
			$twilio_creds = "Call Account Settings are Invalid or missing";	
			$appsid = "Application Sid Settings are missing";
		}
		/* Call Account Credentials are verified and correct and return 200 HttpStatus*/
		elseif($responseCode == 200)
		{
			$twilio_creds = true;
			
			/* requesting twilio for the application sid, whether exists or not */
			$appsid_response = verify_twilio_creds($account_sid , $auth_token, $client, $appsid);	
			/* if application sid is present then OK else retuns error of application sid missing*/
			$appsid = ($appsid_response == 404) ? "Application Sid for making Call and SMS is Invalid or missing" : true;
							
		}
	
		$GLOBALS['log']->debug("twilio credentials verification =>");
		$GLOBALS['log']->debug(print_r(json_encode(array("twilio_creds"=>$twilio_creds,"appsid"=>$appsid)),1));
		print_r(json_encode(array("twilio_creds"=>$twilio_creds,"appsid"=>$appsid)));
			
		
	} catch (communicaitonException $e) {
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}	
exit;
?>