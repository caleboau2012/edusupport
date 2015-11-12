<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php		
	/**
	*	At first, this will restrict the incoming call's code to be run before the user is logged in successfully 
	*	Secondly, this will provide the environment to execute incoming calls
	**/
	class HandleIncomingCalls
	{
		function makeIncomingCalls($event, $arguments)
		{
			if(isset($_REQUEST['sugar_body_only']) && $_REQUEST['sugar_body_only']== true){
			
				return true;
			} 
			/*banned module for inobund call because of AJAXUI behavior*/
			$inbound_banned_modules = array("Emails","Calendar","Home","Administration","ModuleBuilder","Quotes");
			if(!in_array($_REQUEST['module'],$inbound_banned_modules))
			{
				//will execute only if user is logged in to system
				if($GLOBALS['current_user']->logged_in == "1")
				{
					require_once('custom/modules/Calls/IncomingCallConfig.php');	
				}
			}	
		} //function end
	}	
?>