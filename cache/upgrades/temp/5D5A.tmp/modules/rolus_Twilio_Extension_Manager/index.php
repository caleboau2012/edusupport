<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$obj = $this->bean;
$obj->retrieve('1');

if(empty($obj->id))
{
	$obj->id='1';
	$obj->new_with_id=true;
	$obj->name='IVR Manager';
	$obj->save();
	$obj->retrieve('1');
}
$this->ss->assign('ivr_voice', get_select_options($app_list_strings['ivr_voice_dom'],$obj->ivr_voice)); //get_select_options(dropdown name(present in app_list_strings),checked value)
$this->ss->assign('operator_name', get_select_options(get_user_array(),$obj->operator_name));

/* getting only Active users from sugar database */

$user_ids = array_keys(get_user_array());
$user_ids_count = count($user_ids);

for($i=0; $i<$user_ids_count; $i++)
{
	if(!empty($user_ids[$i]))
	{
		$active_user_ids[$i] = $user_ids[$i];
	}
}
$active_user_ids_count = count($active_user_ids);
/* this will fetch relevant data of all active users */
for($j=1; $j <= $active_user_ids_count; $j++)
{	
	$sql = "SELECT id,CONCAT(IFNULL(first_name,''),' ',last_name) AS full_name,voip_access,IFNULL(extension,'') AS extension,allow_phone_work,allow_phone_mobile,allow_phone_home,allow_phone_other,allow_browser FROM users WHERE id='".$active_user_ids[$j]."'";
	$users_list[$j] = $GLOBALS['db']->query($sql);		
	$users[$j] = $GLOBALS['db']->fetchByAssoc($users_list[$j]);
}

$count = 0;
foreach($users as $key => $user)
{
	if(isset($user['id']))
	{
		$voip_access_list[$count] = $user; // for disabling elements on page load

		$user['voip_access'] = get_select_options($app_list_strings['voip_access_dom'],$user['voip_access']); 
	}	
	$system_users[$count] = $user;	
	$count++;
}

$this->ss->assign('voip_access_list',$voip_access_list);
$this->ss->assign('users_list',$system_users);

$this->ss->assign('bean',$obj);
$this->ss->display('modules/rolus_Twilio_Extension_Manager/tpls/index.tpl');
?>