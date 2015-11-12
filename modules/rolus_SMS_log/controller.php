<?php

	class rolus_SMS_logController extends SugarController
	{
		public function rolus_SMS_logController()
		{
			parent::SugarController();
		}
		
		public function action_saveMultipleSms()
		{	
			try
			{
				$recipients = explode(";",$_REQUEST['too']);
			
				$count=0;
				$recipients_numbers = '';
				foreach($recipients as $recipient)
				{
					if($this->process_number($recipient) != "false")
						$recipients_numbers[$count] = $this->process_number($recipient);
						
					$count++;
				}
				
				require_once("modules/rolus_Twilio_Account/rolus_Twilio_Account.php");
				$rolus_Twilio_Account = new rolus_Twilio_Account();
				$rolus_Twilio_Account->retrieve('1');
				$source_number = $rolus_Twilio_Account->phone_number;
								
				require_once("modules/rolus_SMS_log/rolus_SMS_log.php");
				foreach($recipients_numbers as $recipients_number) // for sending multiple sms to multiple recipients
				{						
					$rolus_SMS_log = new rolus_SMS_log();
					$rolus_SMS_log->message = $_REQUEST['message'];
								
					if(isset($_REQUEST['date_sent']) AND !empty($_REQUEST['date_sent']))
					{
						/* convert datesent from US format to Database format */
						list($month,$date,$year) = sscanf($_REQUEST['date_sent'], "%d/%d/%d");
						$date_sent = "$date-$month-$year";
					
						$time_sent = $_REQUEST['date_sent_hours'].":".$_REQUEST['date_sent_minutes'].$_REQUEST['date_sent_meridiem'];				
						
						global $current_user;
						$timezone = TimeDate::userTimezone($current_user);
						$formated_date = $date_sent." ".$time_sent;
						$datetime_sent = gmdate('Y-m-d H:i:s', strtotime($formated_date." ".$timezone));							
					
						$rolus_SMS_log->date_sent = $datetime_sent;
						$rolus_SMS_log->status = "scheduled";
					}
					else
					{				
						$rolus_SMS_log->date_sent = gmdate('Y-m-d H:i:s', time());
						$rolus_SMS_log->status = "sending";
					}
					$rolus_SMS_log->direction = "outgoing";				
					$rolus_SMS_log->origin = $source_number;
					$rolus_SMS_log->destinaiton = $recipients_number;
					
					$rolus_SMS_log->save();	// actually sending and saving SMS					
				}//end foreach loop sending sms to multiple recipients		
			}
			catch(Exception $exp)
			{
				$GLOBALS['log']->fatal("Exception Caught while sending sms to multiple recipients(either recipient is not valid or connection is not established)");
			}				
			SugarApplication::redirect("index.php?module=rolus_SMS_log&action=index");
		}
		
		function process_number($phone_number)
		{
			$formated_number ='';
			$original_number = $phone_number;
			$num_to_format = preg_replace('/[^0-9]/','',$phone_number);		
						
			if(substr($num_to_format,0,2) == "00") 
			{
				$formated_number = str_replace($num_to_format,"00","+");
				if(strlen($formated_number) < 8 || $this->is_repeated_digit($formated_number)) ///check for invalid number
				{				
					$formated_number = 'false';
				}
			}
			else if(substr($original_number,0,1) == "+" || substr($original_number,strpos($original_number,"<")+1,1) == "+")
			{
				$formated_number = "+".$num_to_format;
				if(strlen($formated_number) < 8 || $this->is_repeated_digit($formated_number))///check for invalid number(include alphabetical or alphanumerical phone number or single digit repeated phone number)
				{
					$formated_number = 'false';
				}
			}
			else
			{
				if(strlen($num_to_format) < 6 || $this->is_repeated_digit($num_to_format))///check for invalid number
				{
					$formated_number = 'false';
				}
				else
				{
					/*require_once('modules/Administration/Administration.php');
					$admin = new Administration();
					$admin->retrieveSettings(); //will retrieve all settings from db
					$twilio_country_code = $admin->settings['MySettings_twilio_country_code'];
					
					$formated_number = $twilio_country_code.$num_to_format;	*/
					$formated_number = "+1".$num_to_format;
				}
			}			
			return $formated_number;
		}
		
		/*
		*	this will check the repetition of the same digit in the phone number that was entered mistakenly
		*/	
		function is_repeated_digit($repeating_number)
		{
			$arr = '';
			//$arr = explode('',$repeating_number); //convert string to array doesn't support empty delimiter
			$arr = preg_split('//', $repeating_number, -1,PREG_SPLIT_NO_EMPTY);//convert string to array with empty delimiter 
			$arr_len = count($arr);
			$freq_of_num = 0;
			$rep_num ='';
			for($i=0; $i<$arr_len;$i++)
			{
				if($freq_of_num == 0)
				{
					$rep_num = $arr[$i];
					$freq_of_num++;
				}
				else if($freq_of_num >0)
				{
					if($arr[$i] == $rep_num)
					{
						$freq_of_num++;
					}
					$rep_num = $arr[$i];
				}
			}
			
			if($freq_of_num >= 6)
			{
				return true;        
			}
			else
			{
				return false;
			}
		}
	}
?>