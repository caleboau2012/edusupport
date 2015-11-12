<?php
	if(!defined('sugarEntry') || !sugarEntry) die("Not A Valid Entry Point");	
?>
<?php
	/**
	*  this will return the detail of the Contact(caller) after searching from Sugar's modules 
	*	like Contacts, Accounts, Leads, Users and from any custom module if exists in Sugar
	**/
	
	if(!empty($_REQUEST['format_simple']))
	{ 
		$contact_info = array();//this will contain the contact detail values for callee to view details of the sugar contact
		$formatted_numbers = array();
		$formatted_numbers['format_zero'] = $_REQUEST['format_zero'];
		$formatted_numbers['format_simple'] = $_REQUEST['format_simple'];
		$formatted_numbers['format_international'] = $_REQUEST['format_international'];
		$formatted_numbers['format_local'] = $_REQUEST['format_local'];
		
		$contact_detail = get_contact_detail("contacts",$formatted_numbers);//return contact detail from Contacts module
		if(!empty($contact_detail))
		{
			$contact_info = $contact_detail;
		}

		$lead_detail = get_contact_detail("leads",$formatted_numbers);//return contact detail from Leads module
		if(!empty($lead_detail))
		{
			$contact_info = $lead_detail;
		}
		
		$user_detail = get_contact_detail("users",$formatted_numbers);//return contact detail from Users module
		if(!empty($user_detail))
		{
			$contact_info = $user_detail;
		}
		
		$account_detail = get_account_detail("accounts",$formatted_numbers);//return contact detail from Accounts module		
		if(!empty($account_detail))
		{
			$contact_info = $account_detail;
		}
		print_r(json_encode($contact_info));//displaying the contact detail in response of ajax call
		$GLOBALS['log']->debug("detailed contact information of the inbound caller if exist in Sugar system =>");
		$GLOBALS['log']->debug(print_r(json_encode($contact_info),1));
		exit;
	}
	
	/*
	*	this will return the contact detail if exist in Contacts/Leads/Users module
	*/
	function get_contact_detail($moduleName,$formatted_numbers)
	{
		$contact_info ='';
		$sql = "SELECT id,first_name,last_name 
				FROM ".$moduleName." 
				WHERE ((phone_work='".$formatted_numbers['format_zero']."' OR phone_work='".$formatted_numbers['format_simple']."' OR phone_work='".$formatted_numbers['format_international']."' OR phone_work='".$formatted_numbers['format_local']."')
				OR (phone_mobile='".$formatted_numbers['format_zero']."' OR phone_mobile='".$formatted_numbers['format_simple']."' OR phone_mobile='".$formatted_numbers['format_international']."' OR phone_mobile='".$formatted_numbers['format_local']."')
				OR (phone_home='".$formatted_numbers['format_zero']."' OR phone_home='".$formatted_numbers['format_simple']."' OR phone_home='".$formatted_numbers['format_international']."' OR phone_home='".$formatted_numbers['format_local']."'))
AND deleted=0";
		$result = $GLOBALS['db']->query($sql);
		if($GLOBALS['db']->getRowCount($result)>0)
		{
			$contact_info = $GLOBALS['db']->fetchByAssoc($result);
			$contact_info['moduleName'] = ucfirst($moduleName);
		}	
		return $contact_info;
	}
	
	/*
	*	this will return the contact detail if exist in Accounts module
	*/
	function get_account_detail($moduleName,$formatted_numbers)
	{
		$contact_info ='';
		$sql = "SELECT id,name as first_name
				FROM ".$moduleName." 
				WHERE ((phone_office='".$formatted_numbers['format_zero']."' OR phone_office='".$formatted_numbers['format_simple']."' OR phone_office='".$formatted_numbers['format_international']."' OR phone_office='".$formatted_numbers['format_local']."')
				OR (phone_alternate='".$formatted_numbers['format_zero']."' OR phone_alternate='".$formatted_numbers['format_simple']."' OR phone_alternate='".$formatted_numbers['format_international']."' OR phone_alternate='".$formatted_numbers['format_local']."'))
AND deleted=0";
		$result = $GLOBALS['db']->query($sql);
		if($GLOBALS['db']->getRowCount($result)>0)
		{
			$contact_info = $GLOBALS['db']->fetchByAssoc($result);
			$contact_info['last_name'] ='';
			$contact_info['moduleName'] = ucfirst($moduleName);
		}	
		return $contact_info;
	}
?>