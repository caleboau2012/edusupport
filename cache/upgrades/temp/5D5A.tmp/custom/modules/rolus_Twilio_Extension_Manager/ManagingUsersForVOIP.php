<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
		
	/**
	*	this will set the users priviliges for VOIP before saving IVR settings in database
	**/
	class ManagingUsersForVOIP
	{
		/* this will set the users related field's values coming from FORM for only ACtive users */
		function ManagingUsers(&$bean, $event, $arguments)
		{			
			$all_user_ids = array_keys(get_user_array()); // will return only keys or user ids
			$user_ids_count = count($all_user_ids);

			for($j=0; $j<$user_ids_count; $j++)
			{
				if(!empty($all_user_ids[$j]))
				{
					$user_ids[$j] = $all_user_ids[$j];
				}
			}
			$active_user_ids_count = count($user_ids);
			/* this will fetch relevant data of all active users */
			for($i=1; $i <= $active_user_ids_count; $i++)
			{	
				$sql = "UPDATE users SET extension='".$_REQUEST[$user_ids[$i].'_extension']."',voip_access='".$_REQUEST[$user_ids[$i].'_voip_access']."',allow_phone_mobile='".$_REQUEST[$user_ids[$i].'_phone_mobile']."',allow_phone_work='".$_REQUEST[$user_ids[$i].'_phone_work']."',allow_phone_home='".$_REQUEST[$user_ids[$i].'_phone_home']."',allow_phone_other='".$_REQUEST[$user_ids[$i].'_phone_other']."',allow_browser='".$_REQUEST[$user_ids[$i].'_browser']."' WHERE id='".$user_ids[$i]."'";				
				$result = $GLOBALS['db']->query($sql);
			}
		}
	}	
?>