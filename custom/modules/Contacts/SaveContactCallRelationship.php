<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
?>
<?php
	/**
	*	this will save the call contact relationship whenever an unknown caller calls to this system 
	**/
	
	class SaveContactCallRelationship
	{		
		public function save_contact_call_Relationship(&$bean, $event, $arguments)
		{
			$moduleName = 'Calls';
			$call_bean = BeanFactory::getBean($moduleName);
			$call_bean->retrieve_by_string_fields(array('twilio_call_id'=>$_REQUEST['twilio_call_id']));
			
			if($_REQUEST['module'] == 'Contacts')
			{
				$call_bean->load_relationship('contacts');
				$call_bean->contacts->add($bean->id);
			}
		}		
	}