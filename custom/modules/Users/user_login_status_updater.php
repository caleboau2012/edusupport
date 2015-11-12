<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
		
	/**
	*	this will update user login status flags in database on login and logout
	**/
	class User_Login_Status_Updater
	{
		// this will update the user logged_in to true
		function login_flag_updater(&$bean, $event, $arguments)
		{
			$logged_in_user_id = $bean->fetched_row['id'];		
			$sql = "update users set logged_in =1 where id='".$logged_in_user_id."'";
			$GLOBALS['db']->query($sql);		
			$GLOBALS['log']->debug("logged in User sql query =>".$sql);
			
		}
		// this will update the user logged_in to false
		function logout_flag_updater(&$bean, $event, $arguments)
		{
			$logged_in_user_id = $bean->fetched_row['id'];								
			$sql = "update users set logged_in =0,availability =0 where id='".$logged_in_user_id."'";
			$GLOBALS['db']->query($sql);	
			$GLOBALS['log']->debug("logged out User sql query =>".$sql);
		}
	}	
?>
