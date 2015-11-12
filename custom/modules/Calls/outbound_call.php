<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/**
	*	this will make a sugar call to keep track of the outbound call(phone-to-phone & browser-to-phone) for logging in db
	*	moreover, this will also update outbound(phone & browser) call status to db
	**/
	
	$GLOBALS['log']->debug("initial outbound (browser & phone) call status");
	$GLOBALS['log']->debug(print_r($_REQUEST,1));

	/* global $current_user;
	$moduleName = "Calls";
	$call_bean = BeanFactory::getBean($moduleName);
	$current_date = date("Y-m-d H:i:s",time()); //current date n time */
		
	if(!empty($_REQUEST['call_status']))
	{
		update_browser_outbound($_REQUEST['call_status']);
	}
	if(!empty($_REQUEST['call_sid']))
	{
		update_phone_outbound($_REQUEST['call_sid']);
	}
	
	/*
	*	this will first make sugar call to Calls module to initiate Calls to return Ref Call Id to client to 
	*	keep track of the outbound call for logging 
	*	secondly , this will update call statuses(as ringing , established, cancelled, rejected, Held)
	*	whenever call status changes.
	*/
	function update_browser_outbound($call_status)
	{
		global $current_user;
		
		$GLOBALS['log']->debug("related module => ".$_REQUEST['RelatedModule']);
		
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);
	
		$current_date = gmdate("Y-m-d H:i:s",time()); //current date n time		
		if($call_status == "dialing")
		{
			$_POST['name'] = "Outbound, ".$current_user->last_name;
			$_POST['duration_hours'] = 00;			
			$_POST['date_start'] = $current_date;
			$_POST['parent_type'] = $_REQUEST['RelatedModule'];
			$_POST['status'] = $call_status;
			$_POST['direction'] = "Outbound";
			$_POST['parent_id'] = $_REQUEST['RelatedId'];			
			$_POST['source'] = $_REQUEST['source'].":".$GLOBALS['current_user']->user_name;
			$_POST['destination'] = $_REQUEST['destination'];
			$_POST['assigned_user_id'] = $current_user->id;
			require_once('modules/Calls/CallFormBase.php');
			$formBase = new CallFormBase();
			$call_bean = $formBase->handleSave('', false, false);
			$sugar_call_id = $call_bean->id;
			
			//adding entry in relationship table (for dealing with relationship, first load_relationship then manipulate with that add/delete)
			if($_REQUEST['RelatedModule'] == 'Contacts')
			{
				$call_bean->load_relationship('contacts');
				$call_bean->contacts->add($_REQUEST['RelatedId']);
			}
			else if($_REQUEST['RelatedModule'] == 'Leads')
			{
				$call_bean->load_relationship('leads');
				$call_bean->leads->add($_REQUEST['RelatedId']);
			}
			else if($_REQUEST['RelatedModule'] == 'Users')
			{
				$call_bean->load_relationship('users');
				$call_bean->users->add($_REQUEST['RelatedId']);
			}
			print_r($sugar_call_id);
		}
		else if($call_status == "dialed") //when call is established
		{
			$call_bean->retrieve($_REQUEST['RefCallId']);
			$call_sid = $call_bean->twilio_call_id; //getting the twilio call id of the current call to use later on according to requirements
			
				$GLOBALS['log']->debug("getting twilio_call_id from DB =>".$call_sid);	
			
			$call_bean->status = $call_status;
			$call_bean->save();
			
			print_r($call_sid);
		}
		else if($call_status == "Held" OR $call_status == "canceled")
		{							
			$call_bean->retrieve($_REQUEST['RefCallId']);				
			$call_bean->status = $call_status;
			$call_bean->save();
			print_r($call_status);
		}			
	}
	
	/*
	*	this will update the call status Held between two traditional phones to established
	*/
	function update_phone_outbound($call_id)
	{
		global $current_user;
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);
		$current_date = gmdate("Y-m-d H:i:s",time()); //current date n time
				
		$ref_id = $_REQUEST['RefCallId'];
		$call_bean->retrieve($ref_id);
		$call_bean->date_start = $current_date;
		$call_bean->parent_type = $_REQUEST['RelatedModule'];		
		$call_bean->parent_id = $_REQUEST['RelatedId'];
		$call_bean->twilio_call_id = $call_id;
		$call_bean->save();
		print("call_initiated");	
	}
?>