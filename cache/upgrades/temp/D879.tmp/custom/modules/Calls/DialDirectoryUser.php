<?php
	/*
	*	this will actually implement the Algorithm to dial to the specific Contact name 
	*	for which the caller has entered the mapping digits
	*/
	
	//input => $digits_to_map
	//$sql = "SELECT id,first_name,last_name,CONCAT(first_name,' ',last_name) AS full_name,CONCAT(first_name,' ',last_name) AS speaking_name,user_name FROM users WHERE logged_in=1 and availability=0";
	$sql = "SELECT id, first_name, last_name, CONCAT( IFNULL( first_name,  ' ' ) ,  ' ', last_name ) AS full_name, CONCAT( IFNULL( first_name,  ' ' ) ,  ' ', last_name ) AS speaking_name, user_name FROM users WHERE logged_in =1 AND availability =0";
	$result = $GLOBALS['db']->query($sql);
	$count_user = 0;
	while($available_user = $GLOBALS['db']->fetchByAssoc($result))
	{
		$available_users[$count_user] = $available_user;
		$count_user++;
	}
		
	$GLOBALS['log']->debug("returned online users");
	$GLOBALS['log']->debug(print_r($available_users,1));
	
	if(!empty($result->num_rows))
	{
		$digits_users = map_names_to_digits($available_users); //map string names to corresponding digits
		
		$users_for_say = get_matched_users($caller_digits,$digits_users);//will return the approximately mapped users to become available to call
		
		$GLOBALS['log']->debug("online possible matched users selected from dialing phone directory");
		$GLOBALS['log']->debug(print_r($users_for_say,1));
	}
	else
	{
		$_SESSION['user_state'] = 'busy';
		$GLOBALS['log']->debug("busy all possible matched users selected from dialing phone directory");
		dial_busy();
	}
	
	/*
	* 	this will evaluate the caller's input typed by the phone and mapped it to available users array 
	*	after converting user's names into digits and then compare the caller's input array to the user's name
	*	array and also assign scores upon match and mismatch 
	*	this will return the approximately matched available users 
	*/
	
	function get_matched_users($caller_digits,$digits_users)
	{
		$available_receivers = '';
		if(strpos($caller_digits,'0') != FALSE)
		{
			$search_index = 'full_name';
			$available_receivers = get_approx_users($caller_digits,$digits_users,$search_index);
			
			// sorting a multidimensional array
			array_sort_by_column($available_receivers, 'grades');
			
			//print_r($available_receivers);
		}
		else
		{
			$search_index = 'first_name';
			if($search_index == 'first_name')
			{
				$first_name_users = get_approx_users($caller_digits,$digits_users,$search_index); // for first name
			}	
		
			$search_index = 'last_name';
			if($search_index == 'last_name')
			{
				$last_name_users = get_approx_users($caller_digits,$digits_users,$search_index); // for last name
			}
			
			$possible_receivers = array_merge_recursive($first_name_users,$last_name_users);// merging arrays(of first name and last name)recursively
			
			$unique_receivers = remove_duplicate($possible_receivers, 'user_name'); // getting only uniques values from array based on user_name
		
			array_sort_by_column($unique_receivers,'grades'); // passing array by reference	for sorting based upon grades(matching or mismatching)		
			$available_receivers = $unique_receivers;
		}
		return $available_receivers;
	}
	
	/*
	*	this will remove duplicates arrays based upon specific column value from a multidimensional array
	*/
	function remove_duplicate($array, $field)
	{
		foreach ($array as $sub)
			$cmp[] = $sub[$field];
		
		$unique = array_unique($cmp);
		
		foreach ($unique as $k => $rien)
			$new_unique[] = $array[$k];
		
		return $new_unique;
	}
	
	/*
	*	this callback function will sort multidimensional array according to desired value
	*/
	function array_sort_by_column(&$unique_receivers, $sorting_column, $dir = SORT_DESC) {
		$sort_col = array();
		foreach ($unique_receivers as $key=> $row) {
			$sort_col[$key] = $row[$sorting_column];
		}
		array_multisort($sort_col, $dir, $unique_receivers);
	}
	
	/*
	*	this will search out the approximated user with his name
	*	this will return the users array for sorting and SAYING to dial a particular destination party
	*/ 
	function get_approx_users($caller_digits,$digits_users,$search_index)
	{
		$users_for_say = ''; //will contain the users for SAY purposes
		$caller_digits_arr = str_split($caller_digits);
		
		for($list = 0; $list < count($digits_users); $list++) //to iterate through all the available users got from DB
		{
			$caller_arr_len = count($caller_digits_arr); //length of the caller digits			
			
			$priority_grades = $caller_arr_len*3; // setting the default value of the grades having the highest value in grades
			
			$i = 0; $j = 0; $mis_match_index = 0; // i for caller digits and 
			$digits_users[$list]['grades'] = $priority_grades;//(e.g. 100) assigning starting grades to all parts of name equal to the length of array of all users for grading purposes
			
			$comp_str = $digits_users[$list][$search_index];//specific name part to search in
			$comp_arr = str_split($comp_str);//convert name string to array
		
			$mis_match_index_flag = FALSE; //setting the user name digits array's character mismatch checker
			while($i<$caller_arr_len) //to iterate throug all characters of a part of name to compare with caller digits
			{				
				if($caller_digits_arr[$i] == $comp_arr[$j]) //if match
				{					
					$i++;					
					
					if($j<count($comp_arr))
					{
						$j++;
					}
				}
				else // if mismatch 
				{
					if($j<count($comp_arr))
					{						
						if($mis_match_index_flag == FALSE)
						{					
							$mis_match_index_flag = TRUE; //finding the any mismatch untill caller digits array ends
							$mis_match_index = $j; //saving the location of the mis match
						}						
						
						$j++;						
						
						$priority_grades -= 1;
						$digits_users[$list]['grades'] = $priority_grades;																
					}
					else					
					{
						$i++;				

						$j = $mis_match_index;
						$mis_match_index_flag = FALSE;
					}
				} // end else case
			} // end while loop 						
		} //end for loop
		
		return $digits_users;
	} // end get_approx_users() function 
	
	/*
	*	this will count the number of multidimensional arrays based upon provided depth
	*/
	function getArrCount($arr, $depth=1) { 
		if (!is_array($arr) || !$depth) return 0; 
         
			$res=count($arr); 
         
			foreach ($arr as $in_ar) 
				$res+=getArrCount($in_ar, $depth-1); 
   
		return $res; 
	}
	
	/*
	*	this will convert the array names into corresponding digits and return the digits oriented names array
	*/
	function map_names_to_digits($arr_names)
	{
		//$arr_arr_names = array($arr_names); // place in parent array to become counting easy 
	
		$outer_arr_len = count($arr_names);//retuns the count of online users arrays
		for($j = 0;$j < $outer_arr_len; $j++)
		{
			
				$arr_names[$j] = convert_string_to_digits($arr_names[$j]);
			
		}	
		return $arr_names;
	}
	
	/*
	*	this will convert single array name to digits till the whole names array has become ended
	*/
	function convert_string_to_digits($str_array)
	{
		$str_array['first_name'] = convert_substr_digits($str_array['first_name']);
		$str_array['last_name'] = convert_substr_digits($str_array['last_name']);
		$str_array['full_name'] = convert_substr_digits($str_array['full_name']);
		
		return $str_array;
	}
	
	/*
	*	this will convert substr to digits
	*/
	function convert_substr_digits($substr)
	{
		//finding array values in name string to convert name string into digits
		$arr_2 = array('a','A','b','B','c','C'); // handle also case sensivity
		$substr_2 = str_replace($arr_2,'2',$substr);
		
		$arr_3 = array('d','D','e','E','f','F');
		$substr_3 = str_replace($arr_3,'3',$substr_2);
		
		$arr_4 = array('g','G','h','H','i','I');
		$substr_4 = str_replace($arr_4,'4',$substr_3);
		
		$arr_5 = array('j','J','k','K','l','L');
		$substr_5 = str_replace($arr_5,'5',$substr_4);
		
		$arr_6 = array('m','M','n','N','o','O');
		$substr_6 = str_replace($arr_6,'6',$substr_5);
		
		$arr_7 = array('p','P','q','Q','r','R','s','S');
		$substr_7 = str_replace($arr_7,'7',$substr_6);
		
		$arr_8 = array('t','T','u','U','v','V');
		$substr_8 = str_replace($arr_8,'8',$substr_7);
		
		$arr_9 = array('w','W','x','X','y','Y','z','Z');
		$substr_9 = str_replace($arr_9,'9',$substr_8);
		
		$arr_0 = array(' ');
		$substr_0 = str_replace($arr_0,'0',$substr_9);	
		
		return $substr_0;
	}
?>