<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/**
	*	this will save the call lead relationship whenever an unknown caller calls to this system 
	**/
	
	class SaveLeadCallRelationship
	{		
		function save_lead_call_Relationship(&$bean, $event, $arguments)
		{
			$moduleName = 'Calls';
			$call_bean = BeanFactory::getBean($moduleName);
			$call_bean->retrieve_by_string_fields(array('twilio_call_id'=>$_REQUEST['twilio_call_id']));
			
			if($_REQUEST['module'] == 'Leads')
			{
				$call_bean->load_relationship('leads');
				$call_bean->leads->add($bean->id);
			}
		}		
	}