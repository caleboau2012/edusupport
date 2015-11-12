<?php
set_time_limit(0);
error_reporting(0);
array_push($job_strings, 'twilioSMSSync');

function twilioSMSSync()
{
	// Initialize the SMS log object
	/*$target_module = 'rolus_SMS_log';
	$class = $GLOBALS['beanList'][$target_module];
	require_once($GLOBALS['beanFiles'][$class]);
	$rolus_SMS_log = new $class();*/
	
	require_once("modules/rolus_SMS_log/rolus_SMS_log.php");
	$rolus_SMS_log = new rolus_SMS_log();
	
	try{
		$client = $rolus_SMS_log->getClient();
		if(!(is_object($client) && $client instanceof Services_Twilio))
				throw new settingsException('Cannot connect to Twilio','3');
		
		$order_by = 'date_entered DESC';
		$where = " ".$rolus_SMS_log->table_name.".`status` = 'sending' OR ".$rolus_SMS_log->table_name.".`status`='scheduled' OR (".$rolus_SMS_log->table_name.".`status`='sent' AND ".$rolus_SMS_log->table_name.".`cost` = 0.0000)";
		
		$list = $rolus_SMS_log->get_list($order_by,$where);
		
		if ($list['row_count'] > 0)
		{
			foreach ($list['list'] as $sms_log)
			{
				$rolus_SMS_log->updateStatus($sms_log->reference_id);
			}
		}

		$count_by_count_fun = $client->account->sms_messages->count();
		
		// $sms_usage_records_object = $client->get_sms_usage();
		
		/* getting sms count from twilio */
		// $sms_usage_records_array = (array)$sms_usage_records_object->ResponseXml->UsageRecords->UsageRecord->Count;
		
		// $count_by_count_fun = $sms_usage_records_array[0];
		
		$total_sms_pages = ceil($count_by_count_fun/100);// getting the sms pages count of all sms count fetched from twilio
		$messages_per_page = 100; //total number of messages per page to be fetched
		
		/* fetching sms from twilio and syncing with database page by page */
		for($i=0; $i<$total_sms_pages; $i++)
		{			
			$messages_object = $client->account->sms_messages->getPage($i,$messages_per_page);//$client->get_all_sms($i,$messages_per_page);
			$messages = (array)$messages_object->page->sms_messages;			
						
			$GLOBALS['log']->debug("all sms messages page no => ".$i);
			$GLOBALS['log']->debug(print_r(($messages),1));
				    
		$messages_array = array();
		$message_ids = array();
		$direction_map = array(
			'inbound' => 'incoming',
			'outbound' => 'outgoing',
			'outbound-api' => 'outgoing',
			'outbound-reply' => 'outgoing',
		);
		
		$account_module = 'rolus_Twilio_Account';
		$account_bean = BeanFactory::getBean($account_module);
		$account_bean->retrieve('1');
	
		// Get the messages
		foreach($messages as $message)
		{
			$message_data = $message;
			
			// If the messages are associated with the number stored in the Twiliio Account then get the data.
			if ((string)$message_data->to == $account_bean->phone_number || (string)$message_data->from == $account_bean->phone_number )
			{				
				$message_ids[] = (string)$message_data->sid;
				$data = array(
					'reference_id' => (string)$message_data->sid,
					'date_sent' => gmdate('Y-m-d H:i:s',strtotime((string)$message_data->date_sent)),
					'account' => (string)$message_data->account_sid,
					'destinaiton' => (string)$message_data->to,
					'origin' => (string)$message_data->from,
					'message' => (string)$message_data->body,
					'status' => (string)$message_data->status,
					'direction' => $direction_map[(string)$message_data->direction],
					'cost' => (string)$message_data->price,
					'url' => (string)$message_data->uri
				);
				
				if (strtotime((string)$message_data->date_sent) > strtotime('2012-11-14 17:0:00 +0000'))
				{
					if ((string)$message_data->direction == 'inbound')
					{
						$messages_array['incoming'][] = $data;
					}
					else if (preg_match('/outbound/i',(string)$message_data->direction))
					{
						$messages_array['outgoing'][] = $data;
					}
				}
			}
		}
		
		// Get the records already saved in the system
		$query = "SELECT `reference_id`,`status`,`need_sync`,`id` FROM rolus_sms_log WHERE reference_id IN ('".implode("','",$message_ids)."')";
		$already_synced = array();
		$existing_data = array();
		$rs = $GLOBALS['db']->query($query);
		while ($row = $GLOBALS['db']->fetchByAssoc($rs))
		{
			$already_synced[] = $row['reference_id'];
			$existing_data[$row['reference_id']] = $row;
		}
		// Sync the Incoming messages
		require_once('modules/rolus_SMS_log/rolus_SMS_log.php');
		foreach($messages_array['incoming'] as $incoming_message)
		{				
			$sms_log = new rolus_SMS_Log();
						
			if (!in_array($incoming_message['reference_id'],$already_synced))
			{				
				$sms_log->assigned_user_id = '1';
				$sms_log->from_sync = "TwilioSync";
				$sms_log->reference_id = $incoming_message['reference_id'];
				$sms_log->date_sent = $incoming_message['date_sent'];
				$sms_log->account = $incoming_message['account'];
				$sms_log->destinaiton = $incoming_message['destinaiton'];
				$sms_log->origin = $incoming_message['origin'];
				$sms_log->message = $incoming_message['message'];
				$sms_log->status = $incoming_message['status'];
				$sms_log->direction = $incoming_message['direction'];
				$sms_log->cost = $incoming_message['cost'];
				$sms_log->url = $incoming_message['url'];
				
				if($sms_log->direction == "inbound" || $sms_log->direction == "incoming")
					$sms_log->save();			
			}
		}
	
		// Sync the Outgoing messages
		foreach($messages_array['outgoing'] as $outgoing_message)
		{	
			$sms_log = new rolus_SMS_Log();
			
			if (!in_array($outgoing_message['reference_id'],$already_synced) || $existing_data[$outgoing_message['reference_id']]['need_sync'] == '1')
			{
				if (in_array($outgoing_message['reference_id'],$already_synced))
				{
					$sms_log->id = $existing_data[$outgoing_message['reference_id']]['id'];
				}
				$sms_log->assigned_user_id = '1';
				$sms_log->from_sync = "TwilioSync";
				$sms_log->reference_id = $outgoing_message['reference_id'];
				$sms_log->date_sent = $outgoing_message['date_sent'];
				$sms_log->account = $outgoing_message['account'];
				$sms_log->destinaiton = $outgoing_message['destinaiton'];
				$sms_log->origin = $outgoing_message['origin'];
				$sms_log->message = $outgoing_message['message'];
				if ($outgoing_message['status'] =='delivered')
				{
				$sms_log->status = "sent";
				}
				else
				{
				$sms_log->status = $outgoing_message['status'];
				}
				//$sms_log->status = $outgoing_message['status'];
				$sms_log->direction = $outgoing_message['direction'];
				$sms_log->cost = $outgoing_message['cost'];
				$sms_log->url = $outgoing_message['url'];
				$sms_log->save();
			}
		}
	
		// Send out the schedules SMSs
		$order_by = 'date_entered DESC';
		$where = " ".$rolus_SMS_log->table_name.".`status` = 'scheduled' AND ".$rolus_SMS_log->table_name.".`direction`='outgoing' AND '".gmdate('Y-m-d H:i:s')."' >= date_sent";
		
		$list = $rolus_SMS_log->get_list($order_by,$where);
		
		if ($list['row_count'] > 0)
		{
			foreach ($list['list'] as $sms_log)
			{
				$sms_log->sendSMS();
				$sms_log->from_sync = "TwilioSync";
				$sms_log->save();
			}
		}
	} // END for loop that actually fetch twilio sms Page by page 	
		
	} catch (communicaitonException $e) {		
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {		
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {		
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}
	return true;	
}
?>
