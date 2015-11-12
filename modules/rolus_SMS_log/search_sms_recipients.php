
<?php
	/**
	*  this will return the SMS Recipients present in Sugar's modules like
	*  Contacts,Leads,Accounts and Users from the Mobile number	
	*  to present the front end application in the form of Chat application	
	**/
	require_once('custom/include/twilio/Exceptions.php');
	global $db;
	
	if(!empty($_REQUEST['term']))
	{				
		

		$sql = "SELECT CONCAT( IFNULL( first_name,  ' ' ) ,' ', last_name ,'<',phone_mobile,'>' ) AS recipient FROM contacts WHERE IFNULL(first_name,last_name) LIKE '".$_REQUEST['term']."%' AND (phone_mobile IS NOT NULL AND phone_mobile<>'') LIMIT 10 
		        UNION ALL SELECT CONCAT( IFNULL( first_name,  ' ' ) ,' ', last_name ,'<',phone_mobile,'>' ) AS recipient FROM leads WHERE IFNULL(first_name,last_name) LIKE '".$_REQUEST['term']."%' AND (phone_mobile IS NOT NULL AND phone_mobile<>'') LIMIT 10
				UNION ALL SELECT CONCAT( IFNULL( first_name,  ' ' ) ,' ', last_name ,'<',phone_mobile,'>' ) AS recipient FROM users WHERE IFNULL(first_name,last_name) LIKE '".$_REQUEST['term']."%' AND (phone_mobile IS NOT NULL AND phone_mobile<>'') LIMIT 10 
			 	UNION ALL SELECT CONCAT( IFNULL( name,  ' ' ) ,'<',phone_office,'>' ) AS recipient FROM accounts WHERE IFNULL(name,name) LIKE '".$_REQUEST['term']."%' AND (phone_office IS NOT NULL AND phone_office<>'') AND deleted=0 LIMIT 10 
					  ";	

		$GLOBALS['log']->debug("mysql query =>".$sql);
		$GLOBALS['log']->fatal("mysql query =>".$sql);
		$result = $db->query($sql);
		
		$GLOBALS['log']->debug("mysql query result =>");
		$GLOBALS['log']->debug(print_r($result,1));
		try
		{
			if($db->getRowCount($result)>0)
			{
				$count = 0;
				while($recipient = $db->fetchByAssoc($result))
				{
					$recipients[$count] = html_entity_decode($recipient['recipient']);				
					$count++;
				}	
				
				$GLOBALS['log']->debug("searched recipients =>");
				$GLOBALS['log']->debug(print_r($recipients,1));
				
				$GLOBALS['log']->debug("searched recipients in json format =>");
				$GLOBALS['log']->debug(print_r(json_encode($recipients),1));
				
				print_r(json_encode($recipients));//convert associative array into object			
			}
		}
		catch (communicaitonException $e) {}							
	}
	exit;