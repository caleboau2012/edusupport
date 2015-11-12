<?php

?>
<?php
	/*
	*	this will return all logged in users (both busy and available ) for operator
	*	to forward call to a particular logged in available user
	*/
	//$loggedin_users = array();	
	$target_module = 'rolus_Twilio_Extension_Manager';
	$ext_bean = BeanFactory::getBean($target_module);
	$ext_bean->retrieve('1');
	if($ext_bean->call_forwarding_config == '1' AND !empty($ext_bean->operator_name) AND $GLOBALS['current_user']->id == $ext_bean->operator_name)
	{				
		$sql = "SELECT id,user_name,extension,CONCAT('(',IFNULL(extension,''),')',IFNULL(first_name,' '),' ',last_name) AS ext_name,availability FROM users WHERE (logged_in =1 AND user_name !='".$GLOBALS['current_user']->user_name."') AND (voip_access='both' OR voip_access='inbound')";					
		$result = $GLOBALS['db']->query($sql);				
		
		if($GLOBALS['db']->getRowCount($result)>0)
		{
			$count_user = 0;
			while($loggedin_user = $GLOBALS['db']->fetchByAssoc($result))
			{
				$loggedin_users[$count_user] = $loggedin_user;
				$count_user++;
			}
		}  // end if users exist case
	}   // end if current logged_in user is operator					
	print_r(json_encode($loggedin_users));
	
	$GLOBALS['log']->debug("all logged in users capable to attend the forwarded call =>");
	$GLOBALS['log']->debug(print_r(json_encode($loggedin_users),1));

?>