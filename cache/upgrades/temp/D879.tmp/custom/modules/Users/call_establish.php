<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php	
	/**
	* this will show the user status while connecting to call
	*/
	ob_clean();// to clean up the output buffer
	global $current_user;
	global $db;
	if(isset($_REQUEST['connect']))
	{
		if($_REQUEST['connect'] == 'true')
		{	
			$sql = "UPDATE users set availability=1 where id='".$current_user->id."'";
			$db->query($sql);
			print "true";	
			
			$GLOBALS['log']->debug("user availability status sql query busy case =>");
			$GLOBALS['log']->debug(print_r($sql,1));
		}
		elseif($_REQUEST['connect'] == 'false')
		{
			$sql = "UPDATE users set availability=0 where id='".$current_user->id."'";
			$db->query($sql);
			print "false";
			$GLOBALS['log']->debug("user availability status sql query available case =>");
			$GLOBALS['log']->debug(print_r($sql,1));
		}
	}
	exit;
?>