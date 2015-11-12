<?php

class rolus_Twilio_AccountController extends SugarController
{
	/*
	*	this will save the default country code value in the Config database table to retrieve later on through Administrtion Object	
	*/
	function action_saveCountry(){
	
		require_once('modules/Administration/Administration.php');
		$admin = new Administration();

		$admin->saveSetting("MySettings", "twilio_country_code",$_REQUEST['twilio_country_code']); //$admin->saveSetting("category", "name", "value");
		//SugarApplication::redirect("index.php?module=Administration&action=index");  //using Sugar Redirect method
		SugarApplication::redirect("index.php?module=rolus_Twilio_Account");
	}
	
	/*
	*	this will save the password in encoded form for security purposes
	*/
   /* function pre_save()
    {
		parent::pre_save();
		if ($this->bean->pass == '**************************')
		{
			$this->bean->pass = $this->bean->fetched_row['pass'];
		}
		$this->bean->pass = blowfishEncode('TwilioAccount',$this->bean->pass);
    }*/
	
}
?>
