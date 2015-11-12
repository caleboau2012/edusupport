<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
?>
<?php
	/*
	*	this will request to twilio server and will fetch the all usage records of approximately all categories
	*	and display them to end user
	*/
	
	/*$target_module = 'rolus_Twilio_Account';
	$class = $GLOBALS['beanList'][$target_module];
	require_once($GLOBALS['beanFiles'][$class]);
	$rolus_Twilio_Account = new $class();*/
	
	require_once('modules/rolus_Twilio_Account/rolus_Twilio_Account.php');
	$rolus_Twilio_Account = new rolus_Twilio_Account();
	
	//exception handling if there is some connection problems with twilio client APIs etc
	try
	{
		$client = $rolus_Twilio_Account->getClient();
		if(!(is_object($client) && $client instanceof Services_Twilio))
				throw new settingsException('Cannot connect to Twilio','3');
				
		//exception handling if the end user requests the usage for irrelevant dates range
		try 
		{					
			if(isset($_REQUEST['start_date']))//if usage of dates range is requested
			{				
				$start_date = date('Y-m-d',strtotime($_REQUEST['start_date']));
				$end_date = date('Y-m-d',strtotime($_REQUEST['end_date']));									
																						

				$account_usage_records = get_category_range_usage($start_date,$end_date,$client);								
			}
			else //if usage of current month is requested
			{														
				$account_usage_records = get_category_current_month_usage($client);//get_object_vars($object) returns the non-static properties after converting into associative array					
			}
			
			//getting array from returned resources
			$final_usage_all_categories = get_array_from_resources($account_usage_records);
		}
		catch(Services_Twilio_RestException $e)
		{	
			//echo "<script type='text/javascript'>SUGAR.ajaxUI.showErrorMessage('No Usage record is found against this date range')</script>";
			echo "<script type='text/javascript'>alert('No Usage is found for Date range !');</script>";
		}		
	} catch (communicaitonException $e) {
		$GLOBALS['log']->fatal("Caught communicaitonException ('{$e->getMessage()}')\n{$e}\n");
	} catch (settingsException $e) {
		$GLOBALS['log']->fatal("Caught settingsException ('{$e->getMessage()}')\n{$e}\n");
	} catch (Exception $e) {
		$GLOBALS['log']->fatal("Caught Exception ('{$e->getMessage()}')\n{$e}\n");
	}	
	
	/*
	*	this will return the usage of all the resources requested in $category variable between the specified dates range
	*/
	function get_category_range_usage($start_date,$end_date,$client)
	{
		$account_usage_records_object = '';
		$count = 0;
		$date_range = array("StartDate" => $start_date,"EndDate" => $end_date);
		$account_usage_records_object = $client->account->usage_records->getIterator(0, 50, $date_range); 
		foreach($account_usage_records_object as $record){
			$account_usage_records[$count] =  $record;								
			$count++;
		}
			
		$GLOBALS['log']->debug("All Twilio usage for date range => ");
		$GLOBALS['log']->debug(print_r($account_usage_records,1));
					
		return $account_usage_records;			
	}
	
	/*
	*	this will return the usage of all the resources requested for the current month
	*/
	function get_category_current_month_usage($client)
	{
		$account_usage_records_object = '';
		$count = 0;
		/*foreach ($client->account->usage_records->this_month as $record) {
			$account_usage_records[$count] =  $record;								
			$count++;
		}*/
		$usage_records = $client->account->usage_records->getIterator(0, 50, array(  ));
		foreach ($usage_records as $record)
			 {
			$account_usage_records[$count] =  $record;								
			$count++;
		}
		$GLOBALS['log']->debug("All Twilio usage for current month => ");
		$GLOBALS['log']->debug(print_r($account_usage_records,1));		
		return $account_usage_records;		
	}
	
	/*
	*	this will convert returned usage resources to array to become available to display via smarty templates
	*/
	function get_array_from_resources($account_usage_records)
	{		
		$count_usage = 0;	
		/*
		*	converting returned resources into associative array to be displayed via smarty template
		*/
		for($i=0;$i<=25;$i++)
		{
				if($account_usage_records[$i]->category == "calls" ||
				   $account_usage_records[$i]->category == "sms" ||
				   $account_usage_records[$i]->category == "recordings" ||
				   $account_usage_records[$i]->category == "phonenumbers" ||
				   $account_usage_records[$i]->category == "totalprice"
				  )
				{
					$final_usage_all_categories[$count_usage]['category'] = $account_usage_records[$i]->category;
					$final_usage_all_categories[$count_usage]['count'] = $account_usage_records[$i]->count;
					$final_usage_all_categories[$count_usage]['usage'] = $account_usage_records[$i]->usage;
					$final_usage_all_categories[$count_usage]['price'] = "$".$account_usage_records[$i]->price;	
					if($final_usage_all_categories[$count_usage]['category'] == "totalprice") // usage of totalprice resource shouldn't displayed
					{
						$final_usage_all_categories[$count_usage]['usage'] = null;
					}
					$count_usage++;
				}	
			
		} //end for loop (that loop through all returned responses)		
		
		$GLOBALS['log']->debug("All Twilio final_usage_all_categories => ");
		$GLOBALS['log']->debug(print_r($final_usage_all_categories,1));		
		return $final_usage_all_categories;
		
		
	}
?>