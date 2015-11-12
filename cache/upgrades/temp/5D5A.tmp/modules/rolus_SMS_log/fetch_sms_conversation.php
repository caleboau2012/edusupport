<?php
	/**
	*  this will return the SMS Conversation history
	*  based upon current gmdate 
	*  to present the front end application in the form of Chat application	
	**/
	
	global $db,$current_user;
	/*$module_name = "rolus_SMS_log";
	$class = $GLOBALS['beanList'][$module_name];
	require_once($GLOBALS['beanFiles'][$class]);
	$sms_class = new $class();*/
	$timedate = new TimeDate();
	
	
	require_once('modules/rolus_SMS_log/rolus_SMS_log.php');
	$sms_class = new rolus_SMS_log();
	$_REQUEST['destination_number'] = formatPhoneE164($_REQUEST['destination_number']);
	$_REQUEST['source_number'] = formatPhoneE164($_REQUEST['source_number']);
	// fetched sms records upon first click of click to sms if exists in database without last sms record fetced date
	if(!empty($_REQUEST['source_number']) AND !empty($_REQUEST['destination_number']) AND empty($_REQUEST['final_picked_date']))
	{		
		$sql = "SELECT date_entered AS tempDate,date_sent AS date_entered,message,direction FROM ".$sms_class->table_name." WHERE (origin='".$_REQUEST['destination_number']."' OR destinaiton='".$_REQUEST['destination_number']."') AND deleted=0 AND status!='scheduled' ORDER BY date_sent";
		$result = $db->query($sql);
		if($db->getRowCount($result)>0)
		{
			$count = 0;
			while($sms_conversation = $db->fetchByAssoc($result))
			{
				if($sms_conversation['date_entered']==null){
					$sms_conversations[$count]['date_entered']=$sms_conversations[$count]['tempDate'];
					$sms_conversations[$count]['date_entered'] = $timedate->to_display_date_time($sms_conversation['tempDate'],true,true,$current_user);				
					//$sms_conversations[$count]['date_entered_query'] = $sms_conversation['tempDate'];
				}
				else{
					$sms_conversations[$count]['date_entered'] = $timedate->to_display_date_time($sms_conversation['date_entered'],true,true,$current_user);
					$sms_conversations[$count]['date_entered_query'] = $sms_conversation['date_entered'];	
				}
							
				//$sms_conversations[$count]['date_entered_query'] = $sms_conversation['date_entered'];				
				$sms_conversations[$count]['message'] = nl2br(html_entity_decode($sms_conversation['message']));
				$sms_conversations[$count]['direction'] = $sms_conversation['direction'];
				$count++;
			}	
			print_r(json_encode($sms_conversations));//convert associative array into object			
		}
		else
		{
			print_r(json_encode(array("result"=>"empty")));
		}			
	}
	elseif(!empty($_REQUEST['final_picked_date']))// fetched the latest updated or sent or receive sms from database based upon the last sms record fetched date
	{		
		$final_picked_date = urldecode($_REQUEST['final_picked_date']); //decode the final date of last fetched sms record
			
		$sql = "SELECT date_sent AS date_entered,message,direction FROM ".$sms_class->table_name." WHERE (origin='".$_REQUEST['destination_number']."' OR destinaiton='".$_REQUEST['destination_number']."') AND date_sent >'".$final_picked_date."' AND deleted=0 AND status!='scheduled' ORDER BY date_sent";		
		$result = $db->query($sql);
		if($db->getRowCount($result)>0)
		{
			$count = 0; // to place the sms messages arrays to proper index
			while($sms_conversation = $db->fetchByAssoc($result))
			{
				$sms_conversations[$count]['date_entered'] = $timedate->to_display_date_time($sms_conversation['date_entered'],true,true,$current_user);								
				$sms_conversations[$count]['date_entered_query'] = $sms_conversation['date_entered']; // to query datetime in database for latest sms messages
				$sms_conversations[$count]['message'] = nl2br(html_entity_decode($sms_conversation['message']));
				$sms_conversations[$count]['direction'] = $sms_conversation['direction'];
				$count++;
			}
			$GLOBALS['log']->debug("All sms messages saved in database =>");
			$GLOBALS['log']->debug(print_r($sms_conversations,1));
			
			print_r(json_encode($sms_conversations));//convert associative array into object			
		}
		else
		{
			print_r(json_encode(array("result"=>"empty")));
		}	
	}
	
	function formatPhoneE164($number) {
		if(!empty($number)){
			global $db;
			$sql = "SELECT value FROM config WHERE name='twilio_country_code'";
			$result = $db->query($sql);
			$country_code = '';
			$countryCodeExist = false;
			//get default country code of system
			if($db->getRowCount($result)>0){
				$row = $db->fetchByAssoc($result);
				$country_code = $row['value'];
			}
			if($number[0]=='+'){
				$countryCodeExist = true;
			}
			$number = preg_replace("/[^A-Za-z0-9 ]/", "", $number);
			$number = str_replace(" ","", $number);
			if(!$countryCodeExist && strlen($number)>10){
				$countryCodeExist = true;
			}
			if($countryCodeExist){
				$number = '+'.$number;
			}
			else{
				$number = (($country_code[0]=='+')?'':'+').$country_code.$number;
			}
		}
		return $number;
	}
	exit;
