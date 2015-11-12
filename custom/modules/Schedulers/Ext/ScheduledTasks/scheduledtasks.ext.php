<?php 
 //WARNING: The contents of this file are auto-generated


 /**
 * 
 * 
 * @package AdvancedOpenDiscovery
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

$job_strings[] = 'aodIndexUnindexed';
$job_strings[] = 'aodOptimiseIndex';


/**
 * Scheduled job function to index any unindexed beans.
 * @return bool
 */
function aodIndexUnindexed(){
    $total = 1;
    while($total > 0){
        $total = performLuceneIndexing();
    }
    return true;
}

function aodOptimiseIndex(){
    $index = BeanFactory::getBean("AOD_Index")->getIndex();
    $index->optimise();
    return true;
}


function performLuceneIndexing(){
    global $db, $sugar_config;
    if(empty($sugar_config['aod']['enable_aod'])){
        return;
    }
    $index = BeanFactory::getBean("AOD_Index")->getIndex();

    $beanList = $index->getIndexableModules();
    $total = 0;
    foreach($beanList as $beanModule => $beanName){
        $bean = BeanFactory::getBean($beanModule);
        if(!$bean || !method_exists($bean,"getTableName") || !$bean->getTableName()){
            continue;
        }
        $query = "SELECT b.id FROM ".$bean->getTableName()." b LEFT JOIN aod_indexevent ie ON (ie.record_id = b.id AND ie.record_module = '".$beanModule."') WHERE b.deleted = 0 AND (ie.id IS NULL OR ie.date_modified < b.date_modified)";
        $res = $db->limitQuery($query,0,500);
        $c = 0;
        while($row = $db->fetchByAssoc($res)){
            $c++;
            $total++;
            $index->index($beanModule, $row['id']);
        }
        if($c){
            $index->commit();
            $index->optimise();
        }

    }
    $index->optimise();
    return $total;
}

/**
 *
 * @package Advanced OpenPortal
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

$job_strings[] = 'pollMonitoredInboxesAOP';

function pollMonitoredInboxesAOP() {
    require_once 'custom/modules/InboundEmail/AOPInboundEmail.php';
    $_bck_up = array('team_id' => $GLOBALS['current_user']->team_id, 'team_set_id' => $GLOBALS['current_user']->team_set_id);
    $GLOBALS['log']->info('----->Scheduler fired job of type pollMonitoredInboxesAOP()');
    global $dictionary;
    global $app_strings;
    global $sugar_config;

    require_once('modules/Configurator/Configurator.php');
    require_once('modules/Emails/EmailUI.php');

    $ie = new AOPInboundEmail();
    $emailUI = new EmailUI();
    $r = $ie->db->query('SELECT id, name FROM inbound_email WHERE is_personal = 0 AND deleted=0 AND status=\'Active\' AND mailbox_type != \'bounce\'');
    $GLOBALS['log']->debug('Just got Result from get all Inbounds of Inbound Emails');

    while($a = $ie->db->fetchByAssoc($r)) {
        $GLOBALS['log']->debug('In while loop of Inbound Emails');
        $ieX = new AOPInboundEmail();
        $ieX->retrieve($a['id']);
        $GLOBALS['current_user']->team_id = $ieX->team_id;
        $GLOBALS['current_user']->team_set_id = $ieX->team_set_id;
        $mailboxes = $ieX->mailboxarray;
        foreach($mailboxes as $mbox) {
            $ieX->mailbox = $mbox;
            $newMsgs = array();
            $msgNoToUIDL = array();
            $connectToMailServer = false;
            if ($ieX->isPop3Protocol()) {
                $msgNoToUIDL = $ieX->getPop3NewMessagesToDownloadForCron();
                // get all the keys which are msgnos;
                $newMsgs = array_keys($msgNoToUIDL);
            }
            if($ieX->connectMailserver() == 'true') {
                $connectToMailServer = true;
            } // if

            $GLOBALS['log']->debug('Trying to connect to mailserver for [ '.$a['name'].' ]');
            if($connectToMailServer) {
                $GLOBALS['log']->debug('Connected to mailserver');
                if (!$ieX->isPop3Protocol()) {
                    $newMsgs = $ieX->getNewMessageIds();
                }
                if(is_array($newMsgs)) {
                    $current = 1;
                    $total = count($newMsgs);
                    require_once("include/SugarFolders/SugarFolders.php");
                    $sugarFolder = new SugarFolder();
                    $groupFolderId = $ieX->groupfolder_id;
                    $isGroupFolderExists = false;
                    $users = array();
                    if ($groupFolderId != null && $groupFolderId != "") {
                        $sugarFolder->retrieve($groupFolderId);
                        $isGroupFolderExists = true;
                    } // if
                    $messagesToDelete = array();
                    if ($ieX->isMailBoxTypeCreateCase()) {
                        require_once 'modules/AOP_Case_Updates/AOPAssignManager.php';
                        $assignManager = new AOPAssignManager($ieX);
                    }
                    foreach($newMsgs as $k => $msgNo) {
                        $uid = $msgNo;
                        if ($ieX->isPop3Protocol()) {
                            $uid = $msgNoToUIDL[$msgNo];
                        } else {
                            $uid = imap_uid($ieX->conn, $msgNo);
                        } // else
                        if ($isGroupFolderExists) {
                            if ($ieX->importOneEmail($msgNo, $uid)) {
                                // add to folder
                                $sugarFolder->addBean($ieX->email);
                                if ($ieX->isPop3Protocol()) {
                                    $messagesToDelete[] = $msgNo;
                                } else {
                                    $messagesToDelete[] = $uid;
                                }
                                if ($ieX->isMailBoxTypeCreateCase()) {
                                    $userId = $assignManager->getNextAssignedUser();
                                    $GLOBALS['log']->debug('userId [ '.$userId.' ]');
                                    $ieX->handleCreateCase($ieX->email, $userId);
                                } // if
                            } // if
                        } else {
                            if($ieX->isAutoImport()) {
                                $ieX->importOneEmail($msgNo, $uid);
                            } else {
                                /*If the group folder doesn't exist then download only those messages
                                 which has caseid in message*/

                                $ieX->getMessagesInEmailCache($msgNo, $uid);
                                $email = new Email();
                                $header = imap_headerinfo($ieX->conn, $msgNo);
                                $email->name = $ieX->handleMimeHeaderDecode($header->subject);
                                $email->from_addr = $ieX->convertImapToSugarEmailAddress($header->from);
                                $email->reply_to_email  = $ieX->convertImapToSugarEmailAddress($header->reply_to);
                                if(!empty($email->reply_to_email)) {
                                    $contactAddr = $email->reply_to_email;
                                } else {
                                    $contactAddr = $email->from_addr;
                                }
                                $mailBoxType = $ieX->mailbox_type;
                                $ieX->handleAutoresponse($email, $contactAddr);
                            } // else
                        } // else
                        $GLOBALS['log']->debug('***** On message [ '.$current.' of '.$total.' ] *****');
                        $current++;
                    } // foreach
                    // update Inbound Account with last robin

                } // if
                if ($isGroupFolderExists)	 {
                    $leaveMessagesOnMailServer = $ieX->get_stored_options("leaveMessagesOnMailServer", 0);
                    if (!$leaveMessagesOnMailServer) {
                        if ($ieX->isPop3Protocol()) {
                            $ieX->deleteMessageOnMailServerForPop3(implode(",", $messagesToDelete));
                        } else {
                            $ieX->deleteMessageOnMailServer(implode($app_strings['LBL_EMAIL_DELIMITER'], $messagesToDelete));
                        }
                    }
                }
            } else {
                $GLOBALS['log']->fatal("SCHEDULERS: could not get an IMAP connection resource for ID [ {$a['id']} ]. Skipping mailbox [ {$a['name']} ].");
                // cn: bug 9171 - continue while
            } // else
        } // foreach
        imap_expunge($ieX->conn);
        imap_close($ieX->conn, CL_EXPUNGE);
    } // while
    $GLOBALS['current_user']->team_id = $_bck_up['team_id'];
    $GLOBALS['current_user']->team_set_id = $_bck_up['team_set_id'];
    return true;
}


 /**
 * 
 * 
 * @package 
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
$job_strings[] = 'aorRunScheduledReports';

function aorRunScheduledReports(){
    require_once 'include/SugarQueue/SugarJobQueue.php';
    $date = new DateTime();//Ensure we check all schedules at the same instant
    foreach(BeanFactory::getBean('AOR_Scheduled_Reports')->get_full_list() as $scheduledReport){

        if($scheduledReport->status == 'active' && $scheduledReport->shouldRun($date)){
            if(empty($scheduledReport->aor_report_id)){
                continue;
            }
            $job = new SchedulersJob();
            $job->name = "Scheduled report - {$scheduledReport->name} on {$date->format('c')}";
            $job->data = $scheduledReport->id;
            $job->target = "class::AORScheduledReportJob";
            $job->assigned_user_id = 1;
            $jq = new SugarJobQueue();
            $jq->submitJob($job);
        }
    }
}



class AORScheduledReportJob implements RunnableSchedulerJob
{
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
    public function run($data)
    {
        global $sugar_config, $timedate;

        $bean = BeanFactory::getBean('AOR_Scheduled_Reports',$data);
        $report = $bean->get_linked_beans('aor_report','AOR_Reports');
        if($report){
            $report = $report[0];
        }else{
            return false;
        }
        $html = "<h1>{$report->name}</h1>".$report->build_group_report();
        $html .= <<<EOF
        <style>
        h1{
            color: black;
        }
        .list
        {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;
            background: #fff;margin: 45px;width: 480px;border-collapse: collapse;text-align: left;
        }
        .list th
        {
            font-size: 14px;
            font-weight: normal;
            color: black;
            padding: 10px 8px;
            border-bottom: 2px solid black};
        }
        .list td
        {
            padding: 9px 8px 0px 8px;
        }
        </style>
EOF;
        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
        $mail = new SugarPHPMailer();

        /*$result = $report->db->query($report->build_report_query());
        $reportData = array();
        while($row = $report->db->fetchByAssoc($result, false))
        {
            $reportData[] = $row;
        }
        $fields = $report->getReportFields();
        foreach($report->get_linked_beans('aor_charts','AOR_Charts') as $chart){
            $image = $chart->buildChartImage($reportData,$fields,false);
            $mail->AddStringEmbeddedImage($image,$chart->id,$chart->name.".png",'base64','image/png');
            $html .= "<img src='cid:{$chart->id}'>";
        }*/

        $mail->setMailerForSystem();
        $mail->IsHTML(true);
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Subject=from_html($bean->name);
        $mail->Body=$html;
        $mail->prepForOutbound();
        $success = true;
        $emails = $bean->get_email_recipients();
        foreach($emails as $email_address) {
            $mail->ClearAddresses();
            $mail->AddAddress($email_address);
            $success = $mail->Send() && $success;
        }
        $bean->last_run = $timedate->getNow()->asDb(false);
        $bean->save();
        return true;
    }
}

/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */
 
$job_strings['aow']='processAOW_Workflow';

function processAOW_Workflow() {
    require_once('modules/AOW_WorkFlow/AOW_WorkFlow.php');
    $workflow = new AOW_WorkFlow();
    return $workflow->run_flows();
}


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