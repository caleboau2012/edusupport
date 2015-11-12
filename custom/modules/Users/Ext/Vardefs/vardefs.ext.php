<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2014-06-20 12:06:29
$dictionary["User"]["fields"]["project_users_1"] = array (
  'name' => 'project_users_1',
  'type' => 'link',
  'relationship' => 'project_users_1',
  'source' => 'non-db',
  'module' => 'Project',
  'bean_name' => 'Project',
  'vname' => 'LBL_PROJECT_USERS_1_FROM_PROJECT_TITLE',
);



$dictionary["User"]["fields"]["SecurityGroups"] = array (
    'name' => 'SecurityGroups',
    'type' => 'link',
    'relationship' => 'securitygroups_users',
    'source' => 'non-db',
    'module' => 'SecurityGroups',
    'bean_name' => 'SecurityGroup',
    'vname' => 'LBL_SECURITYGROUPS',
);  
        
$dictionary["User"]["fields"]['securitygroup_noninher_fields'] = array (
    'name' => 'securitygroup_noninher_fields',
    'rname' => 'id',
    'relationship_fields'=>array('id' => 'securitygroup_noninherit_id', 'noninheritable' => 'securitygroup_noninheritable', 'primary_group' => 'securitygroup_primary_group'),
    'vname' => 'LBL_USER_NAME',
    'type' => 'relate',
    'link' => 'SecurityGroups',         
    'link_type' => 'relationship_info',
    'source' => 'non-db',
    'Importable' => false,
    'duplicate_merge'=> 'disabled',

);
        
        
$dictionary["User"]["fields"]['securitygroup_noninherit_id'] = array(
    'name' => 'securitygroup_noninherit_id',
    'type' => 'varchar',
    'source' => 'non-db',
    'vname' => 'LBL_securitygroup_noninherit_id',
);

$dictionary["User"]["fields"]['securitygroup_noninheritable'] = array(
    'name' => 'securitygroup_noninheritable',
    'type' => 'bool',
    'source' => 'non-db',
    'vname' => 'LBL_SECURITYGROUP_NONINHERITABLE',
);

$dictionary["User"]["fields"]['securitygroup_primary_group'] = array(
    'name' => 'securitygroup_primary_group',
    'type' => 'bool',
    'source' => 'non-db',
    'vname' => 'LBL_PRIMARY_GROUP',
);




	/**
	*	adding new fields to the module 
	*
	**/
$dictionary['User']['fields']['logged_in'] = array(
'name' => 'logged_in',
'vname' => 'LBL_LOGGED_IN',
'type' => 'bool',
'default' => 0,
'len' => '1',
'module' => 'Users',
'label' => 'LBL_LOGGED_IN' ,
'audited' => false,
'required' => false,
'importable' => true,
'studio' => false,
'comment' => 'User login status'
);
$dictionary['User']['fields']['availability'] = array(
'name' => 'availability',
'vname' => 'LBL_AVAILABILITY',
'type' => 'bool',
'default' => 0,
'len' => '1',
'module' => 'Users',
'label' => 'LBL_AVAILABILITY',
'audited' => false,
'required' => false,
'importable' => true,
'studio' => false,
'comment' => 'user call connected status'
); 
$dictionary['User']['fields']['extension'] = array(
'name' => 'extension',
'vname' => 'LBL_EXTENSION',
'type' => 'varchar',
'len' => '10',
'module' => 'Users',
'audited' => false,
'required' => false,
'importable' => true,
'comment' => 'User Call Accepting Extension',
);
$dictionary['User']['fields']['voip_access'] = array(
'required' => true,
'name' => 'voip_access',
'vname' => 'LBL_VOIP_ACCESS',
'type' => 'enum',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'len' => '20',
'size' => '20',
'studio' => 'false',
'options' => 'voip_access_dom',
);
$dictionary['User']['fields']['allow_phone_mobile'] = array(
'required' => true,
'name' => 'allow_phone_mobile',
'vname' => 'LBL_ALLOW_PHONE_MOBILE',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_phone_work'] = array(
'required' => true,
'name' => 'allow_phone_work',
'vname' => 'LBL_ALLOW_PHONE_WORK',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_phone_home'] = array(
'required' => true,
'name' => 'allow_phone_home',
'vname' => 'LBL_ALLOW_PHONE_HOME',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_phone_other'] = array(
'required' => true,
'name' => 'allow_phone_other',
'vname' => 'LBL_ALLOW_PHONE_OTHER',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_browser'] = array(
'required' => true,
'name' => 'allow_browser',
'vname' => 'LBL_ALLOW_BROWSER',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);	

?>