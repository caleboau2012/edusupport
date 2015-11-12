
<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/**
	*	this will tracke the incoming call and updating call status on every interval,whenever call status changes
	*
	**/
	
	/* implementing no record of incoming call when attended by operator */	
	
	/*$module_name = 'rolus_Twilio_Extension_Manager';
	$ext_bean = BeanFactory::getBean($module_name);
	if($GLOBALS['current_user']->id != $ext_bean->operator_name)
	{*/
		if(!empty($_REQUEST['call_status']) AND !empty($_REQUEST['call_id']))
		{
			status_updating($_REQUEST['call_status'],$_REQUEST['call_id']);
		}
	//}
		exit;
	
	// updating call status in the database	table
	function status_updating($call_status,$call_id)
	{
		global $current_user;
		global $db;
		$moduleName = "Calls";
		$call_bean = BeanFactory::getBean($moduleName);
		$current_date = gmdate("Y-m-d H:i:s",time()); //current date n time
		$call_bean->retrieve_by_string_fields(array(
			"twilio_call_id" => "$call_id"
		));
		if (empty($call_bean->id) && $call_status=="dialing") {
			$_POST['name']             = "Inbound, ".$current_user->last_name;
			$_POST['duration_hours']   = 00;
			$_POST['date_start']       = $current_date;
			$_POST['parent_type']      = $_REQUEST['RelatedModule'];
			$_POST['status']           = $call_status;
			$_POST['direction']        = "Inbound";
			$_POST['parent_id']        = $_REQUEST['RelatedId'];
			$_POST['twilio_call_id']   = $call_id;
			$_POST['source']           = $_REQUEST['source'];
			$_POST['destination']      = $_REQUEST['destination'];
			$_POST['assigned_user_id'] = $current_user->id;
			require_once('modules/Calls/CallFormBase.php');
			$formBase = new CallFormBase();
			$call_bean = $formBase->handleSave('', false, false);
			$GLOBALS['log']->fatal("<=>in dialing status=>");
			$GLOBALS['log']->fatal(print_r($call_bean->name, 1));
			die($call_bean->id);
			/*$call_bean->name="Inbound, ".$current_user->last_name;
			$call_bean->duration_hours = 00;
			$call_bean->date_start = $current_date;
			$call_bean->parent_type = $_REQUEST['RelatedModule'];
			$call_bean->status = $call_status;			
			$call_bean->direction = "Inbound";
			$call_bean->parent_id = $_REQUEST['RelatedId'];
			$call_bean->twilio_call_id = $call_id;
			$call_bean->source = $_REQUEST['source'];
			$call_bean->destination = $_REQUEST['destination'];
			$call_bean->save();	
			
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
			
			$GLOBALS['log']->debug("<=>in dialing satus call object with added relationship =>");
			$GLOBALS['log']->debug(print_r($call_bean,1));
			print("true");		*/		
		} else {
			if ($call_status == "completed") {
				//getting the start_time of call and start_time to calculate call_duration in minutes		
				// $time          = $call_bean->date_start;
				// $time_start    = strtotime($time);
				// $time_end      = strtotime($current_date);
				// $call_duration = ceil(($time_end - $time_start) / 60);
				
				//updating the call end time and call duration and call ended status
				// $call_bean->duration_minutes = $call_duration;
				$call_bean->date_end         = $time_end;
				$call_bean->status           = $call_status;
				$call_bean->sync             = 1;
				$call_bean->save();
				$GLOBALS['log']->fatal("<=>in completed status=>");
			$GLOBALS['log']->fatal(print_r($call_bean->name, 1));
				print("save");
			} else if ($call_status != "rejected" && $call_status != "canceled"){ 
				//when call is being established or rejected or cancelled by caller or callee             
				$call_bean->status = $call_status;
				$call_bean->sync   = 1;
				$call_bean->save();
				$GLOBALS['log']->fatal("<=>in $call_status status=>");
				$GLOBALS['log']->fatal(print_r($call_bean->name, 1));
				print("true");
			} 
		}
	}
?>