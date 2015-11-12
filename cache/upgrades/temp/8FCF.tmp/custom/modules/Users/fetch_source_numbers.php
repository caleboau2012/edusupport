<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/**
	*	this will return the all available source numbers of currently 	
	*	logged in user to make available for selection w.r.t making out-bound-call
	**/
	global $current_user;
	global $db;
	
	//getting user's numbers for selecting as Source to make call
	$user_sql = "SELECT phone_home,phone_mobile,phone_work,phone_other FROM users WHERE id='".$current_user->id."' AND (phone_home IS NOT NULL AND phone_home !='' OR phone_mobile IS NOT NULL AND phone_mobile !='' OR phone_work IS NOT NULL AND phone_work !='' OR phone_other IS NOT NULL AND phone_other !='')";
	$user_result = $db->query($user_sql);
	if($db->getRowCount($user_result)>0)
	{
		$user_numbers = $db->fetchByAssoc($user_result);		
		$GLOBALS['log']->debug(print_r(json_encode($user_numbers),1));
		print_r(json_encode($user_numbers));		
		
		$GLOBALS['log']->debug("fetched source number array =>");
		$GLOBALS['log']->debug(print_r(json_encode($user_numbers),1));
	}
	else
	{
		$moduleName = 'rolus_Twilio_Account';
		$account_bean = BeanFactory::getBean($moduleName);
		$account_bean->retrieve('1');
		if(!empty($account_bean->phone_number))
		{
			$browser_source = array("source"=>"browser");
			print_r(json_encode($browser_source));
			
			$GLOBALS['log']->debug("fetched browser source (empty user source numbers) =>");
			$GLOBALS['log']->debug(print_r(json_encode($browser_source),1));
		}
		else
		{
			$empty_source = array("source"=>"false");
			print_r(json_encode($empty_source));
			
			$GLOBALS['log']->debug("fetched empty source(call account phone number is missing) =>");
			$GLOBALS['log']->debug(print_r(json_encode($empty_source),1));
		}		
	}		
	exit;
?>