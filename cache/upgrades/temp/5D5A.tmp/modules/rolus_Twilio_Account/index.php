<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $app_list_strings;
$obj = $this->bean;
$obj->retrieve('1');

if(empty($obj->id))
{
	$obj->id='1';
	$obj->new_with_id=true;
	$obj->name='Call Setting';
	$obj->save();
	$obj->retrieve('1');
}
	
	/*
	*	getting the dropdown's value from database's Config table and displaying on front end
	*/
	require_once('modules/Administration/Administration.php');
	$admin = new Administration();
	$admin->retrieveSettings(); //will retrieve all settings from db
	$twilio_country_code = $admin->settings['MySettings_twilio_country_code']; 
	
	$this->ss->assign('twilio_country_code', get_select_options($app_list_strings['twilio_country_code'],$twilio_country_code)); //get_select_options(dropdown name(present in app_list_strings),checked value)
	$this->ss->assign('bean',$obj);
	
	/*
	*	getting the twilio verified numbers from twilio and display them to end user
	*/
	require_once('modules/rolus_Twilio_Account/fetch_verified_numbers.php');
	$this->ss->assign('twilio_outbound_numbers',$twilio_outbound_numbers);
	
	/*
	*	getting the usage records of current account and display them to end user
	*/
	require_once('modules/rolus_Twilio_Account/fetch_usage_records.php');
	if(!empty($final_usage_all_categories) && is_array($final_usage_all_categories))
	{
		$final_usage_all_categories = array_reverse($final_usage_all_categories); //reversing  the array to prioritise particular resources
		$this->ss->assign('usage_records',$final_usage_all_categories);
	}
	if(isset($_REQUEST['start_date'])) // setting the entered dates range by the end user to UI
	{
		$this->ss->assign('start_date',$_REQUEST['start_date']);
		$this->ss->assign('end_date',$_REQUEST['end_date']);
	}
	
	$this->ss->display('modules/rolus_Twilio_Account/tpls/index.tpl');

?>
