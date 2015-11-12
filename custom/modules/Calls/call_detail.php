<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/**
	*  this will return the call detail to the user by the call back being gotten from twilio server when call ends
	*
	**/
	global $db;
	$current_date = date("Y-m-d H-i-s",time());
	if(!empty($_REQUEST['call_id']))
	{
		if($_REQUEST['fetch'] == "call_detail")
		{
			$sql = "SELECT id,twilio_call_id FROM calls WHERE twilio_call_id='".$_REQUEST['call_id']."'";
			$result = $db->query($sql);
		
			if($db->getRowCount($result)>0)
			{
				$call_detail = $db->fetchByAssoc($result);//return associative array 
				print_r(json_encode($call_detail));//convert associative array into object
				
				$GLOBALS['log']->debug(print_r($call_detail,1));				
			}	
		}
	}
	exit;
	
?>