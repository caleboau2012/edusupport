<?PHP
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/**
 * THIS CLASS IS GENERATED BY MODULE BUILDER
 * PLEASE DO NOT CHANGE THIS CLASS
 * PLACE ANY CUSTOMIZATIONS IN rolus_Twilio_Account
 */

require_once("custom/include/twilio/Services/Twilio.php");
require_once("custom/include/twilio/Exceptions.php");
class rolus_Twilio_Account_sugar extends Basic {
	var $new_schema = true;
	var $module_dir = 'rolus_Twilio_Account';
	var $object_name = 'rolus_Twilio_Account';
	var $table_name = 'rolus_twilio_account';
	var $importable = false;
	var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
		var $id;
		var $name;
		var $date_entered;
		var $date_modified;
		var $modified_user_id;
		var $modified_by_name;
		var $created_by;
		var $created_by_name;
		var $description;
		var $deleted;
		var $created_by_link;
		var $modified_user_link;
		var $assigned_user_id;
		var $assigned_user_name;
		var $assigned_user_link;
		var $username;
		var $pass;
		var $phone_number;
		var $appsid;
		
	function rolus_Twilio_Account_sugar(){	
		parent::Basic();
	}
	
	function bean_implements($interface){
		switch($interface){
			case 'ACL': return true;
		}
		return false;
	}		
	function getSettings()
	{
		$this->retrieve('1');
		//$this->pass = blowfishDecode('TwilioAccount',$this->pass);		
	}		
	
	
	/**
	*	this function will make outbound call with between source n destination through services_twilio
	*	will return the services_twilio object to use Twilio REST APIs 
	**/	
	function getClient()
	{
		$client = false;
		try {
			$this->retrieve('1');
			
			if (empty($this->id))
				throw new settingsException('No settings saved in the system','1');
					
			
			$AccountSid = $this->username;
			$AuthToken = $this->pass;			
			//$AuthToken = blowfishDecode('TwilioAccount',$this->pass);			
			
			$GLOBALS['log']->debug("Account Sid : ".$AccountSid);
			$GLOBALS['log']->debug("Auth Token: ".$AuthToken);
			
	
			if (empty($AccountSid) || empty($AuthToken))
				throw new settingsException('Data missing','2');
			
			$client = new Services_Twilio($AccountSid, $AuthToken);	
		} catch (communicaitonException $e) {			
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
		} catch (settingsException $e) {			
			$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
		} catch (Exception $e) {			
			$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
		}
		return $client;
	}		
	
	/**
	*	this function will register browser with twilio through services_twilio_capability and
	*	will return the $capability object, due to which twilio-registered browser will be capable enough 
	*	=> to listen incoming connections and
	*	=> to make outbound call through browser to traditional phone
	**/
	function getCapability()
	{
		$capability = false;
		try
		{
			$this->retrieve('1');
			
			if(empty($this->id))
				throw new settingsException('No settings saved in the System','1');
						
			// require_once('custom/include/twilio/Capability.php');
			$AccountSid = $this->username;
			$AuthToken = $this->pass;
			//$AuthToken = blowfishDecode('TwilioAccount',$this->pass);
			
			$GLOBALS['log']->debug("Account Sid : ".$AccountSid);
			$GLOBALS['log']->debug("Auth Token: ".$AuthToken);
			
	
			
			if(empty($AccountSid) || empty($AuthToken))
				throw new settingsException('Data missing','2');
			
			$capability = new Services_Twilio_Capability($AccountSid,$AuthToken);
	
		}catch(communicaitonException $e){			
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
		}catch(settingsException $e){			
			$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
		}catch(Exception $e){			
			$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
		}
		return $capability;
	}
	
	/**
	*	this will return the ApplicationSid of the Twilio TwiML application 
	*	to make twilio-registered browser capable enough to allow outgoing connections
	**/
	function getApplicationSid()
	{
		$ApplicationSid = false;
		try
		{
			$this->retrieve('1');
			
			if(empty($this->id))
				throw new settingsException('No settings saved in the System','1');
			
			$ApplicationSid = $this->appsid;
			
			$GLOBALS['log']->debug("Application Sid : ".$ApplicationSid);
			
			if(empty($ApplicationSid))
				throw new settingsException('Application Sid is missing','2');
				
		}catch(communicaitonException $e){			
			$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
		}catch(settingsException $e){			
			$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
		}catch(Exception $e){			
			$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
		}
		return $ApplicationSid;
	}
}
?>